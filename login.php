<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pizza Moka</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>

    <section class="auth-section">
        <div class="auth-container">
            <h2>Login</h2>

            <?php
            if (isset($_SESSION['error'])){
                echo "<p style ='color:red ; text-align: center;'>" . $_SESSION['error'] . "</p>";
                unset ($_SESSION['error']);
            }
            
            
            ?>

            <form action="connection.php" method="POST" class="auth-form">
            <!-- Hidden field to specify login action -->
            <input type="hidden" name="action" value="login">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="btn-auth">Login</button>
            </form>
            <br>
            <br>

            <?php
            if (isset($_SESSION['error'])) {
            echo "<p style='color:red; text-align: center;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
            }
            ?>

            
           <center> <a href="register.php"class="btn-auth-link">Don't have an account? Register here</a> </center>
         </div>
    </section>

</body>

</html>


