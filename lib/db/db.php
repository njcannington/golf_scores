<?php
namespace Lib\Db;

use Lib\Config\Config;
use \PDO;

class Db
{
    private static $instance = null;

    //empty private construct to prevent new object istance;
    private function __construct()
    {
    }

    //empty clone to prevent from new object instance.
    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                $config = Config::getInstance();
                $db = $config["database"];
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $db_settings = "mysql:host={$db["host"]};dbname={$db["db"]}";
                self::$instance = new PDO($db_settings, $db["username"], $db["password"], $pdo_options);
            } catch (PDOException $e) {
                //insert log here
            }
        }
        return self::$instance;
    }

    public static function findOne($class, $where = ["column" => "value"])
    {
        $db = self::getInstance();

        $columns_to_values = self::parseWhere($where);
        $sql = 'SELECT * FROM '.self::getTableName($class).' WHERE '.$columns_to_values;

        try {
            $query = $db->prepare($sql);
            $query->execute();
            $row = $query->fetch();
            return self::createObject($class, $row);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function findAll($class, $where = ["column" => "value"])
    {
        $db = self::getInstance();

        $columns_to_values = self::parseWhere($where);
        $sql = 'SELECT * FROM '.self::getTableName($class).' WHERE '.$columns_to_values;

        try {
            $query = $db->prepare($sql);
            $query->execute();
            $rows = $query->fetchAll();
            $objects = [];
            foreach ($rows as $row) {
                $objects[] = self::createObject($class, $row);
            }
            return $objects;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected static function parseWhere($where)
    {
        if ($where !== null) {
            $columns = [];
            $values = [];

            foreach ($where as $column => $value) {
                $columns[] = $column;
                $values[] = $value;
            }

            return Sql::columnToValue($columns, $values);
        }
        return "id > 0";

    }

    protected static function createObject($class, $row)
    {
        $object = new $class;
        foreach (self::getColumns($class) as $column) {
            $object->{$column} = $row[$column];
        }
        return $object;
    }

    protected static function getColumns($class)
    {
        $db = self::getInstance();
        $query = $db->prepare("DESCRIBE ".self::getTableName($class));
        $query->execute();
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    protected static function getTableName($class)
    {
        $path = explode("\\", $class);
        return strtolower($path[count($path)-1]."s");
    }
}
