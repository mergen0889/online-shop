<?php
//require_once './../Model/Database.php';

namespace Model;
use Model\Database;
class Order
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function createNewOrder(int $userId, string $contactName, string $address, int $phone)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("INSERT INTO orders (user_id, contact_name, address, phone)
            VALUES (:user_id, :contact_name, :address, :phone)");
        $stmt->execute(['user_id' => $userId, 'contact_name' => $contactName, 'address' => $address, 'phone' => $phone]);

    }

    public function getOrderIdByUser(int $userId): array|false
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT id FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }
}