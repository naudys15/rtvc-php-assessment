<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error" => "",
        "status" => 0
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if (isset($_GET)) {
            $token = $genObj->sanitizeString($_GET['token']);
            $id = $_GET['id'];
            $user = $userObj->getUserBySession($token);
            $create = $messageObj->deleteMessage($id, $user->username);
            if ($create) {
                $result['status'] = 1;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>