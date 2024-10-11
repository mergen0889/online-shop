
<div class="container">
    <h2>Basket </h2>

    <div class="card-deck">

        <?php foreach ($products as $product):?>
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        Hit!<?php echo $product['categories']; ?>
                    </div>
                    <img class="card-img-top" src="<?php echo $product['image_link'];?>" alt="Card image" >
                    <div class="card-body">
                        <p class="card-text text-muted">
                            <?php echo $product['product_name']; ?>
                            <?php echo $product['amount'].' шт.'; ?> </p>

                        <div class="card-footer">
                            <?php echo $product['price'].'руб.'; ?>
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
        font-size: 18px;
    }
    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>