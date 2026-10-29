<?php
require_once 'dbConfig.php';

// --- USER AUTHENTICATION FUNCTIONS ---
function registerUser($pdo, $username, $first_name, $last_name, $email, $password) {
    $checkUser = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkUser->execute([$username, $email]);
    if ($checkUser->rowCount() > 0) {
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$username, $first_name, $last_name, $email, $hashedPassword]);
}

function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
        return true;
    }
    return false;
}

// --- PARENT ENTITY: CUSTOMERS ---
function getAllCustomers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM customers ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getCustomerByID($pdo, $customer_id) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $stmt->execute([$customer_id]);
    return $stmt->fetch();
}

function insertCustomer($pdo, $customer_name, $contact_number, $added_by) {
    $stmt = $pdo->prepare("INSERT INTO customers (customer_name, contact_number, added_by, last_updated_by) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$customer_name, $contact_number, $added_by, $added_by]);
}

function updateCustomer($pdo, $customer_id, $customer_name, $contact_number, $last_updated_by) {
    $stmt = $pdo->prepare("UPDATE customers SET customer_name = ?, contact_number = ?, last_updated_by = ? WHERE customer_id = ?");
    return $stmt->execute([$customer_name, $contact_number, $last_updated_by, $customer_id]);
}

function deleteCustomer($pdo, $customer_id) {
    $stmtOrders = $pdo->prepare("DELETE FROM orders WHERE customer_id = ?");
    $stmtOrders->execute([$customer_id]);

    $stmt = $pdo->prepare("DELETE FROM customers WHERE customer_id = ?");
    return $stmt->execute([$customer_id]);
}

// --- CHILD ENTITY: ORDERS ---
function getOrdersByCustomer($pdo, $customer_id) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY order_id DESC");
    $stmt->execute([$customer_id]);
    return $stmt->fetchAll();
}

function getOrderByID($pdo, $order_id) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->execute([$order_id]);
    return $stmt->fetch();
}

function insertOrder($pdo, $customer_id, $silog_meal, $drink_choice, $quantity, $total_price, $added_by) {
    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, silog_meal, drink_choice, quantity, total_price, added_by, last_updated_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$customer_id, $silog_meal, $drink_choice, $quantity, $total_price, $added_by, $added_by]);
}

function updateOrder($pdo, $order_id, $silog_meal, $drink_choice, $quantity, $total_price, $last_updated_by) {
    $stmt = $pdo->prepare("UPDATE orders SET silog_meal = ?, drink_choice = ?, quantity = ?, total_price = ?, last_updated_by = ? WHERE order_id = ?");
    return $stmt->execute([$silog_meal, $drink_choice, $quantity, $total_price, $last_updated_by, $order_id]);
}

function deleteOrder($pdo, $order_id) {
    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
    return $stmt->execute([$order_id]);
}
?>