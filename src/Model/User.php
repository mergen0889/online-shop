<?php
class User
{
    public function create(string $name, string $email,string $password)
    {
        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    }


}