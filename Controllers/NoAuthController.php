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

    public function contact()
    {
        $this->render('contact.php', [
            'page_name' => 'contact'
        ]);
    }

    public function login()
    {
        $errors = array();
        $data = [
            'page_name' => 'login',
            'old' => self::$postData
        ];

        if (! empty(self::$postData)) {
            if (empty(self::$postData['email']) || empty(self::$postData['password'])) {
                $errors[] = "Vous n'avez pas rempli tous les champs";
            }

            $user = User::findByEmail(self::$postData['email']);

            if (! $user) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
            } elseif (! password_verify(self::$postData['password'], $user->mdp)) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
            }

            if (empty($errors)) {
                $_SESSION['auth'] = $user;
                $_SESSION['flash']['success'] = 'Vous etes a present connecte';
                header('Location:' . ROUTE . '/');
            }

            $data['errors'] = $errors;
        }

        $this->render('login.php', $data);
    }

    public function register()
    {
        $errors = [];

        if (!empty(self::$postData)) {
            if (empty(self::$postData['nom']) || !preg_match('/^[a-zA-Z0-9_]+$/', self::$postData['nom'])) {
                $errors['nom'] = "Vous n'avez pas entrer de nom";
            }

            if (empty(self::$postData['prenom']) || !preg_match('/^[a-zA-Z0-9_]+$/', self::$postData['prenom'])) {
                $errors['prenom'] = "Vous n'avez pas entrer de prenom";
            }

            $email = self::$postData['prenom'] . '.' . self::$postData['nom'] . '@efrei.fr';

            $i = 0;
            do {
                if ($i > 0) {
                    $email = self::$postData['prenom'] . '.' . self::$postData['nom'] . $i . '@efrei.fr';
                }

                $user = User::staticQuery('SELECT id FROM users WHERE email = ?', [$email], true);
                if ($user) {
                    $i++;
                }
            } while($user);

            if (empty(self::$postData['mdp'])) {
                $errors['mdp'] = "Vous n'avez pas entrer de mot de passe";
            }

            if (empty(self::$postData['mdp_confirm'])) {
                $errors['mdp'] = "Vous n'avez pas entrer les deux mots de passe";
            }

            if (self::$postData['mdp'] !== self::$postData['mdp_confirm']) {
                $errors['mdp'] = "Les deux mots de passe ne correspondent pas";
            }

            if (empty($errors)) {
                try {
                    $password = password_hash(self::$postData['mdp'], PASSWORD_BCRYPT);
                    $pdo = User::getPDO();
                    $req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, mdp = ?, email = ?");
                    $req->execute([self::$postData['nom'], self::$postData['prenom'], $password, $email]);
                    //$pdo = "INSERT INTO users SET username = ".self::$postData['usernamme'].", password=".self::$postData['password'].", email=".self::$postData['email'];
//                $user_id = $pdo->lastInsertId();
//                $http = str_replace('register.php', 'confirm.php?id='.$user_id.'&token='.$token, $_SERVER['HTTP_REFERER']);
//                mail(self::$postData['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le lien ci dessous\n\n<a href='$http'>$http</a>");
//                ini_set('smtp_port', 1025);
//                ini_set('SMTP', 'localhost');
//                mail(self::$postData['email'], 'Confirmation d\'inscription de votre compte', 'Vous venez bien d\'etre enregistre dans notre base de donnees, vous pouvez a present, vous connectez');
                    if ($pdo->lastInsertId() && $user = User::staticQuery('SELECT id FROM users WHERE id = ?', [$pdo->lastInsertId()], true)) {
                        $_SESSION['auth'] = $user;
                        $_SESSION['flash']['success'] = 'Vous etes a present connecte';
                        header('Location:' . ROUTE . '/');
                    }
                } catch (Exception $exc) {
                    $errors['error'] = $exc->getMessage();
                }
            }
        }

        $old = self::$postData;
        unset($old['mdp']);
        unset($old['mdp_confirm']);

        $this->render('register.php', [
            'page_name' => 'register',
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
