<?php
class ProductController
{

    public $products;
    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("location: /login");
        }

        $pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');

        $stmt = $pdo->query("SELECT * FROM products");

        $products = $stmt->fetchAll();
        $this->products = $products;
    }

    public function getProductForm()
    {
        require_once './../View/addProduct.php';
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

            require_once './../Model/UserProduct.php';
            $userProduct = new UserProduct();
            $result = $userProduct->getByUserIdAndProductId($userId, $productId);
            //$result = $userProduct->result;
            //
            if ($result) {
                $amountSum = $result['amount'] + $amount;
                //$amountUpd = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
                //$amountUpd->execute(['amount' => $amountSum, 'user_id' => $userId, 'product_id' => $productId]);
                $userProduct = new UserProduct();
                $amountUpd = $userProduct->getUpdateUserProduct();

                if ($amountUpd) {
                    $add = 'Add to basket successfully';
                }
            } else {
                $product = $userProduct->getInsertUserProduct();
                if ($product) {
                    $add = 'Add to basket successfully';
                }
            }

            //  header("location: /catalog");
        }

        require_once './../View/addProduct.php';
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
                $userProduct = new UserProduct();
                $res = $userProduct->getByProductId($productId);

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