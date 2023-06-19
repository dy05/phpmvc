<?php

namespace RBAC\Controllers;


use RBAC\Models\User;

class EtudiantController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (! isset($_SESSION['auth'])) {
            header('Location:' . ROUTE . '/home');
        }
    }

    public function plannings()
    {
        $users = User::findAll();
        $this->render('users.php', [
            'page_name' => 'users'
        ]);
    }
}
