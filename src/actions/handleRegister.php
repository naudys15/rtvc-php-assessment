<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error" => "",
        "status" => 0
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST)) {
            $name = $genObj->sanitizeString($_POST['name']);
            $username = $genObj->sanitizeString($_POST['username']);
            $email = $genObj->sanitizeString($_POST['email']);
            $password = $genObj->sanitizeString($_POST['password']);
            $password = $genObj->hash($password);
            $create = $userObj->createUser($name, $username, $email, $password);
            if ($create) {
                $result['status'] = 1;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>