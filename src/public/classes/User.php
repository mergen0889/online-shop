<?php
class User
{
    public function registrate()
    {
        //$this->validate();

        $errors = $this->validate();

        if(empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-repeat'];

            $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

            header("location: /login");

        }   require_once './get_registration.php';



    }
    private function validate(): array
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (empty($name)) {
                $errors['name'] = 'Имя не должно быть пустым';
            } elseif (strlen($name) < 4) {
                $errors['name'] = 'Имя должно содержать не менее 4 символов';
            } elseif (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$name)){
                $errors['name'] = 'В имени недопустимый символ';
            }
        } else {
            $errors['name'] = 'Поле name должно быть заполнено';
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (empty($email)) {
                $errors['email'] = 'Поле email не должно быть пустым';
            } elseif (strlen($email) < 5) {
                $errors['email'] = 'Email должен содержать не менее 5 символов';
            } elseif (!preg_match('#^([\w]+\.?)+(?<!\.)@(?!\.)[a-zа-я0-9ё\.-]+\.?[a-zа-яё]{2,}$#ui', $email)){
                $errors['email'] = 'Недопустимый формат email';
            }
        } else {
            $errors['email'] = 'Поле email должно быть заполнено';
        }

        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Поле должно быть заполнено';
            } elseif (strlen($password) < 5) {
                $errors['psw'] = 'Пароль должен содержать не менее 5 символов';

            }
        }
        if (isset($_POST['psw-repeat'])) {
            $passwordRep = $_POST['psw-repeat'];
            if (empty($passwordRep)) {
                $errors['psw-repeat'] = 'Поле не должно быть пустым';
            }
            if ($passwordRep !== $password) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } return $errors;
    }

    public function login()
    {
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
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header("location: /catalog");
                } else {
                    $errors['login'] = 'Пароль или логин неверный';
                }
            }

        } require_once './get_login.php';

    }


}

//$user = new user();
//$user->registrate();
//$user->login();