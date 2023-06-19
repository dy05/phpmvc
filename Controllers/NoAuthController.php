<?php

namespace RBAC\Controllers;

use Exception;
use RBAC\Models\User;

class NoAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirectIfConnect();
    }

    public function login()
    {
        $errors = array();
        $data = [
            'page_name' => 'login',
            'old' => $this->postData
        ];

        if (! empty($this->postData)) {
            if (empty($this->postData['email']) || empty($this->postData['password'])) {
                $errors[] = "Vous n'avez pas rempli tous les champs";
            }

            $user = User::findByEmail($this->postData['email']);

            if (! $user) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
            } elseif (! password_verify($this->postData['password'], $user->mdp)) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
            }

            if (empty($errors)) {
                $_SESSION['auth'] = $user;
                $_SESSION['flash'] = ['success' => 'Vous etes a present connecte'];
                header('Location:' . ROUTE . '/');
            }

            $data['errors'] = $errors;
        }

        $this->render('login.php', $data);
    }

    public function register()
    {
        $errors = [];

        if (!empty($this->postData)) {
            if (empty($this->postData['nom']) || !preg_match('/^[a-zA-Z0-9_]+$/', $this->postData['nom'])) {
                $errors['nom'] = "Vous n'avez pas entrer de nom";
            }

            if (empty($this->postData['prenom']) || !preg_match('/^[a-zA-Z0-9_]+$/', $this->postData['prenom'])) {
                $errors['prenom'] = "Vous n'avez pas entrer de prenom";
            }

            $email = $this->postData['prenom'] . '.' . $this->postData['nom'] . '@efrei.fr';

            $i = 0;
            do {
                if ($i > 0) {
                    $email = $this->postData['prenom'] . '.' . $this->postData['nom'] . $i . '@efrei.fr';
                }

                $user = User::staticQuery('SELECT id FROM users WHERE email = ?', [$email], true);
                if ($user) {
                    $i++;
                }
            } while($user);

            if (empty($this->postData['mdp'])) {
                $errors['mdp'] = "Vous n'avez pas entrer de mot de passe";
            }

            if (empty($this->postData['mdp_confirm'])) {
                $errors['mdp'] = "Vous n'avez pas entrer les deux mots de passe";
            }

            if ($this->postData['mdp'] !== $this->postData['mdp_confirm']) {
                $errors['mdp'] = "Les deux mots de passe ne correspondent pas";
            }

            if (empty($errors)) {
                try {
                    $password = password_hash($this->postData['mdp'], PASSWORD_BCRYPT);
                    $pdo = User::getPDO();
                    $req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, mdp = ?, email = ?");
                    $req->execute([$this->postData['nom'], $this->postData['prenom'], $password, $email]);
                    //$pdo = "INSERT INTO users SET username = ".$this->postData['usernamme'].", password=".$this->postData['password'].", email=".$this->postData['email'];
//                $user_id = $pdo->lastInsertId();
//                $http = str_replace('register.php', 'confirm.php?id='.$user_id.'&token='.$token, $_SERVER['HTTP_REFERER']);
//                mail($this->postData['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le lien ci dessous\n\n<a href='$http'>$http</a>");
//                ini_set('smtp_port', 1025);
//                ini_set('SMTP', 'localhost');
//                mail($this->postData['email'], 'Confirmation d\'inscription de votre compte', 'Vous venez bien d\'etre enregistre dans notre base de donnees, vous pouvez a present, vous connectez');
                    if ($pdo->lastInsertId() && $user = User::staticQuery('SELECT id FROM users WHERE id = ?', [$pdo->lastInsertId()], true)) {
                        $_SESSION['auth'] = $user;
                        $_SESSION['flash'] = ['success' => 'Vous etes a present connecte'];
                        header('Location:' . ROUTE . '/');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getMessage();
                }
            }
        }

        $old = $this->postData;
        unset($old['mdp']);
        unset($old['mdp_confirm']);

        $this->render('register.php', [
            'page_name' => 'register',
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
