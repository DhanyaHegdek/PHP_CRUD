<?php

require __DIR__ . '/../../vendor/autoload.php'; // Composer autoload (JWT)
require __DIR__ . '/../models/User.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {

    public function login() {

        // Get JSON input
        $data = json_decode(file_get_contents("php://input"));

        // Basic validation
        if (!$data || empty($data->username) || empty($data->password)) {
            http_response_code(400);
            echo json_encode([
                "error" => "Username and password required"
            ]);
            return;
        }

        // Find user
        $user = User::findByUsername($data->username);

        // Verify credentials
        if ($user && password_verify($data->password, $user['password'])) {

            $payload = [
                "user_id" => $user['id'],
                "role" => "admin",
                "iat" => time(),              // issued at
                "exp" => time() + 3600       // expires in 1 hour
            ];

            // Secret key (fallback if .env not loaded)
            $secret = $_ENV['JWT_SECRET'] ?? "my_secret_key";

            // Generate token
            $token = JWT::encode($payload, $secret, 'HS256');

            echo json_encode([
                "message" => "Login successful",
                "token" => $token
            ]);

        } else {
            http_response_code(401);
            echo json_encode([
                "error" => "Invalid username or password"
            ]);
        }
    }

    public function loginView() {
        require __DIR__ . '/../../views/login.php';
    }
}