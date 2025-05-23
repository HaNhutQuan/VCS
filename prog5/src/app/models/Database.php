<?php

class Database {
    private $conn;
    private static $instance = null;

    private function __construct() {
        $config = require base_path("config/config.php");
        
        $dbconfig = $config["database"];

        $host = $dbconfig["host"];
        $database = $dbconfig["database"];
        $username = $dbconfig["username"];
        $password = $dbconfig["password"];

        $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn,$username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);


        } catch (PDOException $err) {
            die("Database: " . $err->getMessage());
        }
    }

    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new Database();
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
