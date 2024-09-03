<?php
    $token = "";
    if (isset($_GET) && isset($_GET["token"])) {
        $token = $_GET["token"];
    }

    if (!$token) {
        include_once dirname(__DIR__) . "/views/login.php";
        exit;
    }

    $check = $userObj->isLoggedIn($token);
    if (!$check) {
        include_once dirname(__DIR__) . "/views/login.php";
        exit;
    }