<?php

require_once __DIR__ . '/../config/database.php';

class Product {

    public static function all() {
        $db = Database::connect();
        return $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $price) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO products(name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
    }

    public static function update($id, $name, $price) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE products SET name=?, price=? WHERE id=?");
        $stmt->execute([$name, $price, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM products WHERE id=?");
        $stmt->execute([$id]);
    }
}