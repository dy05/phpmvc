<?php

namespace DyosMvc\Controllers;


use DyosMvc\Models\User;

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

        if (!empty($this->post)) {

            if (isset($this->post['resendconfirm'])) {
                var_dump($this->post);
                die();
            }

            if (empty($this->post['username']) || empty($this->post['password'])) {
                $errors['empty'] = "Vous n'avez pas rempli tous les champs";
            }

            $user = User::findUsername($this->post['username']);

            if (! $user) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
            } elseif (! password_verify($this->post['password'], $user->password)) {
                $errors['credentials'] = 'Identifiant ou mot de passe incorrect';
//                } elseif ($user && $user->confirmed_at === null && $user->username !== 'admin') {
//                    $errors['confirm_id'] = $user->id;
//                    $errors['confirm'] = true;
            }

            if (empty($errors)) {
                $_SESSION['auth'] = $user->id;
                $_SESSION['flash']['success'] = 'Vous etes a present connecte';
//                    if (isset($this->post['remember'])) {
//                        $token = $this->random_key(250);
//                        User::staticquery('UPDATE users SET remember_token = ? WHERE id = ?', [$token, $user->id], true, false);
//                        setcookie('remember', $user->id.'//'.$token.sha1($user->id.'dy50'), time() + 60 * 60 * 24 * 7);
//                    }

//                    User::staticquery('UPDATE users SET updated_at = NOW() WHERE id = ?', [$user->id], true, false);
                header('Location:' . ROUTE . '/');
            }
        }

        $this->render('login.php', [
            'page_name' => 'login',
            'errors' => $errors,
            'old' => $this->post
        ]);
    }

    public function register()
    {
        $errors = [];

        if (!empty($_POST)) {
            if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
                $errors['username'] = "Vous n'avez pas entrer de pseudo";
            } else {
                $user = User::staticquery('SELECT id FROM users WHERE username = ?', [$_POST['username']], true);
                if ($user) {
                    $errors['username'] = "Le nom d'utilisateur est deja utilise";
                }
            }

            if (empty($_POST['email'])) {
                $errors['email'] = "Vous n'avez pas entrer d'email";
            } else {
                $user = User::staticquery('SELECT id FROM users WHERE EMAIL_TECH = ?', [$_POST['email']], true);
                if ($user) {
                    $errors['email'] = "L'adresse email est deja utilise";
                }
            }
            if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Votre email est incorrect";
            }
            if (empty($_POST['password'])) {
                $errors['password'] = "Vous n'avez pas entrer de mot de passe";
            }
            if (empty($_POST['password_confirm'])) {
                $errors['password'] = "Vous n'avez pas entrer les deux mots de passe";
            }
            if ($_POST['password'] !== $_POST['password_confirm']) {
                $errors['password'] = "Les deux mots de passe ne correspondent pas";
            }

            if (empty($errors)) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//                $token = $this->random_key(60);
                $pdo = User::getstaticPDO();
                $req = $pdo->prepare("INSERT INTO users SET name = ?, username = ?, password = ?, email = ?");
//                $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, user_token = ?");
//                $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
                $req->execute([$_POST['username'], $password, $_POST['email']]);
                //$pdo = "INSERT INTO users SET username = ".$_POST['usernamme'].", password=".$_POST['password'].", email=".$_POST['email'];
//                $user_id = $pdo->lastInsertId();
//                $http = str_replace('register.php', 'confirm.php?id='.$user_id.'&token='.$token, $_SERVER['HTTP_REFERER']);
//                mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le li3n ci dessous\n\n<a href='$http'>$http</a>");
//                ini_set('smtp_port', 1025);
//                ini_set('SMTP', 'localhost');
//                mail($_POST['email'], 'Confirmation d\'inscription de votre compte', 'Vous venez bien d\'etre enregistre dans notre base de donnees, vous pouvez apresent vous connectez');
                $alert = true;
            }
        }


        $this->render('register.php', [
            'page_name' => 'register',
            'errors' => $errors
        ]);
    }
}
