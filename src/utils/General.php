<?php
namespace MyApp\Utils;

class General {

    public function __construct() {
    }

    public function sanitizeString($str) {
        // Remove initial and end whitespaces
        $str = trim($str);
        // Remove html tags
        $str = strip_tags($str);
        return $str;
    }

    public function hash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
