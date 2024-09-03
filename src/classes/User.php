<?php
namespace MyApp\Classes;
use PDO;
class User {
    public $instance;
    public $instanceCache;
    public $db;
    public $dbCache;
    public function  __construct() {
        $this->instance = new \MyApp\Classes\DB;
        $this->instanceCache = new \MyApp\Classes\DBCache;
        $this->db = $this->instance->connect();
        $this->dbCache = $this->instanceCache->connect();
    }

    public function createUser($name, $username, $email, $password) {
        try {
            $query = $this->db->prepare('INSERT INTO `users` (`name`, `username`, `email`, `password`) VALUES (:name, :username, :email, :password)');
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function emailExists($email) {
        $query = $this->db->prepare('SELECT * FROM `users` WHERE `email` = :email');
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }
    
    public function isLoggedIn($token) {
        $check = $this->instanceCache->getCache($this->dbCache, "user-" . $token);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `session_id` = :session_id');
        $query->bindParam(':session_id', $token, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            $this->instanceCache->setCache($this->dbCache, "user-" . $token, json_encode($user));
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        session_start();
        session_regenerate_id();
    }

    public function updateSession($id, $token) {
        $query = $this->db->prepare('UPDATE `users` SET `session_id` = :session_id WHERE `id` = :id');
        $query->bindParam(":session_id", $token, PDO::PARAM_STR);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
    }

    public function updateConnection($connection_id, $id) {
        $query = $this->db->prepare('UPDATE `users` SET `connection_id` = :connection_id WHERE `id` = :id');
        $query->bindParam(":connection_id", $connection_id, PDO::PARAM_STR);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
    }

    public function getUser($token = "") {
        $check = $this->instanceCache->getCache($this->dbCache, "user-" . $token);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `session_id` = :session_id');
        $query->bindParam(':session_id', $token, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            $this->instanceCache->setCache($this->dbCache, "user-" . $token, json_encode($user));
            return $user;
        } else {
            return false;
        }
    }

    public function getUserById($id = "") {
        $check = $this->instanceCache->getCache($this->dbCache, "user-id-" . $id);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `id` = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            $this->instanceCache->setCache($this->dbCache, "user-id-" . $id, json_encode($user));
            return $user;
        } else {
            return false;
        }
    }

    public function getUsers($token = "") {
        $check = $this->instanceCache->getCache($this->dbCache, "users-" . $token);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `session_id` != :session_id');
        $query->bindParam(':session_id', $token, PDO::PARAM_INT);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_OBJ);

        $this->instanceCache->setCache($this->dbCache, "users-" . $token, json_encode($users));

        return $users;
    }

    public function getUserByUsername($username = "") {
        $check = $this->instanceCache->getCache($this->dbCache, "user-username-" . $username);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `username` = :username');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            $this->instanceCache->setCache($this->dbCache, "user-username-" . $username, json_encode($user));
            return $user;
        } else {
            return false;
        }
    }

    public function getUserBySession($session_id = "") {
        $check = $this->instanceCache->getCache($this->dbCache, "user-" . $session_id);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `users` WHERE `session_id` = :session_id');
        $query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            $this->instanceCache->setCache($this->dbCache, "user-" . $session_id, json_encode($user));
            return $user;
        } else {
            return false;
        }
    }

    
}