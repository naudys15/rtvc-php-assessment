<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error_count" => 0,
        "error_details" => [],
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST)) {
            $name = $genObj->sanitizeString($_POST['name']);
            $username = $genObj->sanitizeString($_POST['username']);
            $email = $genObj->sanitizeString($_POST['email']);
            $password = $genObj->sanitizeString($_POST['password']);
            $result = $valObj->validateRegister($name, $username, $email, $password);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>