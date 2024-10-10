<?php

class UserProduct
{

    public function getByUserIdAndProductId(int $userId, int $productId): array|false
    {
        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

        $stmt = $pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");

        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();

        return $result;
    }

    public function getByProductId(int $productId): array|false
    {
        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM products WHERE id = '$productId'");
        $res = $stmt->fetch();
        return $res;
    }

    public function getUpdateUserProduct(int $amountSum, int $userId, int $productId)
    {
        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $amountUpd = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $amountUpd->execute(['amount' => $amountSum, 'user_id' => $userId, 'product_id' => $productId]);

    }

    public function getInsertUserProduct(int $userId, int $productId, int $amount)
    {
        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $product = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $product->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);

    }

//    public function getUserCatalog(): array
//    {
//        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
//
//        $stmt = $pdo->query("SELECT * FROM products");
//
//        $products = $stmt->fetchAll();
//
//        return $products;
//    }

}