<?php
session_start(); // Start the session for login management

include "connection.php"; // Ensure this file contains the database connection

if (isset($_POST["submit1"])) {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];  // No need to escape password for hashing

    // Fetch the user details from the database using the username
    $res = mysqli_query($link, "SELECT * FROM login WHERE username='$username'");
    
    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);

        // Verify the entered password with the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // If the login succeeds, store the user information in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];  // Store user ID for future use
            $_SESSION['role'] = $user['role'];  // Store the user role
            $_SESSION['name'] = $user['name'];  // Store the student name
            $_SESSION['student_id'] = $user['student_id'];  // Store the student id

            // Redirect based on the user's role
            if ($user['role'] == 'student') {
                header("Location: student.php");
            } elseif ($user['role'] == 'librarian') {
                header("Location: index.php");
            }
            exit();  // Ensure no further code is executed after redirection
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="bcplogo-mini.png">
    <script>
        // JavaScript function to toggle password visibility
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
    <!-- LEFT SIDE -->
    <div class="container">
        <div class="left">
            <div class="left-inside">
                <h2>Login</h2>
                <form name="form1" action="" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="password">Password</label>
                    <div class="password">
                        <input type="password" id="password" name="password" required>
                        <i id="eyeIcon" class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
                    </div>
                    
                    <button type="submit" name="submit1" value="Login">Login</button>
                </form>
                
                <?php
                if (isset($_POST["submit1"])) {
                    $username = mysqli_real_escape_string($link, $_POST['username']);
                    $password = mysqli_real_escape_string($link, $_POST['password']);

                    // Execute the query
                    $res = mysqli_query($link, "SELECT * FROM login WHERE username='$username'");

                    $user = mysqli_fetch_assoc($res);
                    $count = mysqli_num_rows($res);

                    if ($count == 0 || !password_verify($password, $user['password'])) {
                        // If login fails, display the alert message using PHP
                        echo '<div class="alert danger"><strong>Error!</strong> Invalid username or password.</div>';
                    } else {
                        // If login succeeds, store the username in the session
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $user['role'];  // Store the user role

                        // Redirect based on role
                        if ($user['role'] == 'student') {
                            header("Location: /Capstone Project/Capstone Project/Student/student.php");
                        } elseif ($user['role'] == 'librarian') {
                            header("Location: librarian.php");
                        }
                        exit(); // Ensure no further code is executed after redirection
                    }
                }
                ?>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right">
            <h1>Library Management System</h1>
            <div class="design"></div>
            <!-- Book Icon -->
            <i class="fas fa-book-open-reader book-icon"></i>
        </div>
    </div>
</body>
</html>