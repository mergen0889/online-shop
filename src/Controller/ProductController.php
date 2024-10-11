<?php

require_once './../Model/Product.php';

class ProductController
{
    private Product $userProduct;
    private Product $products;

    public function __construct()
    {
        $this->userProduct = new Product();
        $this->products = new Product();
    }
    public function getCatalog()
    {
//        session_start();
//        if (!isset($_SESSION['user_id'])) {
//            header("location: /login");
//        }

        //$product = new Product();
        $products = $this->products->getProducts();
        require_once './../View/catalog.php';
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

            //$userProduct = new Product();
            $result = $this->userProduct->getByUserIdAndProductId($userId, $productId);

            if ($result) {
                $amountSum = $result['amount'] + $amount;

                //$userProduct = new Product();
                $amountUpd = $this->userProduct->updateUserProduct($amountSum, $userId, $productId);

                if (!$amountUpd) {
                    $add = 'Add to basket successfully';
                } else {
                    $add = 'Товар не добавлен в корзину';
                }
            } else {
                $product = $this->userProduct->insertUserProduct($userId, $productId, $amount);
                if (!$product) {
                    $add = 'Add to basket successfully';
                } else {
                    $add = 'Товар не добавлен в корзину';
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
                $userProduct = new Product();
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