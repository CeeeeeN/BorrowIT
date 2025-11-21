<?php
require 'DB.php'; // Connect to database
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
    $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (insert): " . $conn->error);
    }

    $stmt->bind_param("sss", $fullname, $email, $passwordHash);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.php';</script>";
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
    <title>BorrowIT Suhay CE | Register</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Password Match Indicator Styles */
        .password-indicator {
            margin-top: 8px;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: none;
            transition: all 0.3s ease;
        }

        .password-indicator.show {
            display: block;
        }

        .password-indicator.match {
            background-color: #dcfce7;
            color: #16a34a;
            border: 1px solid #86efac;
        }

        .password-indicator.match::before {
            content: "✓ ";
            font-weight: bold;
        }

        .password-indicator.no-match {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .password-indicator.no-match::before {
            content: "✗ ";
            font-weight: bold;
        }

        /* Visual feedback on input fields */
        .form-input input.password-match {
            border-color: #16a34a !important;
        }

        .form-input input.password-no-match {
            border-color: #dc2626 !important;
        }

        /* Improved error message styling */
        #errorMessage {
            color: #dc2626;
            font-size: 14px;
            display: none;
            background-color: #fee2e2;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #fca5a5;
            margin-top: 10px;
        }
    </style>
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

            <form class="register-form" action="register.php" method="POST" id="registerForm" onsubmit="return validatePassword()">
                
                <div class="form-input">
                    <label>Full Name</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Enter full name" required>
                </div>

                <div class="form-input">
                    <label>Email</label>
                    <input type="email" name="email" autocomplete="email" placeholder="Enter email address" required>
                </div>

                <div class="form-input">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" autocomplete="new-password" name="password" placeholder="Enter password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="password">
                    </div>
                </div>

                <div class="form-input">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" autocomplete="new-password" name="confirmPassword" placeholder="Confirm Password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="confirmPassword">
                    </div>
                    <div class="password-indicator" id="passwordIndicator"></div>
                </div>

                <p id="errorMessage">Passwords do not match.</p>

                <button type="submit" class="action-btn primary">Register</button>
            </form>

            <div class="register-link">
                <p>Already have an account?</p>
                <a href="login.php" class="action-btn secondary register-btn">Login</a>
            </div>
        </div>
    </div>

    <script>
        // === AUTOMATIC NAME CAPITALIZATION ===
        const fullnameInput = document.getElementById('fullname');

        fullnameInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Capitalize first letter of each word
            let capitalized = value.split(' ').map(word => {
                if (word.length > 0) {
                    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                }
                return word;
            }).join(' ');
            
            // Only update if different to avoid cursor jumping
            if (this.value !== capitalized) {
                const cursorPos = this.selectionStart;
                this.value = capitalized;
                // Maintain cursor position after capitalization
                this.setSelectionRange(cursorPos, cursorPos);
            }
        });

        // === PASSWORD MATCHING WITH REAL-TIME INDICATOR ===
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordIndicator = document.getElementById('passwordIndicator');
        const errorMessage = document.getElementById('errorMessage');

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Only show indicator if confirm password field has content
            if (confirmPassword.length === 0) {
                passwordIndicator.classList.remove('show', 'match', 'no-match');
                passwordIndicator.textContent = '';
                confirmPasswordInput.classList.remove('password-match', 'password-no-match');
                errorMessage.style.display = 'none';
                return;
            }

            // Show the indicator
            passwordIndicator.classList.add('show');

            if (password === confirmPassword) {
                // Passwords match
                passwordIndicator.textContent = 'Passwords match!';
                passwordIndicator.classList.remove('no-match');
                passwordIndicator.classList.add('match');
                confirmPasswordInput.classList.remove('password-no-match');
                confirmPasswordInput.classList.add('password-match');
                errorMessage.style.display = 'none';
            } else {
                // Passwords don't match
                passwordIndicator.textContent = 'Passwords do not match';
                passwordIndicator.classList.remove('match');
                passwordIndicator.classList.add('no-match');
                confirmPasswordInput.classList.remove('password-match');
                confirmPasswordInput.classList.add('password-no-match');
            }
        }

        // Check password match on every keystroke
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // === TOGGLE PASSWORD VISIBILITY ===
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const targetId = icon.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.src = isPassword ? 'img/eyeOpen.png' : 'img/eyeClose.png';
            });
        });

        // === VALIDATE PASSWORD ON FORM SUBMISSION ===
        function validatePassword() {
            const pass = document.getElementById("password").value;
            const confirmPass = document.getElementById("confirmPassword").value;

            if (pass !== confirmPass) {
                document.getElementById("errorMessage").style.display = "block";
                confirmPasswordInput.focus();
                return false;
            }
            return true;
        }

        // Also prevent form submission with Enter key if passwords don't match
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!validatePassword()) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>