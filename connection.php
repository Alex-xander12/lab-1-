<?php
session_start();

// Database credentials
$host = "localhost";
$username = "root";  // Update if needed
$password = "";      // Update if applicable
$dbname = "posa";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


//  FORM SUBMISSION HANDLER

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];


        // REGISTRATION PROCESS

        if ($action == 'register') {
            // Retrieve and sanitize form inputs
            $student_id = trim($_POST['student_id']);
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $gender = trim($_POST['gender']);
            $course = trim($_POST['course']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);


            //  PASSWORD VALIDATION

            $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

            if (!preg_match($passwordPattern, $password)) {
                $_SESSION['error'] = "Password must contain at least:\n- One uppercase letter\n- One lowercase letter\n- One number\n- One special character\n- Minimum 8 characters.";
                header("Location: register.php");
                exit();
            }

            // Check if passwords match
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match. Please try again.";
                header("Location: register.php");
                exit();
            }


            //  CHECK IF STUDENT ID OR EMAIL EXISTS

            $checkQuery = "SELECT * FROM posa WHERE student_id = ? OR email = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param('ss', $student_id, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['student_id'] === $student_id) {
                    $_SESSION['error'] = "Error: Student ID already exists!";
                } elseif ($row['email'] === $email) {
                    $_SESSION['error'] = "Error: Email already exists!";
                }
                header("Location: register.php");
                exit();
            }


            // HASH PASSWORD AND INSERT RECORD

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insertQuery = "INSERT INTO posa (student_id, name, email, phone, gender, course, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('sssssss', $student_id, $name, $email, $phone, $gender, $course, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Please log in.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Error: Could not register. Please try again.";
                header("Location: register.php");
                exit();
            }
        }

        //  LOGIN PROCESS

        if ($action == 'login') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Check if email exists
            $checkQuery = "SELECT * FROM posa WHERE email = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Store user information in session
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['student_id'] = $user['student_id'];

                    echo '<script>
                            alert("Login successful!");
                            window.location.href="index.html";
                          </script>';
                    exit();
                } else {
                    $_SESSION['error'] = "Invalid password. Please try again.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "No account found with that email.";
                header("Location: login.php");
                exit();
            }
        }
    }
}

// Close the connection
$conn->close();
?>
