<?php
namespace MyApp\Utils;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Validator {

    public function __construct() {
        $this->userObj = new \MyApp\Classes\User;
    }

    public function validateUsernameConnect($token, $username) {
        $emptyResponse = [
            'user' => null,
            'profileData' => null
        ];
        if (isset($username) && !empty($username)) {
            $user = $this->userObj->getUser($token);
            $profileData = $this->userObj->getUserByUsername($username);
            if (empty($profileData)) {
                return $emptyResponse;
            } else if ($profileData->username === $user->username) {
                return $emptyResponse;
            }
        } else {
            return $emptyResponse;
        }
        return [
            'user' => $user,
            'profileData' => $profileData
        ];
    }

    public function validateLogin($email, $password) {
        $result = [
            "token" => "",
            "error" => ""
        ];
        if (!empty($email) && !empty($password)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result["error"] = "Invalid email";
                return $result;
            } else {
                if ($user = $this->userObj->emailExists($email)) {
                    if (password_verify($password, $user->password)) {
                        session_regenerate_id();
                        $token = session_id();
                        $this->userObj->updateSession($user->id, $token);
                        $result["token"] = $token;
                        return $result;
                    } else {
                        $result["error"] = "Incorrect email or password";
                        return $result;
                    }
                } else {
                    $result["error"] = "Incorrect email or password";
                    return $result;
                }
            }
        } else {
            $result["error"] = "Please enter your email and password";
            return $result;
        }
    }

    public function validateRegister($name, $username, $email, $password) {
        $result = [
            "error_count" => 0,
            "error_details" => [],
        ];

        if (empty($name)) {
            $result['error_count'] = $result['error_count'] + 1;
            $result['error_details']['name'] = "Name required";
        }

        if (!empty($username) && $this->userObj->getUserByUsername($username)) {
            $result['error_count'] = $result['error_count'] + 1;
            $result['error_details']['username'] = "Invalid username. Already exists";
        } else if (empty($username)) {
            $result['error_count'] = $result['error_count'] + 1;
            $result['error_details']['username'] = "Username required";
        }

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result['error_count'] = $result['error_count'] + 1;
                $result['error_details']['email'] = "Invalid email";
            } else if ($this->userObj->emailExists($email)) {
                $result['error_count'] = $result['error_count'] + 1;
                $result['error_details']['email'] = "Invalid email. Already exists";
            }
        } else {
            $result['error_count'] = $result['error_count'] + 1;
            $result['error_details']['email'] = "Email required";
        }

        if (empty($password)) {
            $result['error_count'] = $result['error_count'] + 1;
            $result['error_details']['password'] = "Password required";
        }

        return $result;
    }
}
