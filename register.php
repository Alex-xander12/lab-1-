<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>

    <section class="auth-section">
        <div class="auth-container">
            <h2>Student Registration Form</h2>

            <!--  Show error or success messages -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red; text-align: center;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p style='color:green; text-align: center;'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>

            <!--  Registration form with action set to connection.php -->
            <form action="connection.php" method="POST" class="auth-form" id="register-form">
                <!-- Hidden input to indicate registration action -->
                <input type="hidden" name="action" value="register">

                <label for="student_id">Student ID Number</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter your Student ID Number" required>

                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label>Gender</label>
                <div class="gender-options">
                    <label><input type="radio" name="gender" value="male" required> Male</label>
                    <label><input type="radio" name="gender" value="female" required> Female</label>
                    <label><input type="radio" name="gender" value="other" required> Other</label>
                </div>

                <label for="course">Course</label>
                <select id="course" name="course" required>
                    <option value="" disabled selected>Select your course</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Business Administration">Business Administration</option>
                </select>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <button type="submit" class="btn-auth">Register</button>
                <br><br>

                <center><a href="login.php" class="btn-auth-link">Already have an account? Login here</a></center>
            </form>
        </div>
    </section>

    <!--  JavaScript Validation & Alerts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("register-form");
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("confirm_password");

            form.addEventListener("submit", function (event) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // 📚 Password pattern for strong security
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                if (!passwordPattern.test(password)) {
                    alert(" Password must contain at least:\n- One uppercase letter\n- One lowercase letter\n- One number\n- One special character\n- Minimum 8 characters.");
                    event.preventDefault();
                    return;
                }

                //  Check if passwords match
                if (password !== confirmPassword) {
                    alert(" Passwords do not match. Please try again.");
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>

</body>

</html>
