<?php
require 'db_connect.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
			if (password_verify($password, $user['password_hash'])) {
            echo "<script>alert('Login successful! Welcome, {$user['name']}'); window.location.href='admin.html';</script>";
        } else {
            echo "<script>alert('Incorrect password! Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found with that email.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorrowIt Suhay CE | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-body">
    <header class="login-header">
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="PLV Logo" class="header-logo">
            <h1>BorrowIt Suhay CE</h1>
            <img src="img/suhay ce logo.jpg" alt="Suhay CE Logo" class="header-logo">
        </div>
    </header>

    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">Admin Login</h2>

            <form class="login-form" method="POST" action="login.php">
                <div class="form-input">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-input">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="loginPassword" alt="Toggle password visibility">
                    </div>
                </div>

                <button type="submit" class="action-btn primary login-btn">Login</button>
            </form>

            <div class="register-link">
                <p>Register as Admin?</p>
                <a href="register.php" class="action-btn secondary register-btn">Register</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const targetId = icon.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                if (!passwordInput) return;

                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.src = isPassword ? 'img/eyeOpen.png' : 'img/eyeClose.png';
            });
        });
    </script>
</body>
</html>
