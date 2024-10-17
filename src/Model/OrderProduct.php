<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class OrderProduct
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function addProductInOrder(int $orderId, int $productId, int $amount, int $priceOrder)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("INSERT INTO order_products (order_id, product_id, amount, price_order) 
            VALUES (:order_id, :product_id, :amount, :price_order)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price_order' => $priceOrder]);

    }
}