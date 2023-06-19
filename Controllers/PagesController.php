<?php

namespace RBAC\Controllers;


use PDO;
use RBAC\Models\Article;
use RBAC\Models\User;

class PagesController extends Controller
{
    public function home()
    {
//        $this->redirectIfNotConnect();
//        $_SESSION['auth'] = 1;
//        $user = User::find(1);
//        echo "<pre>";
//        printf($user);
//        echo "</pre>";
//        die();
//        $this->redirectIfNotConnect();
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

    public function cours()
    {
        $this->redirectIfNotConnect();

        $this->render('cours.php', [
            'page_name' => 'courspage'
        ]);
    }

    public function salles()
    {
        $this->render('salles.php', [
            'page_name' => 'sallespage'
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

    public function formations()
    {
        $this->render('formations.php', [
            'page_name' => 'formationspage'
        ]);
    }

    public function etudiants()
    {
        $this->redirectIfNotConnect();

        $sqlString = "SELECT users.*, group_concat(DISTINCT roles.code SEPARATOR ', ') as roles FROM users";
        $sqlString .= " INNER JOIN user_role ON user_role.user_id = users.id INNER JOIN roles ON roles.id = user_role.role_id GROUP BY users.id";
        $users = User::staticQuery($sqlString);
//        $query = User::staticQuery($sqlString);
//        $query = User::getPDO()->prepare($sqlString);
//        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
//        $query->execute();
//        $users = $query->fetchAll();

        foreach ($users as $user) {
            var_dump($user);
//            var_dump($user->isAdmin());
            echo $user->nom .'<hr>';
        };
        die();

        $etudiants = User::staticQuery('SELECT * FROM users WHERE id NOT IN (1)');
        $this->render('etudiants.php', [
            'page_name' => 'etudiantsspage',
            'etudiants' => $etudiants,
        ]);
    }

    public function enseignants()
    {
        $this->render('enseignants.php', [
            'page_name' => 'enseignantspage'
        ]);
    }

    public function contact()
    {
        $this->render('contact.php', [
            'page_name' => 'contact'
        ]);
    }

    public function blogs($id = null)
    {
        die('loll');
        $this->isUserCookie();
        $error = null;
        if ($id === null) {
            $blogs = Article::findAll();
            $page = 'blogs';
        }else{
            // pour convertir en int
            $id = $id + 0;
            $blog = Article::find($id);
            if (!$blog) {
                $error = true;
            }
            $page = 'blog';
        }

        $this->render($page.'.php', [
            'page_name' => 'blogs',
            $page   =>  ${$page},
            'error' => $error
        ]);
    }

    public function editblog($id)
    {
        var_dump($id);
        die();
        $this->render($page.'.php', [
            'page_name' => 'blogs',
            $page   =>  ${$page},
            'error' => $error
        ]);
    }

    public function deleteblog($id)
    {
        echo Article::$_table;
        die();
        $action = Article::delete($id, 'articles');
        $this->render('blogs.php', [
            'page_name' => 'blogs',
            'blogs' => Article::findAll(),
            'alert' => 'Article supprime avec succes'
        ]);
    }

}
