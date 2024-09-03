<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error" => "",
        "token" => ""
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST)) {
            $email = $genObj->sanitizeString($_POST['email']);
            $password = $_POST['password'];
            $result = $valObj->validateLogin($email, $password);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>