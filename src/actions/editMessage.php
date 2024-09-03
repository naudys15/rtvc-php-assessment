<?php
    include_once dirname(__DIR__) . "/init.php";

    $result = [
        "error" => "",
        "status" => 0
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $PUT_VALUES);
        if (isset($PUT_VALUES)) {
            $token = $genObj->sanitizeString($PUT_VALUES['token']);
            $id = $genObj->sanitizeString($PUT_VALUES['id']);
            $message = $genObj->sanitizeString($PUT_VALUES['message']);
            $user = $userObj->getUserBySession($token);
            $edit = $messageObj->editMessage($id, $user->username, $message);
            if ($edit) {
                $result['status'] = 1;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($result);
?>