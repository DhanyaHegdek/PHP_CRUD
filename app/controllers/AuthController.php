<?php
use Firebase\JWT\JWT;
require '../app/models/User.php';

class AuthController {

    public function login() {

        $data = json_decode(file_get_contents("php://input"));

        // demo user (replace with DB)
        $user = User::findByUsername($data->username);

        if ($user && password_verify($data->password, $user['password'])) {

            $payload = [
                "user_id" => $user['id'],
                "role" => "admin",
                "exp" => time() + 3600
            ];

            $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

            echo json_encode(["token" => $token]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Invalid login"]);
        }
    }
}