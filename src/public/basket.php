<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: /add-product");
}
if (isset($_POST['product_id'])) {
    $productID = $_POST['product_id'];
}
$pdo = new PDO("pgsql:host=online-shop-1-postgres-1; port=5432; dbname=mydb", 'user', 'pass');
$stmt = $pdo->query("SELECT * FROM user_products WHERE product_id = '1'");

$products = $stmt->fetch();

?>


<div class="container">
    <h2>Shopping Basket </h2>

    <div class="card-deck">

        <?php foreach ($products as $product):?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        Hit!<?php echo $product['product_id']; ?>
                    </div>
<!--                    <img class="card-img-top" src="--><?php //echo $product['image_link'];?><!--" alt="Card image" >-->
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['amount']; ?></p>

                        <div class="card-footer">
                            <?php echo $product['user_id'].'руб.'; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;?>
    </div>
</div>
<style>
    body {
        font-style: italic;
    }
    a {
        text-decoration: none;
    }
    a:hover {
        text-decoration: none;
    }
    h3 {
        line-height: 3em;
    }
    .card {
        max-width: 16rem;
    }
    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }
    .card-header {
        font-size: 13px;
        color: red;
        background-color: white;
    }
    .text-muted {
        font-size: 11px;
    }
    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>
