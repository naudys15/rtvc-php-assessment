<?php
namespace MyApp\Classes;

class DB {
    function connect() {
        // MYSQL
        $db = new \PDO($_ENV["MYSQL_URL"], $_ENV["MYSQL_USERNAME"], $_ENV["MYSQL_PASSWORD"]);
        return $db;
    }
}