<?php
//
function validate(): array
{
    $errors = [];

    session_start();
    //$userId = $_SESSION['user_id'];
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        if (empty($userId)) {
            $errors['user_id'] = 'Начните сессию';
        }
    } else {
        $errors['user_id'] = 'Пожалуйста, авторизируйтесь';
    }


    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        if (empty($productId)) {
            $errors['product_id'] = 'Поле не должно быть пустым';
        } //elseif (strlen($productId) < 4) {
            //$errors['product_id'] = 'Имя должно содержать не менее 4 символов';
        //} elseif (preg_match("/^[0-9]+$/",$productId)){
          //  $errors['product_id'] = 'В имени недопустимый символ';
        //}
    } else {
        $errors['product_id'] = 'Поле должно быть заполнено';
    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
        if (empty($amount)) {
            $errors['amount'] = 'Поле  не должно быть пустым';
        } //elseif (strlen($email) < 5) {
            //$errors['email'] = 'Email должен содержать не менее 5 символов';
        } //elseif (!preg_match('#^([\w]+\.?)+(?<!\.)@(?!\.)[a-zа-я0-9ё\.-]+\.?[a-zа-яё]{2,}$#ui', $email)){
            //$errors['email'] = 'Недопустимый формат email';
        //}
    //}
    else {
        $errors['amount'] = 'Поле должно быть заполнено';
    }
    return $errors;
}

$errors = validate();

if(empty($errors)) {
   // $id = $_POST('id');
    $productId = $_POST['product_id'];
    $amount = $_POST['amount'];
    //session_start();
    $userId = $_SESSION['user_id'];

    $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
//
//    $hash = password_hash($password, PASSWORD_DEFAULT);
//
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);

//    $stmt1 = $pdo->query("SELECT * FROM products WHERE id = :id");

//  $stmt1->execute(['id' => $id]);


//    header("location: /login");
//    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//    $stmt->execute(['email' => $email]);
    if ($stmt) {
        $add = 'Add to basket successfully';
    }
//    if(empty($id)) {
//        $err = 'Такого товара не существует';
//    }
}
require_once './get_add_product.php';