<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Silogan Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { width: 320px; padding: 20px; border: 1px solid #ccc; }
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>User Registration</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form action="core/handleForms.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        <label>Last Name:</label>
        <input type="text" name="last_name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="registerBtn" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>