<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->redirectIfNotConnect();
        $users = User::staticQuery("SELECT * FROM users");

        $this->render('users/index.php', [
            'page_name' => 'userspage',
            'users' => $users
        ]);
    }

    public function store()
    {
        $this->redirectIfNotConnect();
        $data = [
            'page_name' => 'usersnewpage',
            'old' => $this->postData,
            'roles' => static::getRoles(),
            'errors' => [],
        ];

        if (! empty($this->postData)) {
            $errors = [];

            $nom = $this->postData['nom'];
            $prenom = $this->postData['prenom'];
            $password = $this->postData['mdp'];
            $roleId = $this->postData['role_id'];

            if (empty($nom)) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            if (empty($prenom)) {
                $errors['prenom'] = "Le champs prenom est obligatoire.";
            }

            if (empty($roleId)) {
                $errors['role_id'] = "Le champs role est obligatoire.";
            }

            if (empty($password)) {
                $errors['mdp'] = "Vous n'avez pas entrer de mot de passe";
            }

            if (empty($this->postData['mdp_confirm'])) {
                $errors['mdp'] = "Vous n'avez pas entrer les deux mots de passe";
            }

            if ($password !== $this->postData['mdp_confirm']) {
                $errors['mdp'] = "Les deux mots de passe ne correspondent pas";
            }

//            $email = $this->postData['email'];
            try {
                $email = static::getEmail($nom, $prenom);

                if (empty($errors)) {
                    $pdo = User::getPDO();
                    $req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, email = ?, mdp = ?");
                    $req->execute([
                        $nom,
                        $prenom,
                        $email,
                        password_hash($password, PASSWORD_BCRYPT),
                    ]);

                    if ($pdo->lastInsertId()) {
                        $_SESSION['flash'] = ['success' => "l'utilisateur a bien été ajouté."];
                        header('Location:' . ROUTE . '/users');
                    }
                }
            } catch (Exception $exc) {
                $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
            }

            $data['errors'] = $errors;
        }

        $this->render('users/users_create.php', $data);
    }

    public function show(int $id, bool $withTrashed = true)
    {
        $user = $withTrashed
            ? User::staticQuery('SELECT * FROM users WHERE id = ?', [$id], true)
            : User::staticQuery('SELECT * FROM users WHERE deleted_at IS NULL AND id = ?', [$id], true);

        if (! $user) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'user' => $user,
        ];

        $this->render('users/users_show.php', $data);
    }

    public function edit(int $id = null)
    {
        $user = User::staticQuery('SELECT * FROM users WHERE id = ?', [$id], true);
        if (! $user) {
            $this->callErrorPage();
            return;
        }

        $data = [
            'user' => $user,
            'roles' => static::getRoles(),
            'errors' => [],
        ];

        if (! empty($this->postData)) {
            $errors = [];

            $nom = $this->postData['nom'];
            $prenom = $this->postData['prenom'];
            $roleId = $this->postData['role_id'];
            $password = $this->postData['mdp'];
            if (empty($nom)) {
                $errors['nom'] = "Le champs nom est obligatoire.";
            }

            if (empty($prenom)) {
                $errors['prenom'] = "Le champs prenom est obligatoire.";
            }

            if (empty($roleId)) {
                $errors['role_id'] = "Le champs role est obligatoire.";
            }

            if (! empty($password) && empty($this->postData['mdp_confirm'])) {
                $errors['mdp'] = "Vous n'avez pas entrer les deux mots de passe";
            }

            if (! empty($password) && $password !== $this->postData['mdp_confirm']) {
                $errors['mdp'] = "Les deux mots de passe ne correspondent pas";
            }

//            $email = $this->postData['email'];
            try {
                $email = static::getEmail($nom, $prenom);

                if (empty($errors)) {
                    $fields = [
                        ':nom' => $nom,
                        ':prenom' => $prenom,
                        ':email' => $email,
                        ':role_id' => $roleId,
                        ':id' => $id,
                    ];

                    $sqlString = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id";
                    if (! empty($password)) {
                        $sqlString .= ", mdp = :mdp";
                        $fields[':mdp'] = password_hash($password, PASSWORD_BCRYPT);
                    }

                    $req = User::getPDO()->prepare($sqlString . ' WHERE id = :id');
                    $result = $req->execute($fields);

                    if ($result) {
                        $_SESSION['flash'] = ['success' => "l'utilisateur a bien été modifié."];
                        header('Location:' . ROUTE . '/users');
                    }
                }
            } catch (Exception $exc) {
                $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue. ' : $exc->getMessage();
            }

            $data['errors'] = $errors;
        }

        $this->render('users/users_edit.php', $data);
    }

    public function delete(int $id = null)
    {
        $user = User::staticQuery('SELECT * FROM users WHERE deleted_at IS NULL AND id = ?', [$id], true);
        if (! $user) {
            $this->callErrorPage();
            return;
        }

        try {
            $req = User::getPDO()->query('UPDATE users SET deleted_at = CURRENT_DATE WHERE id = ' . $id);
            if ($req->execute()) {
                $_SESSION['flash'] = ['success' => "l'utilisateur a été supprimé avec succès."];
            } else {
                $_SESSION['flash'] = ['error' => 'Erreur innatendue.'];
            }
        } catch (Exception $exc) {
            $_SESSION['flash'] = ['error' => $exc->getCode() > 0 ? 'Erreur innatendue.' : $exc->getMessage()];
        }

        if ($id === (int) $this->session['auth']->id) {
            static::signOut();
        }

        header('Location:' . ROUTE . '/users');
    }

    public function destroy(int $id = null)
    {
        $user = User::staticQuery('SELECT * FROM users WHERE id = ?', [$id], true);
        if (! $user) {
            $this->callErrorPage();
            return;
        }

        try {
            $req = User::getPDO()->query('DELETE FROM users WHERE id = ' . $id);
            if ($req->execute()) {
                $_SESSION['flash'] = ['success' => "l'utilisateur a été supprimé avec succès."];
            } else {
                $_SESSION['flash'] = ['error' => 'Erreur innatendue.'];
            }
        } catch (Exception $exc) {
            $_SESSION['flash'] = ['error' => $exc->getCode() > 0 ? 'Erreur innatendue.' : $exc->getMessage()];
        }

        header('Location:' . ROUTE . '/users');
    }
}
