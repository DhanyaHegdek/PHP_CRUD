<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {

    public static function check() {

        $headers = array_change_key_case(getallheaders(), CASE_LOWER);

        if (!isset($headers['authorization'])) {
            http_response_code(401);
            die("No token");
        }

        $token = str_replace("Bearer ", "", $headers['authorization']);

        try {
            JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        } catch (Exception $e) {
            http_response_code(401);
            die("Invalid token");
        }
    }
}