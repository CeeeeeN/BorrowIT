<?php
require 'db_connect.php'; // Connect to database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // helps show MySQL errors for debugging

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if email already exists in the 'admin' table
    $checkEmail = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    if (!$checkEmail) {
        die("Prepare failed (checkEmail): " . $conn->error);
    }

    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.history.back();</script>";
        exit();
    }

    // Hash the password securely
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin record
    $stmt = $conn->prepare("INSERT INTO admin (name, email, password_hash) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (insert): " . $conn->error);
    }

    $stmt->bind_param("sss", $fullname, $email, $passwordHash);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: Could not register admin. Please try again.'); window.history.back();</script>";
    }

    // Close all
    $stmt->close();
    $checkEmail->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorrowIt Suhay CE | Register</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="register-body">
    <header class="register-header">
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="PLV Logo" class="header-logo">
            <h1>BorrowIt Suhay CE</h1>
            <img src="img/suhay ce logo.jpg" alt="Suhay CE Logo" class="header-logo">
        </div>
    </header>

    <div class="register-container">
        <div class="register-card">
            <h2 class="register-title">Admin Registration</h2>

            <form class="register-form" action="register.php" method="POST" onsubmit="return validatePassword()">
                
                <div class="form-input">
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Enter full name" required>
                </div>

                <div class="form-input">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-input">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="password">
                    </div>
                </div>

                <div class="form-input">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="confirmPassword">
                    </div>
                </div>

                <p id="errorMessage" style="color:red; font-size:14px; display:none;">Passwords do not match.</p>

                <button type="submit" class="action-btn primary">Register</button>
            </form>

            <div class="register-link">
                <p>Already have an account?</p>
                <a href="login.php" class="action-btn secondary register-btn">Login</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const targetId = icon.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.src = isPassword ? 'img/eyeOpen.png' : 'img/eyeClose.png';
            });
        });

        // Validate Confirm Password
        function validatePassword() {
            const pass = document.getElementById("password").value;
            const confirmPass = document.getElementById("confirmPassword").value;

            if (pass !== confirmPass) {
                document.getElementById("errorMessage").style.display = "block";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
