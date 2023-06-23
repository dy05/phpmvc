<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $this->redirectIfNotConnect();
        $courses = Course::staticQuery("SELECT * FROM courses");

        $this->render('courses/index.php', [
            'page_name' => 'courspage',
            'courses' => $courses
        ]);
    }

    public function store()
    {
        $this->redirectIfNotConnect();
        $errors = array();
        $data = [
            'page_name' => 'coursnewpage',
            'old' => $this->postData
        ];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $duree = $this->postData['duree'] ?? null;
            if ($duree && ! is_numeric($duree)) {
                if (isset($data['old']['duree'])) {
                    unset($data['old']['duree']);
                }

                $errors['duree'] = "Le champs duree doit etre un entier valide.";
            }

            $niveau = $this->postData['niveau'];
            if ($niveau && ! is_numeric($niveau)) {
                unset($data['old']['niveau']);
                $errors['niveau'] = "Le champs niveau doit etre un entier valide.";
            }

            if (empty($errors)) {
                try {
                    $pdo = Course::getPDO();
                    $code = $this->postData['code'];
                    if (empty($code)) {
                        $code = self::slugify($this->postData['nom']);
                    }

                    $req = $pdo->prepare("INSERT INTO courses SET nom = ?, duree = ?, niveau = ?, code = ?");
                    $req->execute([$this->postData['nom'], $duree !== '' ? $duree : null, $niveau !== '' ? $niveau : null, $code]);
                    if ($pdo->lastInsertId()) {
                        $_SESSION['flash'] = ['success' => 'le cours a bien ete ajoute.'];
                        header('Location:' . ROUTE . '/cours');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('courses/cours_create.php', $data);
    }

    public function show(int $id = null)
    {
        $course = Course::staticQuery('SELECT * FROM courses WHERE id = ?', [$id], true);
        if (! $course) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'course' => $course,
        ];

        $this->render('courses/cours_show.php', $data);
    }

    public function edit(int $id = null)
    {
        $course = Course::staticQuery('SELECT * FROM courses WHERE id = ?', [$id], true);
        if (! $course) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'course' => $course,
        ];

        $errors = [];

        if (! empty($this->postData)) {
            if (empty($this->postData['nom'])) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $duree = $this->postData['duree'] ?? null;
            if ($duree && ! is_numeric($duree)) {
                $errors['duree'] = "Le champs duree doit etre un entier valide.";
            }

            $niveau = $this->postData['niveau'];
            if ($niveau && ! is_numeric($niveau)) {
                $errors['niveau'] = "Le champs niveau doit etre un entier valide.";
            }

            if (empty($errors)) {
                try {
                    $pdo = Course::getPDO();
                    $code = $this->postData['code'];
                    if (empty($code)) {
                        $code = self::slugify($this->postData['nom']);
                    }

                    $req = $pdo->prepare("UPDATE courses SET nom = :nom, duree = :duree, niveau = :niveau, code = :code WHERE id = :id");
                    $result = $req->execute([
                        ':nom' => $this->postData['nom'],
                        ':duree' => $duree !== '' ? $duree : null,
                        ':niveau' => $niveau !== '' ? $niveau : null,
                        ':code' => $code,
                        ':id' => $id,
                    ]);

                    if ($result) {
                        $_SESSION['flash'] = ['success' => 'le cours a bien été modifié.'];
                        header('Location:' . ROUTE . '/cours');
                    }
                } catch (Exception $exc) {
//                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
                    $errors['error'] = $exc->getMessage();
                }
            }

            $data['errors'] = $errors;
        }

        $this->render('courses/cours_edit.php', $data);
    }

    public function delete(int $id = null)
    {
        $course = Course::staticQuery('SELECT * FROM courses WHERE id = ?', [$id], true);
        if (! $course) {
            $this->callErrorPage();
            return;
        }

        try {
            $req = Course::getPDO()->query('DELETE FROM courses WHERE id = ' . $id);
            if ($req->execute()) {
                $_SESSION['flash'] = ['success' => 'le cours a ete supprime avec succes.'];
            } else {
                $_SESSION['flash'] = ['error' => 'Erreur innatendue.'];
            }
        } catch (Exception $exc) {
//            $_SESSION['flash'] = ['error' => $exc->getMessage()];
            $_SESSION['flash'] = ['error' => $exc->getCode() > 0 ? 'Erreur innatendue.' : $exc->getMessage()];
        }

        header('Location:' . ROUTE . '/cours');
    }
}
