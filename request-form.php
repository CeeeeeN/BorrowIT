<?php
include("DB.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BorrowIt Suhay CE | Request Form</title>
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="request-form-body">
    <header class="request-form-header">
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="PLV Logo" class="header-logo">
            <h1>BorrowIT Suhay CE</h1>
            <img src="img/suhay ce logo.jpg" alt="Suhay CE Logo" class="header-logo">
        </div>
    </header>

    <div class="request-form-container">
        <div class="request-form-card">
            <h2 class="request-form-title">Borrow Request Form</h2>

            <form class="request-form-form" method="POST" action="submit-request.php">

                <div class="form-input">
                    <label>Student ID</label>
                    <input type="text" name="student_id" placeholder="Enter student ID" required>
                </div>

                <div class="form-input">
                    <label>Student Name</label>
                    <input type="text" name="student_name" placeholder="Enter student name" required>
                </div>

                <div class="form-input">
                    <label>Year & Section</label>
                    <input type="text" name="year_section" placeholder="Ex. BSCE 3-1" required>
                </div>

                <div class="form-input">
                    <label>Item to borrow</label>
                    <div class="search-item">
                        <input type="text" id="itemInput" placeholder="Select an Item" autocomplete="off" required>
                        <div class="dropdown-list" id="dropdownList">
                            <?php
                            $sql = "SELECT * FROM inventory";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['quantity'] >= 1) {
                                    echo "<div data-value='{$row['name']}'>{$row['name']}</div>";
                                }
                            }

                            ?>
                        </div>
                    </div>

                    <input type="hidden" name="item" id="itemValue">
                </div>

                <div class="form-input">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" placeholder="Enter quantity" required>
                </div>

                <button type="submit" class="action-btn primary">Submit Request</button>
            </form>
        </div>
    </div>

    <script>
        const input = document.getElementById("itemInput");
        const list = document.getElementById("dropdownList");
        const hidden = document.getElementById("itemValue");

        const studentIdInput = document.querySelector("input[name='student_id']");

        studentIdInput.addEventListener("input", function () {
            // Remove all non-digits
            let value = this.value.replace(/\D/g, "");

            // Auto-insert dash after 2 digits
            if (value.length > 2) {
                value = value.slice(0, 2) + "-" + value.slice(2);
            }

            // Limit to XX-XXXX format (7 characters total)
            this.value = value.slice(0, 7);
        });

        // Show dropdown when inputted
        input.addEventListener("focus", () => {
            list.style.display = "block";
        });

        // Filters while typing
        input.addEventListener("keyup", () => {
            let filter = input.value.toLowerCase();
            list.querySelectorAll("div").forEach(option => {
                option.style.display = option.textContent.toLowerCase().includes(filter) ? "block" : "none";
            });
        });

        // Selecting an item
        list.addEventListener("click", (e) => {
            if (e.target.matches("div")) {
                input.value = e.target.textContent;
                hidden.value = e.target.dataset.value;
                list.style.display = "none";
            }
        });

        //Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".search-item")) {
                list.style.display = "none";
            }
        });

        const studentNameInput = document.querySelector("input[name='student_name']");

        //Capitalizes the first letter for Student Name
        studentNameInput.addEventListener("input", function () {
            let words = this.value.split(" ");
            words = words.map(word => {
                if (word.length === 0) return "";
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            });
            this.value = words.join(" ");
        });

    </script>
</body>

</html>