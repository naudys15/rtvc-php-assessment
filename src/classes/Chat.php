<?php
namespace MyApp\Classes;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    public $userObj;
    public $data;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->userObj = new \MyApp\Classes\User;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $query);
        if ($data = $this->userObj->getUserBySession($query["token"])) {
            $this->data = $data;
            $conn->data = $data;
            $this->clients->attach($conn);
            $this->userObj->updateConnection($conn->resourceId, $data->id);
            echo "New connection! ({$data->username} with id {$conn->resourceId})\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        try {
            $numRecv = count($this->clients) - 1;
            $data = json_decode($msg, true);
            $sendTo = $this->userObj->getUserById($data["sendTo"]);
            $send["sendTo"] = $sendTo->id;
            $send["by"] = $from->data->id;
            $send["profileImage"] = $from->data->profile_image;
            $send["username"] = $from->data->username;
            $send["type"] = $data["type"];
            $send["data"] = $data["data"];

            echo sprintf('Connection with id %d sending message "%s" to %d other connection with id %d' . "\n", $from->resourceId, $msg, $numRecv, $sendTo->id);
            
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    if ($client->resourceId == $sendTo->connection_id || $from == $client) {
                        $client->send(json_encode($send));
                    }
                }
            }
        } catch (\Exception $e){
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}