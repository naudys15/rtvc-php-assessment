<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error" => "",
        "status" => 0
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST)) {
            $token = $genObj->sanitizeString($_POST['token']);
            $username = $genObj->sanitizeString($_POST['username']);
            $message = $genObj->sanitizeString($_POST['message']);
            $user = $userObj->getUserBySession($token);
            $create = $messageObj->createMessage($user->username, $username, $message);
            if ($create) {
                $result['message'] = $create;
                $result['status'] = 1;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>