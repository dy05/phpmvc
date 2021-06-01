<?php

namespace DyosMvc\Models;

use \PDO;
use DyosMvc\App\Route;

class Db
{
    /**
     * @var int
     */
    protected $id;
    protected static $_id;

    /**
     * @var string
     */
    protected $table;

    public static $_table;
    /**
     * @var PDO
     */
    private $pdo;

    private static $_pdo;

    /**
     * @var null|string
     */
    protected $host = 'localhost';
    protected static $_host = 'localhost';

    /**
     * @var null|string
     */
    protected $base = 'mvc';
    protected static $_base = 'mvc';

    /**
     * @var null|string
     */
    protected $user = 'root';
    protected static $_user = 'root';

    /**
     * @var null|string
     */
    protected $pass = '';
    protected static $_pass = '';

    public function __construct($id = null, $base=null,$pass=null,$host=null,$user=null)
    {
        //Connexion à la base de données

        if ($base !== null) {
            $this->base = $base;
            self::$_base = $base;
        }
        if ($pass !== null) {
            $this->pass = $pass;
            self::$_pass = $pass;
        }
        if ($user !== null) {
            $this->user = $user;
            self::$_user = $user;
        }
        if ($host !== null) {
            $this->host = $host;
            self::$_host = $host;
        }
        if ($id !== null) {
            $this->id = $id;
            self::$_id = $id;
        }

    }

    /**
     * @return PDO
     */
    public function getPDO() {
        if ($this->pdo === null) {
            try {
                $db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->base . ';charset=UTF8;', $this->user, $this->pass);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->pdo = $db;
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return $this->pdo;
    }

    /**
     * @return PDO
     */
    public static function getstaticPDO() {
        if (self::$_pdo === null) {
            try {
                $db = new PDO('mysql:host=' . self::$_host . ';dbname=' . self::$_base . ';charset=UTF8;', self::$_user, self::$_pass);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                self::$_pdo = $db;
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        self::setTable();
        return self::$_pdo;
    }


    public function query($sql, $datas = [])
    {
        $req = $this->getPDO()->prepare($sql);
        $req->execute($datas);
        return $req;
    }

    public static function setTable()
    {
        $tables = explode('\\', strtolower(get_called_class()) . 's');
        if ($tables[2] === 'users') {
            self::$_table = 'users';
        }else {
            foreach ($tables as $table) {
                self::$_table = $table;
            }
        }
    }

    public static function add(array $datas, $table = null)
    {
        if ($table !== null) {
            self::$_table = $table;
        }else{
            self::setTable();
        }

        $sql = 'INSERT INTO '.self::$_table;
        foreach ($datas as $key => $data) {
            $sql .= " $key = :$key AND";
        }
        $sql = substr($sql, 0, -4);
        $result = self::staticquery($sql, $datas, true, false);
        return $result;
    }

    public static function update(array $datas, $wheres, $table = null)
    {
        if ($table !== null) {
            self::$_table = $table;
        }else{
            self::setTable();
        }

        $sql = 'UPDATE '.self::$_table.' SET';
        foreach ($datas as $key => $data) {
            $sql .= " $key = :$key AND";
        }
        $sql = substr($sql, 0, -4);

        if (!is_array($wheres)) {
            $var = self::find($wheres);
            if (!$var) {
                return false;
            }
            $sql .= ' WHERE id = :id';
            $datas = array_merge($datas, ['id' => $wheres]);
        }else{
            $sql .= ' WHERE ';
            foreach ($wheres as $key => $where) {
                if (is_string($key)) {
                    $sql .= " $key = :$key AND";
                }
            }
            $sql = substr($sql, 0, -4);
            $datas = array_merge($datas, $wheres);
        }

        $result = self::getstaticPDO()->prepare($sql);
        $result->execute($datas);
        return $result;
    }

    public static function delete($id, $table = null)
    {
        if ($table !== null) {
            self::$_table = $table;
        }else{
            self::setTable();
        }
        $var = self::find($id);
        if ($var) {
            $req = self::getstaticPDO()->query('DELETE FROM '.self::$_table.' WHERE id = '.$var->id);
            $req->execute();
            return true;
        }
        return false;
    }

    public static function staticquery($sql, $datas = [], $one = false, $return = true)
    {
        $req = self::getstaticPDO()->prepare($sql);
        $req->execute($datas);
        // Si on accepte de retourner les information
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
        die('Not Available');
        $sql = 'INSERT INTO '.$this->table;
        $result = $this->getPDO()->prepare($sql);
    }

    public function select($datas = [], $keys = null, $one = false)
    {
        if ($keys === null) {
            $keys = '*';
        }
        $sql = 'SELECT '.$keys.' FROM '.$this->table;
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
        }else{
            $result =$req->fetchAll();
        }
        return $result;
    }

    public static function findAll($datas = [], $keys = '*', $one = false)
    {
        //Pour mettre la table automatique;
        self::setTable();
        $sql = 'SELECT ' . $keys . ' FROM ' . self::$_table;
        if (!empty($datas)) {
            $sql .= ' WHERE';
            foreach ($datas as $key => $data) {
                $sql .= " $key = :$key AND";
            }
            $sql = substr($sql, 0, -4);
        }
        $result = self::staticquery($sql, $datas, $one);
        return $result;
    }

    public static function find($datas, $keys = '*')
    {
        if (is_string($datas) || is_integer($datas)) {
            return self::findAll(['id' => $datas], $keys, true);
        }
        return self::findAll($datas, $keys, true);
    }

    public static function getTable($table = null)
    {
        return $table ?? (new (static::class))->table;
    }
}
