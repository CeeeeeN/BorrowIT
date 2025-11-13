<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval | BorrowIt Suhay CE</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="PLV Logo" class="header-logo">
            <img src="img/suhay ce logo.jpg" alt="Suhay CE Logo" class="header-logo">
            <h1>BorrowIT Suhay CE</h1>
        </div>
        <nav>
            <a href="admin_approval.php" class="nav-btn active">Superadmin</a>
            <a href="index.html" class="nav-btn">Dashboard</a>  
            <a href="inventory.php" class="nav-btn">Inventory</a>
            <a href="requests.php" class="nav-btn">Requests</a>
            <a href="records.php" class="nav-btn">Records</a>
        </nav>
    </header>

    <main class="admin-main">
        <!-- Pending Admin Registrations -->
        <div class="page-header">
            <div>
                <h2 class="page-title">Admin Registration Requests</h2>
                <p class="page-description">Approve or deny pending admin registration requests for system access.</p>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Paulo</td>
                        <td>paulo@gmail.com</td>
                        <td>Admin</td>
                        <td>
                            <form>
                                <button type="button" class="approve-btn">Approve</button>
                                <button type="button" class="deny-btn">Deny</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Existing Admin Accounts -->
        <div class="page-header admin-accounts-header">
            <div>
                <h2 class="page-title">Admin Accounts</h2>
                <p class="page-description">Manage current admin and superadmin accounts.</p>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chaelsy</td>
                        <td>ChaelsyHitTheJasPot@gmail.com</td>
                        <td>
                            <div class="password-wrapper">
                                <input type="password" value="hehe" class="admin-password">
                                <img class="toggle-password" src="img/eyeClose.png" alt="Toggle password visibility">
                            </div>
                        </td>
                        <td>
                            <select class="admin-role-select">
                                <option selected>SuperAdmin</option>
                                <option>Admin</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="approve-btn">Save Changes</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Mark 2</td>
                        <td>SKJERALD@gmail.com</td>
                        <td>
                            <div class="password-wrapper">
                                <input type="password" value="wahhhhh" class="admin-password">
                                <img class="toggle-password" src="img/eyeClose.png" alt="Toggle password visibility">
                            </div>
                        </td>
                        <td>
                            <select class="admin-role-select">
                                <option selected>Admin</option>
                                <option>SuperAdmin</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="approve-btn">Save Changes</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jas</td>
                        <td>VALERT@gmail.com</td>
                        <td>
                            <div class="password-wrapper">
                                <input type="password" value="halo" class="admin-password">
                                <img class="toggle-password" src="img/eyeClose.png" alt="Toggle password visibility">
                            </div>
                        </td>
                        <td>
                            <select class="admin-role-select">
                                <option selected>Admin</option>
                                <option>SuperAdmin</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="approve-btn">Save Changes</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.src = isHidden ? 'img/eyeOpen.png' : 'img/eyeClose.png';
            });
        });
    </script>
</body>

</html>
