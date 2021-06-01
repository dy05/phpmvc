<?php

namespace DyosMvc\Models;


class User extends Db
{
    protected $table = 'users';

    public static function findAll($datas = [], $keys = '*', $one = false)
    {
        if (!empty($datas)) {
            $sqlend = '';
            foreach ($datas as $key => $data) {
                $sqlend .= " $key = :$key AND";
            }
            $sqlend = substr($sqlend, 0, -4);
        }

//        $sql = 'SELECT ' . $keys . ' FROM ' . self::$_table;
        $sql = 'SELECT * FROM ' . self::getTable();
        // Au cas ou ce sont les informations de l'administrateur
        if (!array_key_exists('id', $datas)) {
            if (isset($_SESSION['auth'])) {
                $sql .= ' WHERE id != :actif_user';
                if ($_SESSION['auth'] !== 1) {
                    $sql .= ' AND id != 1';
                }

                $datas = array_merge($datas, ['actif_user' => $_SESSION['auth']]);
            }

            if (isset($sqlend)) {
                $sql .= $sqlend;
            }

            $result = self::staticquery($sql, $datas, $one);
        } else {
            // Au cas ou ce sont les informations de l'administrateur
            if ($datas['id'] === 1) {
                $result = self::staticquery('SELECT * FROM ' . self::getTable() . ' WHERE id = 1', [], true);
//                $result = self::staticquery('SELECT ' . $keys . ' FROM ' . self::getTable() . ' WHERE id = 1', [], true);
            } else {
                $sql .= ' WHERE' . $sqlend;
                $result = self::staticquery($sql, $datas, $one);
            }
        }
        return $result;
    }

    public static function findiAll($datas = [], $keys = '*', $one = false)
    {
        if (!empty($datas)) {
            $sqlend = '';
            foreach ($datas as $key => $data) {
                $sqlend .= " $key = :$key AND";
            }
            $sqlend = substr($sqlend, 0, -4);
        }

        $sql = 'SELECT ' . $keys . ' FROM ' . self::$_table;

        // Au cas ou ce sont les informations de l'administrateur
        if (! array_key_exists('id', $datas)) {
            if (isset($_SESSION['auth'])) {
                $sql .= ' WHERE id != :actif_user';
                if ($_SESSION['auth'] !== 1) {
                    $sql .= ' AND id != 1';
                }
                $datas = array_merge($datas, ['actif_user' => $_SESSION['auth']]);
            }

            if (isset($sqlend)) {
                $sql .= $sqlend;
            }

            $result = self::staticquery($sql, $datas, $one);
        } else {
            // Au cas ou ce sont les informations de l'administrateur
            if ($datas['id'] === 1) {
                $result = self::staticquery('SELECT ' . $keys . ' FROM ' . self::$_table . ' WHERE id = 1', [], true);
            } else {
                $sql .= ' WHERE' . $sqlend;
                $result = self::staticquery($sql, $datas, $one);
            }
        }
        return $result;
    }


    public static function find($datas, $keys = '*')
    {
        if (is_string($datas) || is_integer($datas)) {
            return self::findAll(['id' => $datas], $keys, true);
        }

        return self::findAll($datas, $keys, true);
    }

    public static function findUsername(string $username, $table = null)
    {
        return self::getstaticPDO()->query("SELECT * FROM {self::getTable($table)} WHERE username = '{$username}'")->fetch();
    }
}
