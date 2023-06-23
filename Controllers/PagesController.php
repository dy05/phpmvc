<?php

namespace RBAC\Controllers;

use RBAC\Models\User;

class PagesController extends Controller
{
    public function home()
    {
        $this->render('home.php', [
            'page_name' => 'homepage'
        ]);
    }

    public function notes()
    {
        $this->redirectIfNotConnect();

        $this->render('notes.php', [
            'page_name' => 'notespage'
        ]);
    }

    public function horaires()
    {
        $this->render('horaires.php', [
            'page_name' => 'horairespage'
        ]);
    }

    public function absences()
    {
        $this->render('absences.php', [
            'page_name' => 'absencespage'
        ]);
    }

    public function etudiants()
    {
        $this->redirectIfNotConnect();

//        $sqlString = "SELECT users.*, group_concat(DISTINCT roles.code SEPARATOR ', ') as roles FROM users"
//            . " INNER JOIN user_role ON user_role.user_id = users.id INNER JOIN roles ON roles.id = user_role.role_id"
//            . " WHERE roles.code = 'student'"
//            . " GROUP BY users.id";
//        $users = User::staticQuery($sqlString);

//        $query = User::getPDO()->prepare($sqlString);
//        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
//        $query->execute();
//        $users = $query->fetchAll();

        $this->render('etudiants/index.php', [
            'page_name' => 'etudiantsspage',
            'etudiants' => User::staticQuery("SELECT users.* FROM users LEFT JOIN roles ON roles.id = users.role_id WHERE roles.code = 'student'"),
        ]);
    }

    public function enseignants()
    {
        $this->redirectIfNotConnect();

        $this->render('enseignants/index.php', [
            'page_name' => 'enseignantsspage',
            'enseignants' => User::staticQuery("SELECT users.* FROM users LEFT JOIN roles ON roles.id = users.role_id WHERE roles.code = 'teacher'"),
        ]);
    }
}
