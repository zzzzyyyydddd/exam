<?php
require_once 'dbConfig.php';
require_once 'models.php';

// user registration
if (isset($_POST['registerBtn'])) {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (registerUser($pdo, $username, $first_name, $last_name, $email, $password)) {
        header("Location: ../login.php?success=Registered successfully! Please log in.");
    } else {
        header("Location: ../register.php?error=Username or email already exists.");
    }
    exit();
}

// user login
if (isset($_POST['loginBtn'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (loginUser($pdo, $username, $password)) {
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=Invalid username or password.");
    }
    exit();
}

// auth check
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$currentUser = $_SESSION['username'];

// customer crud
if (isset($_POST['addCustomerBtn'])) {
    insertCustomer($pdo, $_POST['customer_name'], $_POST['contact_number'], $currentUser);
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['editCustomerBtn'])) {
    updateCustomer($pdo, $_POST['customer_id'], $_POST['customer_name'], $_POST['contact_number'], $currentUser);
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['deleteCustomer'])) {
    deleteCustomer($pdo, $_GET['deleteCustomer']);
    header("Location: ../index.php");
    exit();
}

// order crud
if (isset($_POST['addOrderBtn'])) {
    $customer_id = $_POST['customer_id'];
    insertOrder($pdo, $customer_id, $_POST['silog_meal'], $_POST['drink_choice'], $_POST['quantity'], $_POST['total_price'], $currentUser);
    header("Location: ../add_order.php?customer_id=" . $customer_id);
    exit();
}

if (isset($_POST['editOrderBtn'])) {
    $customer_id = $_POST['customer_id'];
    updateOrder($pdo, $_POST['order_id'], $_POST['silog_meal'], $_POST['drink_choice'], $_POST['quantity'], $_POST['total_price'], $currentUser);
    header("Location: ../add_order.php?customer_id=" . $customer_id);
    exit();
}

if (isset($_GET['deleteOrder'])) {
    $customer_id = $_GET['customer_id'];
    deleteOrder($pdo, $_GET['deleteOrder']);
    header("Location: ../add_order.php?customer_id=" . $customer_id);
    exit();
}
?>