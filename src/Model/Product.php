<?php
namespace Model;

use Model\Database;

class Product
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function getProducts(): array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getProductsByProductId(int $productId): array|false
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('SELECT id FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $products = $stmt->fetch();
        return $products;
    }
}