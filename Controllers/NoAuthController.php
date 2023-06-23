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
            $email = $this->postData['email'];
            $password = $this->postData['password'];
            if (empty($email) || empty($password)) {
                $errors[] = "Vous n'avez pas rempli tous les champs";
            }

            $sqlString = "SELECT users.* FROM users WHERE email = ?";
            $query = User::getPDO()->prepare($sqlString);
            $query->execute([$email]);
            $user = $query->fetch();

            if (! $user || ! password_verify($password, $user->mdp)) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect.';
            } elseif ($user->deleted_at) {
                $errors['credentials'] = 'Votre compte a ete supprime. '
                    . 'Contactez un administrateur afin de restaurer votre compte.';
            }

            if (empty($errors)) {
                $_SESSION['auth'] = $user;
                $_SESSION['flash'] = ['success' => 'Vous etes a present connecte.'];
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
            $nom = $this->postData['nom'];
            $prenom = $this->postData['prenom'];
            if (empty($nom) || !preg_match('/^[a-zA-Z0-9_]+$/', $nom)) {
                $errors['nom'] = "Vous n'avez pas entrer de nom";
            }

            if (empty($prenom) || !preg_match('/^[a-zA-Z0-9_]+$/', $prenom)) {
                $errors['prenom'] = "Vous n'avez pas entrer de prenom";
            }

            try {
                $email = static::getEmail($nom, $prenom);

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
                    $password = password_hash($this->postData['mdp'], PASSWORD_BCRYPT);
                    $pdo = User::getPDO();
                    $req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, mdp = ?, email = ?");
                    $req->execute([$nom, $prenom, $password, $email]);
                    //$pdo = "INSERT INTO users SET
                    // username = ".$this->postData['username'].", password=".$password.", email=".$email;
//                $user_id = $pdo->lastInsertId();
//                $http = str_replace('register.php',
// 'confirm.php?id='.$user_id.'&token='.$token, $_SERVER['HTTP_REFERER']);
//                mail($email, 'Confirmation de votre compte',
// "Afin de valider votre compte, merci de cliquer sur le lien ci dessous\n\n<a href='$http'>$http</a>");
//                ini_set('smtp_port', 1025);
//                ini_set('SMTP', 'localhost');
//                mail($email, 'Confirmation d\'inscription de votre compte',
// 'Vous venez bien d\'etre enregistre dans notre base de donnees, vous pouvez à present, vous connectez');

                    $user = User::staticQuery(
                        'SELECT id FROM users WHERE id = ?',
                        [$pdo->lastInsertId()],
                        true
                    );

                    if ($pdo->lastInsertId() && $user) {
                        $_SESSION['auth'] = $user;
                        $_SESSION['flash'] = ['success' => 'Vous etes a present connecte'];
                        header('Location:' . ROUTE . '/');
                    }
                }
            } catch (Exception $exc) {
                $errors['error'] = $exc->getCode() > 0 ? 'Erreur innatendue' : $exc->getMessage();
            }
        }

        $old = $this->postData;

        if (isset($old['mdp'])) {
            unset($old['mdp']);
        }

        if (isset($old['mdp_confirm'])) {
            unset($old['mdp_confirm']);
        }

        $this->render('register.php', [
            'page_name' => 'register',
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
