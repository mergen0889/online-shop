<?php

class Basket
{
    public function getProductsBasket(int $user_id): array
    {

        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->prepare("SELECT products.name 
                               AS product_name, products.image_link, products.categories, products.price, users.name 
                               AS user_name, user_products.amount FROM user_products JOIN users ON users.id = user_products.user_id
                               JOIN products ON products.id = user_products.product_id
                               WHERE user_products.user_id = :user_id");


        $stmt->execute(['user_id' => $user_id]);
        $products = $stmt->fetchAll();
        return $products;
    }




}