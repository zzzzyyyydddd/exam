<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$order = getOrderByID($pdo, $_GET['order_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Order ID #<?= $order['order_id']; ?></h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
        <input type="hidden" name="customer_id" value="<?= $order['customer_id']; ?>">

        <label>Silog Meal Choice:</label>
        <input type="text" name="silog_meal" value="<?= htmlspecialchars($order['silog_meal']); ?>" required>

        <label>Drink Choice:</label>
        <input type="text" name="drink_choice" value="<?= htmlspecialchars($order['drink_choice']); ?>">

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $order['quantity']; ?>" required>

        <label>Total Price:</label>
        <input type="number" step="0.01" name="total_price" value="<?= $order['total_price']; ?>" required>

        <input type="submit" name="editOrderBtn" value="Update Order">
        <p><a href="add_order.php?customer_id=<?= $order['customer_id']; ?>">Cancel</a></p>
    </form>
</body>
</html>