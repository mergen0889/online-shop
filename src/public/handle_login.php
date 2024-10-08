<?php

$errors = [];

if (isset($_POST['login'])) {
    $login = $_POST['login'];
} else {
    $errors['login'] = 'Логин или пароль неверный';
}

if (isset($_POST['psw'])) {
    $password = $_POST['psw'];
} else {
    $errors['psw'] = 'Логин или пароль неверный';
}


if (empty($errors)) {

    $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :login');
    $stmt->execute(['login' => $login]);

    $data = $stmt->fetch();

    if($data === false) {
        $errors['login'] = 'Пароль или логин неверный';
    } else {
        $hashDb = $data['password'];

        if(password_verify($password, $hashDb)) {
//            setcookie('user_id', $data['id']);
            session_start();
            $_SESSION['user_id'] = $data['id'];
            header("location: /catalog");
        } else {
            $errors['login'] = 'Пароль или логин неверный';
        }
    }

}

require_once './get_login.php';


?>
