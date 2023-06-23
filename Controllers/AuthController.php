<?php

namespace RBAC\Controllers;


use Exception;
use RBAC\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirectIfNotConnect();
    }

    public function user()
    {
        $this->render('account.php', [
            'page_name' => 'account',
            'user' => static::getActiveUser($this->session['auth']->id),
        ]);
    }

    public function updateUser()
    {
        $data = [
            'page_name' => 'account',
            'roles' => static::getRoles(),
            'errors' => [],
            'user' => static::getActiveUser($this->session['auth']->id),
        ];

        if (! empty($this->postData)) {
            $errors = [];
            $nom = $this->postData['nom'];
            $prenom = $this->postData['prenom'];
            $password = $this->postData['mdp'];
            $roleId = $this->postData['role_id'];

            if (empty($nom) || !preg_match('/^[a-zA-Z0-9_]+$/', $nom)) {
                $errors['nom'] = "Vous n'avez pas entrer de nom.";
            }

            if (empty($prenom) || !preg_match('/^[a-zA-Z0-9_]+$/', $prenom)) {
                $errors['prenom'] = "Vous n'avez pas entrer de prenom.";
            }

            if (empty($roleId)) {
                $errors['role_id'] = "Le champs role est obligatoire.";
            }

            try {
//                $email = static::getEmail($nom, $prenom);
                $email = $data['user']->email;

                if (! empty($password) && empty($this->postData['mdp_confirm'])) {
                    $errors['mdp'] = "Vous n'avez pas entrer les deux mots de passe.";
                }

                if (! empty($password) && $password !== $this->postData['mdp_confirm']) {
                    $errors['mdp'] = "Les deux mots de passe ne correspondent pas.";
                }

                if (empty($errors)) {
                    $fields = [
                        $nom,
                        $prenom,
                        $email,
                        $roleId,
                    ];

                    $sqlString = "UPDATE users SET nom = ?, prenom = ?, email = ?, role_id = ?";
                    if (! empty($password)) {
                        $sqlString .= ", mdp = ?";
                        $fields[] = password_hash($password, PASSWORD_BCRYPT);
                    }

                    $req = User::getPDO()->prepare($sqlString . ' WHERE id = ?');
                    $fields[] = $data['user']->id;

                    if ($req->execute($fields)) {
                        $_SESSION['flash'] = ['success' => 'Compte modifie avec succes.'];
                        $_SESSION['auth'] = static::getActiveUser($this->session['auth']->id);
                        header('Location:' . ROUTE . '/');
                    }
                }
            } catch (Exception $exc) {
                $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue' : $exc->getMessage();
            }

            $data['errors'] = $errors;
        }

        $this->render('account_edit.php', $data);
    }

    public function logout()
    {
        static::signOut();
    }
}
