<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['customer_id'])) {
    header("Location: index.php");
    exit();
}

$customer_id = $_GET['customer_id'];
$customer = getCustomerByID($pdo, $customer_id);
$orders = getOrdersByCustomer($pdo, $customer_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="user-bar">
        <span>Logged in as: <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <a href="index.php" class="back-link">← Back to Customers</a>
    <h2>Add Order for Customer: <span style="color: darkred;"><?= htmlspecialchars($customer['customer_name']); ?></span></h2>

    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">

        <label>Silog Meal Choice:</label>
        <select name="silog_meal" required>
            <option value="Tapsilog">Tapsilog</option>
            <option value="Longsilog">Longsilog</option>
            <option value="Tocilog">Tocilog</option>
            <option value="Bangsilog">Bangsilog</option>
            <option value="Chicksilog">Chicksilog</option>
        </select>

        <label>Drink Choice:</label>
        <select name="drink_choice" required>
            <option value="Iced Tea">Iced Tea</option>
            <option value="Softdrink">Softdrink</option>
            <option value="Coffee">Coffee</option>
            <option value="Pineapple Juice">Pineapple Juice</option>
            <option value="Water">Water</option>
            <option value="None">None</option>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" value="1" required>

        <label>Total Price (PHP):</label>
        <input type="number" step="0.01" name="total_price" placeholder="0.00" required>

        <input type="submit" name="addOrderBtn" value="Place Order">
    </form>

    <h2>Order History</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Silog Meal</th>
            <th>Drink Choice</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Added By</th>
            <th>Last Updated</th>
            <th>Last Updated By</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id']; ?></td>
                <td><?= htmlspecialchars($order['silog_meal']); ?></td>
                <td><?= htmlspecialchars($order['drink_choice']); ?></td>
                <td><?= $order['quantity']; ?></td>
                <td>₱<?= number_format($order['total_price'], 2); ?></td>
                <td><?= htmlspecialchars($order['added_by']); ?></td>
                <td><?= $order['last_updated']; ?></td>
                <td><?= htmlspecialchars($order['last_updated_by']); ?></td>
                <td>
                    <a href="edit_order.php?order_id=<?= $order['order_id']; ?>">Edit</a> | 
                    <a href="core/handleForms.php?deleteOrder=<?= $order['order_id']; ?>&customer_id=<?= $customer_id; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align: center;">No orders found for this customer. Place an order above!</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>