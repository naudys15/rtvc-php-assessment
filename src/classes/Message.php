<?php
namespace MyApp\Classes;
use PDO;
class Message {
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

    public function createMessage($sender, $receiver, $message) {
        try {
            $query = $this->db->prepare('INSERT INTO `messages` (`sender`, `receiver`, `message`) VALUES (:sender, :receiver, :msg)');
            $query->bindParam(':sender', $sender, PDO::PARAM_STR);
            $query->bindParam(':receiver', $receiver, PDO::PARAM_STR);
            $query->bindParam(':msg', $message, PDO::PARAM_STR);
            $query->execute();
            $id = $this->db->lastInsertId();
            $message = self::getMessageById($id);
            return $message;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function editMessage($message_id, $username, $message) {
        try {
            $id = (int) $message_id;
            $query = $this->db->prepare('UPDATE `messages` SET `message` = :msg WHERE `id` = :id AND `sender` = :sender');
            $query->bindParam(':msg', $message, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':sender', $username, PDO::PARAM_STR);
            $query->execute();
            $count = $query->rowCount();
            return $count;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteMessage($message_id, $username) {
        try {
            $id = (int) $message_id;
            $query = $this->db->prepare('DELETE FROM `messages` WHERE `id` = :messageId AND `sender` = :username');
            $query->bindParam(':messageId', $id, PDO::PARAM_INT);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            $count = $query->rowCount();
            return $count;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getMessages($sender, $receiver) {
        $check = $this->instanceCache->getCache($this->dbCache, "messages-" . $sender . "-" . $receiver);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `messages` WHERE (`sender` = :sender AND `receiver` = :receiver) OR (`sender` = :receiver2 AND `receiver` = :sender2) ');
        $query->bindParam(':sender', $sender, PDO::PARAM_STR);
        $query->bindParam(':receiver', $receiver, PDO::PARAM_STR);
        $query->bindParam(':sender2', $sender, PDO::PARAM_STR);
        $query->bindParam(':receiver2', $receiver, PDO::PARAM_STR);
        $query->execute();
        $messages = $query->fetchAll(PDO::FETCH_OBJ);

        if (!empty($messages)) {
            $this->instanceCache->setCache($this->dbCache, "messages-" . $sender . "-" . $receiver, json_encode($messages));
            return $messages;
        } else {
            return [];
        }
    }
    
    public function getMessageById($id) {
        $check = $this->instanceCache->getCache($this->dbCache, "message-" . $id);
        if ($check) {
            return json_decode($check);
        }

        $query = $this->db->prepare('SELECT * FROM `messages` WHERE `id` = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $message = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($message)) {
            $this->instanceCache->setCache($this->dbCache, "message-" . $id, json_encode($message));
            return $message;
        } else {
            return false;
        }
    } 
}