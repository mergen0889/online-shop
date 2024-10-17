<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="/order" method="POST">

                <div class="row">
                    <div class="col-50">
                        <h3>Контактные данные</h3>
                        <label for="contact_name"><i class="fa fa-user"></i> Имя</label>
                        <label style="color: darkred"><?php echo $errors['contact_name'] ?? ''; ?></label>
                        <input type="text" id="contact_name" name="contact_name" placeholder="">
                        <label for="phone"><i class="fa fa-user"></i> Телефон</label>
                        <label style="color: darkred"><?php echo $errors['phone'] ?? ''; ?></label>
                        <input type="text" id="phone" name="phone" placeholder="">
                        <label for="address"><i class="fa fa-address-card-o"></i> Адрес</label>
                        <label style="color: darkred"><?php echo $errors['address'] ?? ''; ?></label>
                        <input type="text" id="address" name="address" placeholder="">
                    </div>

                </div>

                <input type="submit" value="Оформить заказ" class="btn">
            </form>
        </div>
    </div>

    <div class="col-25">

        <div class="container">
            <h4>Cart
                <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
                    <?php $count = 0;?>
                    <?php foreach ($res as $product): $count++;?>
                    <?php endforeach;?>
                    <b><?php echo $count?></b>
        </span>
            </h4>
            <?php $totalPrice = 0;?>
            <?php foreach ($res as $product):?>
                <?php $allPrice = 1;?>
                <p><a href="#"><?php echo $product['name'] . " шт.: " . $product['amount'];?>
                    </a> <span class="price"><?php $allPrice = $product['price'] * $product['amount'];echo $allPrice . " руб"?></span></p>
                <hr>
                <?php $totalPrice += $allPrice?>
            <?php endforeach;?>
            <p>Всего к оплате <span class="price" style="color:black"><b><?php echo $totalPrice . " руб"?></b></span></p>
        </div>
    </div>
</div>

<style>
    .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
    }

    input[type=text] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    span.price {
        float: right;
        color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }
        .col-25 {
            margin-bottom: 20px;
        }
    }
</style>

