<?php

namespace DyosMvc\Controllers;


use DyosMvc\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirectIfNotConnect();
    }

    public function users()
    {
        $users = User::findAll();
        $this->render('users.php', [
            'page_name' => 'users'
        ]);
    }

    public function add_user()
    {
        $user = User::find($this->session['auth']);
        $this->render('usersnew.php', [
            'page_name' => 'Add user'
        ]);
    }

    public function show_user($id)
    {
        $user = User::find($id);

        if (! $user) {
            return $this->callErrorPage();
        }

        var_dump($user);
        die();
        $this->render('usersshow.php', [
            'page_name' => 'Show user'
        ]);
    }

    public function logout()
    {
        die('loll');
        setcookie('remember', NULL, -1);
        session_destroy();
        header('Location:' . ROUTE . '/login');
    }
}
