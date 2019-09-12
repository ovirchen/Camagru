<?php

require_once 'config.php';


class Database
{
    private static $connection;

    public static function getInstance(): PDO {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8',
                    USER, PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        return self::$connection;
    }

    private function __construct() {
    }

    final private function __clone() {
    }
}