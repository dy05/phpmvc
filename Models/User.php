<?php

namespace RBAC\Models;
namespace RBAC\Models;

use RBAC\App\Autoloader;

Autoloader::register();
class User extends DB {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $statut;

    public static function findByEmail($email) {
        $host = 'localhost';
        $dbname = 'solution_factory';
        $username = 'root';
        $password = '';

        try {
            $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM users WHERE email = :email";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            if ($result) {
                $user = new User();
                $user->id = $result['id'];
                $user->nom = $result['nom'];
                $user->prenom = $result['prenom'];
                $user->email = $result['email'];
                $user->mdp = $result['mdp'];
                $user->statut = $result['statut'];

                return $user;
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            exit;
        }
    }
}
