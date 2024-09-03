<?php
    require dirname(__DIR__) . '/vendor/autoload.php';

    if (session_status() === PHP_SESSION_NONE) { 
        session_start(); 
    }
    
    require "classes/DB.php";
    require "classes/DBCache.php";
    require "classes/User.php";
    require "classes/Message.php";
    require "utils/Validator.php";

    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $userObj = new \MyApp\Classes\User;
    $messageObj = new \MyApp\Classes\Message;
    $valObj = new \MyApp\Utils\Validator;
    $genObj = new \MyApp\Utils\General;
