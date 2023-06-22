<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\Salle;

class SalleController extends Controller
{
    public function index()
    {
        $this->redirectIfNotConnect();
        $salles = Salle::staticQuery("SELECT * FROM salles");

        $this->render('salles/index.php', [
            'page_name' => 'sallespage',
            'salles' => $salles
        ]);
    }

    public function store()
    {
        $this->redirectIfNotConnect();
        $errors = array();
        $data = [
            'page_name' => 'sallesnewpage',
            'old' => $this->postData
        ];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            if (empty($errors)) {
                try {
                    $pdo = Salle::getPDO();
                    $capacite = $this->postData['capacite'];
                    if ($capacite && ! is_numeric($capacite)) {
                        $errors['capacite'] = "Le champs capacite doit etre un entier valide.";
                    }

                    $req = $pdo->prepare("INSERT INTO salles SET nom = ?, capacite = ?");
                    $req->execute([$this->postData['nom'], $capacite]);
                    if ($pdo->lastInsertId()) {
                        $_SESSION['flash'] = ['success' => 'la salle a bien été ajoutée.'];
                        header('Location:' . ROUTE . '/salles');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('salles/salles_create.php', $data);
    }

    public function show(int $id = null)
    {
        $salle = Salle::staticQuery('SELECT * FROM salles WHERE id = ?', [$id], true);
        if (! $salle) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'salle' => $salle,
        ];

        $this->render('salles/salles_show.php', $data);
    }

    public function edit(int $id = null)
    {
        $salle = Salle::staticQuery('SELECT * FROM salles WHERE id = ?', [$id], true);
        if (! $salle) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'salle' => $salle,
        ];

        $errors = [];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $capacite = $this->postData['capacite'];
            if ($capacite && ! is_numeric($capacite)) {
                $errors['capacite'] = "Le champs capacite doit etre un entier valide.";
            }

            if (empty($errors)) {
                try {
                    $pdo = Salle::getPDO();
                    $req = $pdo->prepare("UPDATE salles SET nom = :nom, capacite = :capacite WHERE id = :id");
                    $result = $req->execute([
                        ':nom' => $this->postData['nom'],
                        ':capacite' => $capacite,
                        ':id' => $id,
                    ]);

                    if ($result) {
                        $_SESSION['flash'] = ['success' => 'la salle a bien été modifiée.'];
                        header('Location:' . ROUTE . '/salles');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('salles/salles_edit.php', $data);
    }

    public function delete(int $id = null)
    {
        $salle = Salle::staticQuery('SELECT * FROM salles WHERE id = ?', [$id], true);
        if (! $salle) {
            $this->callErrorPage();
            return;
        }

        try {
            $req = Salle::getPDO()->query('DELETE FROM salles WHERE id = ' . $id);
            if ($req->execute()) {
                $_SESSION['flash'] = ['success' => 'la salle a été supprimée avec succès.'];
            } else {
                $_SESSION['flash'] = ['error' => 'Erreur innatendue.'];
            }
        } catch (Exception $exc) {
            $_SESSION['flash'] = ['error' => $exc->getCode() > 0 ? 'Erreur innatendue.' : $exc->getMessage()];
        }

        header('Location:' . ROUTE . '/salles');
    }
}
