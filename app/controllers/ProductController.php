<?php
require '../app/models/Product.php';
require '../app/middleware/AuthMiddleware.php';

class ProductController {

    // UI
    public function view() {
        $products = Product::all();
        require '../views/products/index.php';
    }

    // API
    public function index() {
        AuthMiddleware::check();
        echo json_encode(Product::all());
    }

    public function store() {
        AuthMiddleware::check();
        $data = json_decode(file_get_contents("php://input"));
        Product::create($data->name, $data->price);
        echo json_encode(["message" => "created"]);
    }

    public function update() {
        AuthMiddleware::check();
        $data = json_decode(file_get_contents("php://input"));
        Product::update($data->id, $data->name, $data->price);
        echo json_encode(["message" => "updated"]);
    }

    public function delete() {
        AuthMiddleware::check();
        $data = json_decode(file_get_contents("php://input"));
        Product::delete($data->id);
        echo json_encode(["message" => "deleted"]);
    }
}