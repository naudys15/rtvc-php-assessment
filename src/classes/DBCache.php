<?php
namespace MyApp\Classes;
use Predis\Client;
class DBCache {
    function connect() {
        if ($_ENV['REDIS_ENABLE_CACHE'] == 'false') {
            return null;
        }
        // REDIS
        try {
            $db = new Client($_ENV["REDIS_URL"]);
            $db->connect();
            return $db;
        } catch (\Exception $ex) {
            return null;
        }
    }

    function setCache($db, $key, $value) {
        if ($_ENV['REDIS_ENABLE_CACHE'] == 'false') {
            return null;
        }

        $exp = $_ENV['REDIS_CACHE_EXP_TIME'] ?? 10;
        $db->set($key, $value, "ex", $exp);
        return $db->get($key);
    }

    function getCache($db, $key) {
        if ($_ENV['REDIS_ENABLE_CACHE'] == 'false') {
            return null;
        }

        try {
            $check = $db->get($key);
            return $check;
        } catch (\Exception $e) {
            return false;
        }
    }
}