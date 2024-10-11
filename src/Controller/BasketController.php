<?php
require_once './../Model/Basket.php';
class BasketController
{
    private Basket $basket;

    public function __construct()
    {
        $this->basket = new Basket();
    }

    public function getBasket()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("location: /add-product");
        }
        $user_id = $_SESSION['user_id'];
        //$basket = new Basket();
        $products = $this->basket->getProductsBasket($user_id);

        require_once './../View/basket.php';

    }



}