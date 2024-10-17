<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
class OrderController
{
    private Order $order;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;

    public function __construct()
    {
        $this->order = new Order();
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
    }

    public function showProductsOrder()
    {
        session_start();
        $userId = $_SESSION['user_id'];

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        $res = $this->userProduct->getProductsByUserId($userId);

        require_once "./../View/order.php";
    }

    public function createOrder()
    {
        $errors = $this->validateOrder();

        if (empty($errors)) {
            session_start();
            $userId = $_SESSION['user_id'];
            $contactName = $_POST['contact_name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $this->order->createNewOrder($userId, $contactName, $address, $phone);

            $orderId = $this->order->getOrderIdByUser($userId);

            foreach ($this->userProduct->getProductsByUserId($userId) as $product) {
                $this->orderProduct->addProductInOrder($orderId['id'], $product['id'], $product['amount'], $product['price']);
            }
            $this->userProduct->deleteProductByUserId($userId);
            header('Location: /order');

        } else {
            require_once "./../View/order.php";
        }
    }

    private function validateOrder(): array //переделать валидацию, после создания таблицы в бд
    {
        $errors = [];

        if (isset($_POST['contact_name'])) {
            $contactName = ($_POST['contact_name']);
            if (strlen($contactName) < 3 || strlen($contactName) > 20) {
                $errors['contact_name'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $contactName)) {
                $errors['contact_name'] = "Имя может содержать только буквы";
            }
        } else {
            $errors ['contact_name'] = "Поле должно быть заполнено";
        }

        if (isset($_POST['address'])) {
            $address = ($_POST['address']);
            if (strlen($address) < 3 || strlen($address) > 100) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 100 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        } else {
            $errors ['address'] = "Поле address должно быть заполнено";
        }

        if (isset($_POST['phone'])) {
            $phone = ($_POST['phone']);
            if (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        } else {
            $errors ['phone'] = "Поле phone должно быть заполнено";
        }
        return $errors;
    }

}