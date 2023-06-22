<?php

namespace RBAC\Models;

class PDO extends DB {

    private $host = "localhost";
    private $dbname = "solution_factory";
    private $username = "root";
    private $password = "";

    public function connect() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $pdo = new \PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            exit;
        }
    }

}
