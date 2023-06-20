<?php

namespace RBAC\Models;


class User extends DB
{
    public static $_table = 'users';

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

    public static function findiAll($datas = [], $keys = '*', $one = false)
    {
        if (!empty($datas)) {
            $sqlQuery = '';
            foreach ($datas as $key => $data) {
                $sqlQuery .= " $key = :$key AND";
            }
            $sqlQuery = substr($sqlQuery, 0, -4);
        }

        $sql = 'SELECT ' . $keys . ' FROM ' . self::$_table;

        // Au cas où ce sont les informations de l'administrateur
        if (! array_key_exists('id', $datas)) {
            if (isset($_SESSION['auth'])) {
                $sql .= ' WHERE id != :actif_user';
                if (($_SESSION['auth'])->id !== 1) {
                    $sql .= ' AND id != 1';
                }
                $datas = array_merge($datas, ['actif_user' => ($_SESSION['auth'])->id]);
            }

            if (isset($sqlQuery)) {
                $sql .= $sqlQuery;
            }

            $result = self::staticQuery($sql, $datas, $one);
        } else {
            // Au cas ou ce sont les informations de l'administrateur
            if ($datas['id'] === 1) {
                $result = self::staticQuery('SELECT ' . $keys . ' FROM ' . self::$_table . ' WHERE id = 1', [], true);
            } else {
                $sql .= ' WHERE' . $sqlQuery;
                $result = self::staticQuery($sql, $datas, $one);
            }
        }
        return $result;
    }


    public static function find($userId, $keys = '*')
    {

        if ((int) $userId > 0) {
            return self::findAll(['id' => $userId], $keys, true);
        }

        return self::findAll($userId, $keys, true);
    }

    public static function findByEmail(string $email, $withRole = false)
    {
        $sqlString = "SELECT users.* FROM users WHERE email = ?";
        if ($withRole) {
            $sqlString = "SELECT users.*, roles.name as role FROM users WHERE email = ? LEFT JOIN user_role ON user_role.user_id = users.id LEFT JOIN roles ON roles.id = user_role.role_id";
        }
        $query = self::getPDO()->prepare($sqlString);
        $query->execute([$email]);
        return $query->fetch();
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        $roles = explode(', ', $this->roles ?? '');
        if (in_array($role, $roles)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
