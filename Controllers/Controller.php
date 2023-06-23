<?php

namespace RBAC\Controllers;

use RBAC\Models\Course;
use RBAC\Models\Role;
use RBAC\Models\User;

abstract class Controller
{
    protected $postData = [];
    protected $session = [];
    protected $cookies = [];

    public function __construct()
    {
        /**
         * Les 3 conditions suivantes permettent de sauvegarder dans les variables $post, $session, $cookies les  variables $_POST, $_SESSION, $_COOKIE
         */
        $data = $_POST;
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $this->postData[$key] = is_array($value) ? $value : trim($value);
            }
        }

        if (isset($_SESSION)) {
            $this->session = $_SESSION;
        }

        if (isset($_COOKIE)) {
            $this->cookies = $_COOKIE;
        }
    }

    /**
     * @param string $text
     * @param string $divider
     *
     * @return string
     */
    public static function slugify(string $text, string $divider = '-'): string
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @param string $nom
     * @param string $prenom
     *
     * @return string
     */
    public static function getEmail(string $nom, string $prenom): string
    {
        $email = static::slugify($prenom) . '.' . static::slugify($nom) . '@efrei.fr';

        $i = 0;
        do {
            if ($i > 0) {
                $email = $prenom . '.' . $nom . $i . '@efrei.fr';
            }

            $user = User::staticQuery('SELECT id FROM users WHERE email = ?', [$email], true);
            if ($user) {
                $i++;
            }
        } while($user);

        return $email;
    }

    public function random_key($length)
    {
        $letters = '0123456789abcdefghijklmnopqrstuvwxyzQWERTYUIOPLKJHGFDSAZXCVBNM';
        return substr(str_shuffle(str_repeat($letters, $length)), 0, $length);
    }

    public function isUserCookie()
    {
        if (isset($_SESSION['isCookie']) && $_SESSION['isCookie']) {
            return null;
        }
        // Verifier si l'utilisateur est connecté
        if (isset($_COOKIE['remember'])) {
            $cookies = explode('//', $_COOKIE['remember']);
            $user_id = $cookies[0];
//            $user = User::find(['id' => $user_id],'id, username, remember_token');
            $user = User::find(['id' => $user_id]);
            $test = $user_id . '//' . $user->remember_token . sha1($user_id . time());

            if ($test === $_COOKIE['remember']) {
//                User::staticQuery('UPDATE users SET confirmed_at = NOW() WHERE id = ?', [$user_id], true, false);
                $_SESSION['auth'] = $user;
                header('Location:' . ROUTE . '/');
            } else {
                setcookie('remember', NULL, -1);
            }

            $_SESSION['isCookie'] = true;
        }
    }

    public function redirectIfConnect()
    {
        if (isset($_SESSION['auth'])) {
            header('Location:' . ROUTE . '/');
        }
    }

    public function redirectIfNotConnect()
    {
        if (! isset($_SESSION['auth'])) {
            header('Location:' . ROUTE . '/login');
        }

        $this->isUserCookie();
    }

    public function render($page_name, $datas = [])
    {
        if (isset($this->session['auth'])) {
            $user = $this->session['auth'];

            if ($user) {
                $datas = array_merge($datas, [
                    'authUser' => $user,
                ]);
            }
        }

        if (isset($this->session['flash'])) {
            $alert = $this->session['flash']['success'];
            if ($alert) {
                unset($_SESSION['flash']);
                $datas = array_merge($datas, [
                    'alert' => $alert,
                ]);
            }
        }

        unset($datas['page_name']);

        // PERMET D'AVOIR ACCES AUX CLES DU TABLEAU => $KEY
        extract($datas);
        // Permet d'enregistrer les donnees de la vue dans les variables $content pour afficher dans le template s'il existe
        ob_start();
        require VIEWS . '' . $page_name;
        $content = ob_get_clean();

        if (isset($template)) {
            require VIEWS . '' . $template;
        } else {
            echo $content;
        }
        // Fin de l'affichage de la vue
    }

    public function callErrorPage()
    {
        header('HTTP/1.1 404 Not Found');

        $this->render('error.php', [
            'page_name' => 'error'
        ]);
    }

    public static function signOut()
    {
        setcookie('remember', NULL, -1);
        session_destroy();
        header('Location:' . ROUTE . '/login');
    }

    /**
     * @return string[]
     */
    public static function getRoles(): array
    {
        return Role::staticQuery('SELECT * FROM roles');
    }

    public static function getCourses()
    {
        return Course::staticQuery('SELECT * FROM courses');
    }

    /**
     * @param int $id
     *
     * @return User|mixed
     */
    public static function getActiveUser(int $id)
    {
        return User::staticQuery('SELECT * FROM users WHERE id = ?', [$id], true);
    }
}
