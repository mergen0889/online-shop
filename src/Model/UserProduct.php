<?php

namespace Model;
//require_once './../Model/Database.php';

use Model\Database;
class UserProduct
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function getByUserIdAndByProductId(int $userId, int $productId): array|false
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT * FROM user_products JOIN products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

    public function deleteProductByUserId(int $userId)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

    }
}