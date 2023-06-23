<?php

namespace RBAC\Models;

class User extends DB {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $statut;
    public $deleted_at;
    public $role_id;

    public static $role = null;

    public static function findAll($datas = [], $keys = '*', $one = false)
    {
        $sqlQuery = '';
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {
                $sqlQuery .= " $key = :$key AND";
            }
            $sqlQuery = substr($sqlQuery, 0, -4);
        }

        if (is_array($keys)) {
            $keys = join(',', $keys);
        }

        $sql = 'SELECT ' . $keys . ' FROM ' . self::getTable();
        // Au cas où ce sont les informations de l'administrateur

        if (! isset($datas['id'])) {
//            if (isset($_SESSION['auth'])) {
//                $sql .= ' WHERE id != :actif_user';
//                if ($_SESSION['auth'] !== 1) {
//                    $sql .= ' AND id != 1';
//                }
//
//                $datas = array_merge($datas, ['actif_user' => $_SESSION['auth']]);
//            }

            if ($sqlQuery != '') {
                $sql .= ' WHERE' . $sqlQuery;
            }

            $result = self::staticQuery($sql, $datas, $one);
        } else {
            // Au cas où ce sont les informations de l'administrateur
            if ((int) $datas['id'] === 1) {
                $result = self::staticQuery('SELECT ' . $keys . ' FROM ' . self::getTable() . ' WHERE id = ?', [1], true);
            } else {
                $sql .= ' WHERE' . $sqlQuery;
                $result = self::staticQuery($sql, $datas, $one);
            }
        }
        return $result;
    }

    public static function oldFindAll($datas = [], $keys = '*', $one = false)
    {
        $sqlQuery = '';
        if (!empty($datas)) {
            foreach ($datas as $key => $data) {
                $sqlQuery .= " $key = :$key AND";
            }
            $sqlQuery = substr($sqlQuery, 0, -4);
        }

        $sql = 'SELECT ' . $keys . ' FROM ' . self::$_table;

        // Au cas où ce sont les informations de l'administrateur
        if (! isset($datas['id'])) {
            if (isset($_SESSION['auth'])) {
                $sql .= ' WHERE id != :actif_user';
                if (($_SESSION['auth'])->id !== 1) {
                    $sql .= ' AND id != 1';
                }
                $datas = array_merge($datas, ['actif_user' => ($_SESSION['auth'])->id]);
            }

            if (! empty($sqlQuery)) {
                $sql .= $sqlQuery;
            }

            $result = self::staticQuery($sql, $datas, $one);
        } else {
            // Au cas où ce sont les informations de l'administrateur
            if ($datas['id'] === 1) {
                $result = self::staticQuery('SELECT ' . $keys . ' FROM ' . self::$_table . ' WHERE id = 1', [], true);
            } else {
                $sql .= ' WHERE' . $sqlQuery;
                $result = self::staticQuery($sql, $datas, $one);
            }
        }
        return $result;
    }

    public static function findByEmail(string $email, $withRole = false, $withTrashed = false)
    {
        $sqlString = "SELECT users.* FROM users WHERE";

        if (! $withTrashed) {
            $sqlString .= " deleted_at IS NULL AND";
        }

        $sqlString .= " email = ?";

        if ($withRole) {
//            $sqlString = "SELECT users.*,
// roles.name as role FROM users LEFT JOIN user_role ON user_role.user_id = users.id LEFT JOIN roles ON roles.id = user_role.role_id WHERE email = ?";
            $sqlString .= '';
        }

        $query = static::getPDO()->prepare($sqlString);
        $query->execute([$email]);

        return $query->fetch();
    }

    /**
     * @param int $roleId
     *
     * @return Role|mixed
     */
    public function getRole(int $roleId)
    {
        if (! static::$role) {
            static::$role = Role::staticQuery('SELECT * roles WHERE id = :id', [$roleId], true);
        }

        return static::$role;
    }

    /**
     * @return bool
     */
    public function isStudent(): bool
    {
        if ($role = $this->getRole($this->role_id)) {
            return strtolower($role->code) === 'student';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        if ($role = $this->getRole($this->role_id)) {
            return strtolower($role->code) === 'admin';
        }

        return false;
    }
}
