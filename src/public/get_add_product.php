
<form action="/add-product" method="POST">
    <div class="imgcontainer">
        <img src="https://img.freepik.com/free-photo/cute-rat-wearing-clothes-in-studio_23-2150840963.jpg?w=740&t=st=1728104220~exp=1728104820~hmac=bedd48c1268f3c80052fd5669483ff5539095a61746a2d54a2bf46bc5b4e0785" alt="Avatar" class="avatar">
    </div>

    <div class="container">
        <label for="product_id"><b>Product-id</b></label>
        <label style="color: darkred">
            <?php echo $errors['product_id'] ?? ''; ?>
            <?php echo $errors['user_id'] ?? ''; ?>
            <?php echo $add ?? ''; ?>
            <?php //echo $err ?? ''; ?> </label>
        <input type="text" placeholder="Enter product-id" name="product_id" required>

        <label for="amount"><b>Amount</b></label>
        <label style="color: darkred">
            <?php  echo $errors['amount'] ?? ''; ?>
            <?php //echo $errors['product_id'] ?? ''; ?> </label>
        <input type="amount" placeholder="Enter amount" name="amount" required>

        <button type="submit">Add to basket</button>

    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" class="cancelbtn">Cancel</button>

    </div>
</form>

<style>
    /* Bordered form */
    form {
        border: 3px solid #f1f1f1;
    }

    /* Full-width inputs */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Set a style for all buttons */
    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 30%;
    }

    /* Add a hover effect for buttons */
    button:hover {
        opacity: 0.8;
    }

    /* Extra style for the cancel button (red) */
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /* Center the avatar image inside this container */
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    /* Avatar image */
    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* The "Forgot password" text */
    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }
</style>

