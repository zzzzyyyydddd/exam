<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Silogan Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { width: 320px; padding: 20px; border: 1px solid #ccc; }
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>User Login</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success"><?= htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    <form action="core/handleForms.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="loginBtn" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>