<?php
//session_start();
//
//if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
//    switch ($_GET['action']) {
//        case 'add':
//            $id = $_GET['id'];
//            $query = "SELECT * FROM products WHERE id = $id";
//            $result = $conn->query($query);
//            $product = $result->fetch_assoc();
//
//            if (!isset($_SESSION['cart'])) {
//                $_SESSION['cart'] = [];
//            }
//
//            if (isset($_SESSION['cart'][$id])) {
//                $_SESSION['cart'][$id]['quantity']++;
//            } else {
//                $_SESSION['cart'][$id] = [
//                    'name' => $product['name'],
//                    'price' => $product['price'],
//                    'quantity' => 1
//                ];
//            }
//
//            header('Location: cart.php');
//            break;
//
//        case 'remove':
//            $id = $_GET['id'];
//            if (isset($_SESSION['cart'][$id])) {
//                unset($_SESSION['cart'][$id]);
//            }
//
//            header('Location: cart.php');
//            break;
//    }
//}
//
//$total_price = 0;
//if (isset($_SESSION['cart'])) {
//    foreach ($_SESSION['cart'] as $item) {
//        $total_price += $item['price'] * $item['quantity'];
//    }
//}
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Ваша корзина</h1>
<div class="cart">
    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> руб.</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price'] * $item['quantity']; ?> руб.</td>
                    <td><a href="cart.php?action=remove&id=<?php echo $id; ?>">Удалить</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>Общая стоимость: <?php echo $total_price; ?> руб.</p>
        <a href="checkout.php">Оформить заказ</a>
    <?php else: ?>
        <p>Ваша корзина пуста</p>
    <?php endif; ?>
</div>
</body>
</html>