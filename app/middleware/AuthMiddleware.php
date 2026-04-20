<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {

    public static function check() {

        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            die("No token");
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);

        try {
            JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        } catch (Exception $e) {
            http_response_code(401);
            die("Invalid token");
        }
    }
}