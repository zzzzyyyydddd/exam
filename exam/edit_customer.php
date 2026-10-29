<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$customer = getCustomerByID($pdo, $_GET['customer_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Customer</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="customer_id" value="<?= $customer['customer_id']; ?>">
        
        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer['customer_name']); ?>" required>
        
        <label>Contact Number:</label>
        <input type="text" name="contact_number" value="<?= htmlspecialchars($customer['contact_number']); ?>" required>
        
        <input type="submit" name="editCustomerBtn" value="Update Customer">
        <p><a href="index.php">Cancel</a></p>
    </form>
</body>
</html>