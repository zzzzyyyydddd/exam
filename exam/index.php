<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$customers = getAllCustomers($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Silogan Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="user-bar">
        <span>Logged in as: <strong><?= htmlspecialchars($_SESSION['username']); ?></strong> (<?= htmlspecialchars($_SESSION['full_name']); ?>)</span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <h2>Add New Customer</h2>
    <form action="core/handleForms.php" method="POST">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>
        
        <label>Contact Number:</label>
        <input type="text" name="contact_number" required>
        
        <input type="submit" name="addCustomerBtn" value="Add Customer">
    </form>

    <h2>Registered Customers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Contact Number</th>
            <th>Added By</th>
            <th>Last Updated</th>
            <th>Last Updated By</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= $customer['customer_id']; ?></td>
            <td><?= htmlspecialchars($customer['customer_name']); ?></td>
            <td><?= htmlspecialchars($customer['contact_number']); ?></td>
            <td><?= htmlspecialchars($customer['added_by']); ?></td>
            <td><?= $customer['last_updated']; ?></td>
            <td><?= htmlspecialchars($customer['last_updated_by']); ?></td>
            <td>
                <a href="add_order.php?customer_id=<?= $customer['customer_id']; ?>">View/Add Orders</a> | 
                <a href="edit_customer.php?customer_id=<?= $customer['customer_id']; ?>">Edit</a> | 
                <a href="core/handleForms.php?deleteCustomer=<?= $customer['customer_id']; ?>" class="delete-btn" onclick="return confirm('Deleting customer will also delete their orders. Proceed?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>