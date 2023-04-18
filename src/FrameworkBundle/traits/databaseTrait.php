<?php

namespace FrameworkBundle\Traits;

class databaseTrait extends \PDO {

    private static $instance = null;

    private function __construct() {
        parent::__construct('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
    }

    public static function getDb() : databaseTrait {
        if (self::$instance == null) {
            self::$instance = new databaseTrait();
        }
        return self::$instance;
    }
}