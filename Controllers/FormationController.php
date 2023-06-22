<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $this->redirectIfNotConnect();
        $formation = Formation::staticQuery("SELECT * FROM formations");

        $this->render('formations/index.php', [
            'page_name' => 'formationspage',
            'formations' => $formation
        ]);
    }

    public function store()
    {
        $this->redirectIfNotConnect();
        $errors = array();
        $data = [
            'page_name' => 'formationsnewpage',
            'old' => $this->postData
        ];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $duree = $this->postData['duree'];
            if ($duree && ! is_numeric($duree)) {
                unset($data['old']['duree']);
                $errors['duree'] = "Le champs duree doit etre un entier valide.";
            }

            $niveau = $this->postData['niveau'];
            if (! empty($niveau) && ! in_array($niveau, ['Bac + 1', 'Bac + 2', 'Bac + 3'])) {
                $errors['niveau'] = "Le champs niveau n'est pas valide.";
            }

            if (empty($errors)) {
                try {
                    $pdo = Formation::getPDO();
                    $code = $this->postData['code'];
                    if (empty($code)) {
                        $code = self::slugify($this->postData['nom']);
                    }

                    $req = $pdo->prepare("INSERT INTO formations SET nom = ?, duree = ?, niveau = ?, code = ?");
                    $req->execute([$this->postData['nom'], $duree !== '' ? $duree : null, $niveau !== '' ? $niveau : null, $code]);
                    if ($pdo->lastInsertId()) {
                        $_SESSION['flash'] = ['success' => 'la formation a bien été ajoutée.'];
                        header('Location:' . ROUTE . '/formations');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('formations/formations_create.php', $data);
    }

    public function show(int $id = null)
    {
        $formation = Formation::staticQuery('SELECT * FROM formations WHERE id = ?', [$id], true);
        if (! $formation) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'formation' => $formation,
        ];

        $this->render('formations/formations_show.php', $data);
    }

    public function edit(int $id = null)
    {
        $formation = Formation::staticQuery('SELECT * FROM formations WHERE id = ?', [$id], true);
        if (! $formation) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'formation' => $formation,
        ];

        $errors = [];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $duree = $this->postData['duree'];
            if ($duree && ! is_numeric($duree)) {
                $errors['duree'] = "Le champs duree doit etre un entier valide.";
            }

            $niveau = $this->postData['niveau'];
            if (empty($niveau)) {
                $niveau = self::slugify($this->postData['niveau']);
            }

            if (empty($errors)) {
                try {
                    $pdo = Formation::getPDO();
                    $code = $this->postData['code'];
                    if (empty($code)) {
                        $code = self::slugify($this->postData['nom']);
                    }

                    $req = $pdo->prepare("UPDATE formations SET nom = :nom, duree = :duree, niveau = :niveau, code = :code WHERE id = :id");
                    $result = $req->execute([
                        ':nom' => $this->postData['nom'],
                        ':duree' => $duree !== '' ? $duree : null,
                        ':niveau' => $niveau !== '' ? $niveau : null,
                        ':code' => $code,
                        ':id' => $id,
                    ]);

                    if ($result) {
                        $_SESSION['flash'] = ['success' => 'la formation a bien été modifiée.'];
                        header('Location:' . ROUTE . '/formations');
                    }
                } catch (Exception $exc) {
//                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                    $errors['error'] = $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('formations/formations_edit.php', $data);
    }

    public function delete(int $id = null)
    {
        $formation = Formation::staticQuery('SELECT * FROM formations WHERE id = ?', [$id], true);
        if (! $formation) {
            $this->callErrorPage();
            return;
        }

        try {
            $req = Formation::getPDO()->query('DELETE FROM formations WHERE id = ' . $id);
            if ($req->execute()) {
                $_SESSION['flash'] = ['success' => 'la formation a été supprimée avec succès.'];
            } else {
                $_SESSION['flash'] = ['error' => 'Erreur innatendue.'];
            }
        } catch (Exception $exc) {
            $_SESSION['flash'] = ['error' => $exc->getCode() > 0 ? 'Erreur innatendue.' : $exc->getMessage()];
        }

        header('Location:' . ROUTE . '/formations');
    }
}
