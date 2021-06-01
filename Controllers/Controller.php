<?php

namespace DyosMvc\Controllers;


use DyosMvc\Models\Db;
use DyosMvc\Models\User;

class Controller{

    protected $db;
    protected $post;
    protected $session;
    protected $cookies;

    public function __construct()
    {
        $this->db = new Db();
        /**
         * Les 3 conditions suivantes permettent de sauvegarder dans les variables $post, $session, $cookies les  variables $_POST, $_SESSION, $_COOKIE
         */
        if (isset($_POST)) {
            $this->post = $_POST;
        }
        if (isset($_SESSION)) {
            $this->session = $_SESSION;
        }
        if (isset($_COOKIE)) {
            $this->cache = $_COOKIE;
        }
    }

    public function random_key($length)
    {
        $letters = '0123456789abcdefghijklmnopqrstuvwxyzQWERTYUIOPLKJHGFDSAZXCVBNM';
        return substr(str_shuffle(str_repeat($letters, $length)), 0, $length);
    }

    public function isUserCookie()
    {
        if (isset($_SESSION['iscookie']) && $_SESSION['iscookie']) {
            return null;
        }
        // Verifier si l'utilisateur est connecte
        if (isset($_COOKIE['remember'])) {
            $cookies = explode('//', $_COOKIE['remember']);
            $user_id = $cookies[0];
            $user = User::find(['id' => $user_id],'id, username, remember_token');
            $test = $user_id.'//'.$user->remember_token.sha1($user_id.'dy50');

            if ($test === $_COOKIE['remember']) {
                User::staticquery('UPDATE users SET confirmed_at = NOW() WHERE id = ?', [$user_id], true, false);
                $_SESSION['auth'] = $user->id;
                header('Location:' . ROUTE . '/account');
            } else {
                setcookie('remember', NULL, -1);
            }

            $_SESSION['iscookie'] = true;
        }
    }

    public function redirectIfConnect() {
        if (isset($_SESSION['auth'])) {
            header('Location:' . ROUTE . '/');
        }
    }

    public function redirectIfNotConnect() {
        if (! isset($_SESSION['auth'])) {
            header('Location:' . ROUTE . '/login');
        }

        $this->isUserCookie();
    }

    public function render($nom_de_la_page, $datas = [])
    {
        $page_name = '';
        if (isset($this->session['auth'])) {
            $user = User::find($this->session['auth']);
            $users = User::findAll();
            if (!in_array('users', $datas)) {
                $datas = array_merge($datas, [
                    'users' => $users,
                ]);
            }
            if (!in_array('auth_user', $datas)) {
                $datas = array_merge($datas, [
                    'auth_user' => $user,
                ]);
            }
        }

        // PERMET D'AVOIR ACCES AUX CLES DU TABLEAU => $KEY
        extract($datas, EXTR_OVERWRITE);
        // Permet d'enregistrer les donnees de la vues dans la variables $content pour afficher dans le template s'il existe
        ob_start();
//            require "../Views/".$nom_de_la_page;
            require VIEWS.''.$nom_de_la_page;
        $content = ob_get_clean();


        if (isset($template)) {
//            require "../Views/".$template;
            require VIEWS.''.$template;
        }else{
            echo $content;
        }
        // Fin de l'affichage de la vue
    }

    public function callErrorPage() {
        header('HTTP/1.1 404 Not Found');

        $this->render('error.php', [
            'page_name' => 'error'
        ]);
    }

}
