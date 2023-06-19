<?php

namespace RBAC\Models;

use \PDO;
use PDOException;
use RBAC\App\Route;

abstract class DB
{
    /**
     * @var int
     */
    protected static $_id;

    /**
     * @var string
     */
    public static $_table;

    /**
     * @var PDO
     */
    private static $_pdo;

    /**
     * @var null|string
     */
    protected static $_host = 'localhost';


    /**
     * @var null|string
     */
    protected static $_base = 'solution_factory';

    /**
     * @var null|string
     */
    protected static $_user = 'root';

    /**
     * @var null|string
     */
    protected static $_pass = '';

    public function __construct($base = null, $user = null, $pass = null, $host = null, $id = null)
    {
        //Connexion à la base de données

        if ($base !== null) {
            static::$_base = $base;
        }

        if ($pass !== null) {
            static::$_pass = $pass;
        }

        if ($user !== null) {
            static::$_user = $user;
        }

        if ($host !== null) {
            static::$_host = $host;
        }

        if ($id !== null) {
            static::$_id = $id;
        }
    }

    /**
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        if (static::$_pdo === null) {
            try {
                $db = new PDO('mysql:host=' . static::$_host . ';dbname=' . static::$_base . ';charset=UTF8;', static::$_user, static::$_pass);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                static::$_pdo = $db;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return static::$_pdo;
    }


    public function query($sql, $datas = [])
    {
        $req = static::getPDO()->prepare($sql);
        $req->execute($datas);
        return $req;
    }

    public static function setTable()
    {
        $tables = explode('\\', strtolower(get_called_class()) . 's');
        if ($tables[2] === 'users') {
            static::$_table = 'users';
        } else {
            foreach ($tables as $table) {
                static::$_table = $table;
            }
        }
    }

    public static function add(array $datas, $table = null)
    {
        if ($table !== null) {
            static::$_table = $table;
        } else {
            static::setTable();
        }

        $sql = 'INSERT INTO '.static::$_table;
        foreach ($datas as $key => $data) {
            $sql .= " $key = :$key AND";
        }
        $sql = substr($sql, 0, -4);
        return static::staticQuery($sql, $datas, true, false);
    }

    public static function update(array $datas, $wheres, $table = null)
    {
        if ($table !== null) {
            static::$_table = $table;
        } else {
            static::setTable();
        }

        $sql = 'UPDATE '.static::$_table.' SET';
        foreach ($datas as $key => $data) {
            $sql .= " $key = :$key AND";
        }
        $sql = substr($sql, 0, -4);

        if (!is_array($wheres)) {
            $var = static::find($wheres);
            if (!$var) {
                return false;
            }
            $sql .= ' WHERE id = :id';
            $datas = array_merge($datas, ['id' => $wheres]);
        } else {
            $sql .= ' WHERE ';
            foreach ($wheres as $key => $where) {
                if (is_string($key)) {
                    $sql .= " $key = :$key AND";
                }
            }
            $sql = substr($sql, 0, -4);
            $datas = array_merge($datas, $wheres);
        }

        $result = static::getPDO()->prepare($sql);
        $result->execute($datas);
        return $result;
    }

    public static function delete($id, $table = null)
    {
        if ($table !== null) {
            static::$_table = $table;
        } else {
            static::setTable();
        }
        $var = static::find($id);
        if ($var) {
            $req = static::getPDO()->query('DELETE FROM '.static::$_table.' WHERE id = '.$var->id);
            $req->execute();
            return true;
        }
        return false;
    }

    public static function staticQuery($sql, $datas = [], $one = false, $return = true)
    {
        $req = static::getPDO()->prepare($sql);
        $req->execute($datas);
        // Si on accepte de retourner les informations
        if ($return) {
            if ($one) {
                $result = $req->fetch();
            } else {
                $result = $req->fetchAll();
            }
            $req = $result;
        }
        return $req;
    }

    public function create($datas = [])
    {
        return static::getPDO()->prepare('INSERT INTO ' . static::$_table);
    }

    public function select($datas = [], $keys = null, $one = false)
    {
        if ($keys === null) {
            $keys = '*';
        }
        $sql = 'SELECT '.$keys.' FROM ' . static::$_table;
        if (!empty($datas)) {
            $sql .= ' WHERE';
            foreach ($datas as $key => $data) {
                $sql .= " $key = :$key AND";
            }
            $sql = substr($sql, 0, -4);
        }
        $req = $this->query($sql, $datas);
        if ($one) {
            $result = $req->fetch();
        } else {
            $result =$req->fetchAll();
        }
        return $result;
    }

    public static function findAll($datas = [], $keys = '*', $one = false)
    {
        // Pour mettre la table automatique
        static::setTable();
        $sql = 'SELECT ' . $keys . ' FROM ' . static::$_table;
        if (!empty($datas)) {
            $sql .= ' WHERE';
            foreach ($datas as $key => $data) {
                $sql .= " $key = :$key AND";
            }
            $sql = substr($sql, 0, -4);
        }
        $result = static::staticQuery($sql, $datas, $one);
        return $result;
    }

    public static function find($datas, $keys = '*')
    {
        if (is_string($datas) || is_integer($datas)) {
            return static::findAll(['id' => $datas], $keys, true);
        }
        return static::findAll($datas, $keys, true);
    }

    public static function getTable($table = null)
    {
//        return $table ?? (new (static::class))->table;
        return static::$_table;
    }
}
