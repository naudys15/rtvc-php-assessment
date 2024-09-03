<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Classes\Chat;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8085
);

$server->run();