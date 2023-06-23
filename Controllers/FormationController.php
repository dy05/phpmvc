<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $this->redirectIfNotConnect();
        $formations = Formation::staticQuery("SELECT formations.*, group_concat(DISTINCT courses.nom SEPARATOR ', ') as courses, group_concat(DISTINCT courses.id SEPARATOR ', ') as courseIds FROM formations LEFT JOIN formation_course ON formations.id = formation_course.formation_id LEFT JOIN courses ON courses.id = formation_course.course_id GROUP BY formations.id");

        $this->render('formations/index.php', [
            'page_name' => 'formationspage',
            'formations' => $formations
        ]);
    }

    public function store()
    {
        $this->redirectIfNotConnect();
        $errors = array();
        $data = [
            'page_name' => 'formationsnewpage',
            'courses' => static::getCourses(),
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

            $courseIds = $this->postData['courses'] ?? [];
            if (! count($courseIds)) {
                $errors['courseIds'] = "Vous devez selectionner au moins un cours valide.";
            }

            $niveau = $this->postData['niveau'] ?? '';
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
                    if ($id = $pdo->lastInsertId()) {
                        if (count($courseIds)) {
                            $fields = [];
                            $values = '';
                            foreach ($courseIds as $courseId) {
                                $fields[] = $id;
                                $fields[] = $courseId;
                                $values .= '(?, ?), ';
                            }

                            Formation::getPDO()->prepare('INSERT INTO formation_course (formation_id, course_id) VALUES ' . substr($values, -2), $fields);
                        }

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
        $formation = $this->getFormation($id);
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
        $formation = $this->getFormation($id);
        if (! $formation) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'formation' => $formation,
            'formationCourseIds' => explode(', ', $formation->courseIds ?? ''),
            'courses' => static::getCourses(),
        ];

        $errors = [];

        if (! empty($this->postData)) {
            $nom = $this->postData['nom'];
            if (empty($nom)) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            $duree = $this->postData['duree'] ?? null;
            if ($duree && ! is_numeric($duree)) {
                $errors['duree'] = "Le champs duree doit etre un entier valide.";
            }

            $courseIds = $this->postData['courses'] ?? [];
            if (! count($courseIds)) {
                $errors['courseIds'] = "Vous devez selectionner au moins un cours valide.";
            }

            $niveau = $this->postData['niveau'] ?? '';
            if (! empty($niveau) && ! in_array($niveau, ['Bac + 1', 'Bac + 2', 'Bac + 3'])) {
                $errors['niveau'] = "Le champs niveau n'est pas valide.";
            }

            if (empty($errors)) {
                try {
                    $code = $this->postData['code'];
                    if (empty($code)) {
                        $code = self::slugify($nom);
                    }

                    $req = Formation::getPDO()->prepare("UPDATE formations SET nom = :nom, duree = :duree, niveau = :niveau, code = :code WHERE id = :id");
                    $result = $req->execute([
                        ':nom' => $nom,
                        ':duree' => $duree !== '' ? $duree : null,
                        ':niveau' => $niveau !== '' ? $niveau : null,
                        ':code' => $code,
                        ':id' => $id,
                    ]);

                    if ($result) {
                        $formationCourses = Formation::staticQuery('SELECT id, course_id FROM formation_course WHERE formation_id = ?', [$id]);
                        $deletedFormationCourseIds = [];
                        foreach ($formationCourses as $formationCourse) {
                            if (($key = array_search($formationCourse->course_id, $courseIds)) > -1) {
                                unset($courseIds[$key]);
                            } else {
                                $deletedFormationCourseIds[] = $formationCourse->id;
                            }
                        }

                        if (count($deletedFormationCourseIds)) {
                            Formation::staticQuery('DELETE FROM formation_course WHERE id IN (' . join(', ', $deletedFormationCourseIds) . ')');
                        }

                        if (count($courseIds)) {
                            $fields = [];
                            $values = '';
                            foreach ($courseIds as $courseId) {
                                $fields[] = $id;
                                $fields[] = $courseId;
                                $values .= '(?, ?), ';
                            }

                            Formation::staticQuery('INSERT INTO formation_course (formation_id, course_id) VALUES ' . substr($values, 0, -2), $fields);
                        }

                        $_SESSION['flash'] = ['success' => 'la formation a bien été modifiée.'];
                        header('Location:' . ROUTE . '/formations');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
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

    private function getFormation(int $id)
    {
        $sqlQuery = "SELECT formations.*, 
         group_concat(DISTINCT courses.nom SEPARATOR ', ') as courses, 
         group_concat(DISTINCT courses.id SEPARATOR ', ') as courseIds 
         FROM formations 
         LEFT JOIN formation_course ON formations.id = formation_course.formation_id 
         LEFT JOIN courses ON courses.id = formation_course.course_id 
         WHERE formations.id = ?";

         return Formation::staticQuery($sqlQuery, [$id], true);
    }
}
