<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../models/Product.php';
require __DIR__ . '/../middleware/AuthMiddleware.php';

class ProductController {

    //  GET /api/products
    public function index() {
        AuthMiddleware::check();

        try {
            $products = Product::all();

            $this->jsonResponse([
                "data" => $products
            ]);

        } catch (Exception $e) {
            $this->errorResponse("Failed to fetch products", 500);
        }
    }

    //  POST /api/products
    public function store() {
        AuthMiddleware::check();

        $data = json_decode(file_get_contents("php://input"));

        if (!$data || empty($data->name)) {
            return $this->errorResponse("Product name is required", 400);
        }

        try {
            Product::create($data->name, 0);

            $this->jsonResponse([
                "message" => "Product created successfully"
            ]);

        } catch (Exception $e) {
            $this->errorResponse("Failed to create product", 500);
        }
    }

    //  PATCH /api/products
    public function update() {
        AuthMiddleware::check();

        $data = json_decode(file_get_contents("php://input"));

        if (!$data || empty($data->id) || empty($data->name)) {
            return $this->errorResponse("ID and name are required", 400);
        }

        try {
            Product::update($data->id, $data->name, 0);

            $this->jsonResponse([
                "message" => "Product updated successfully"
            ]);

        } catch (Exception $e) {
            $this->errorResponse("Failed to update product", 500);
        }
    }

    //  DELETE /api/products/{id}
    public function delete($id) {
        AuthMiddleware::check();

        if (empty($id)) {
            return $this->errorResponse("Product ID required", 400);
        }

        try {
            Product::delete($id);

            $this->jsonResponse([
                "message" => "Product deleted successfully"
            ]);

        } catch (Exception $e) {
            $this->errorResponse("Failed to delete product", 500);
        }
    }

    //  UI
    public function view() {
        require __DIR__ . '/../../views/products.php';
    }

    //  Helper: Success response
    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    //  Helper: Error response
    private function errorResponse($message, $status) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode([
            "error" => $message
        ]);
    }
}