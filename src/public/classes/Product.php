<?php
class Product
{
public $products;

    public function catalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("location: /login");
        }

        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM products");

        //$this->products = $products;
        $products = $stmt->fetchAll();
        $this->products = $products;
        require_once './catalog.php';
    }

    public function basket()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("location: /add-product");
        }
        $user_id = $_SESSION['user_id'];

        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->prepare("SELECT products.name AS product_name, products.image_link, products.categories, products.price, users.name AS user_name, user_products.amount
        FROM user_products
        JOIN users ON users.id = user_products.user_id
        JOIN products ON products.id = user_products.product_id
        WHERE user_products.user_id = :user_id");

        $stmt->execute(['user_id' => $user_id]);
        $products = $stmt->fetchAll();
        $this->products = $products;
        require_once './basket.php';
    }

    public function addProduct()
    {
        $errors = $this->validate();

        if(!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {

            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];
            $userId = $_SESSION['user_id'];

            $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");

            $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
            $result = $stmt->fetch();

            if ($result) {
                $amountSum = $result['amount'] + $amount;
                $amountUpd = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
                $amountUpd->execute(['amount' => $amountSum, 'user_id' => $userId, 'product_id' => $productId]);
                if ($amountUpd) {
                    $add = 'Add to basket successfully';
                }
            } else {
                $product = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
                $product->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
                if ($product) {
                    $add = 'Add to basket successfully';
                }
            }

            //  header("location: /catalog");
        }

        require_once './get_add_product.php';
    }

    private function validate(): array
    {
        $errors = [];

        session_start();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            if (empty($userId)) {
                $errors['user_id'] = 'Пожалуйста, авторизируйтесь';
            }
        } else {
            $errors['user_id'] = 'Пожалуйста, авторизируйтесь';
        }


        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            if (empty($productId)) {
                $errors['product_id'] = 'Поле не должно быть пустым';
            } elseif (!ctype_digit($productId)) {
                $errors['product_id'] = 'Поле должно содержать только цифры';
            } else {
                $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
                $stmt = $pdo->query("SELECT * FROM products WHERE id = '$productId'");
                $res = $stmt->fetch();

                if ($res === false) {
                    $errors['product_id'] = 'Продукт не существует';
                }

            }
        } else {
            $errors['product_id'] = 'Поле должно быть заполнено';
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            if (empty($amount)) {
                $errors['amount'] = 'Поле  не должно быть пустым';
            } elseif (!ctype_digit($amount)) {
                $errors['amount'] = 'Неправильный id продукта';
            } elseif ($amount < 1) {
                $errors['amount'] = 'Продукт не существует';
            }
        } else {
            $errors['amount'] = 'Поле должно быть заполнено';
        }
        return $errors;
    }

}