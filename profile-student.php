<?php
session_start();
include('C:\xampp\htdocs\Capstone Project\Admin\connection.php'); // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Fetch user details based on session username
$username = $_SESSION['username'];
$sql = "SELECT username FROM login WHERE username = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_username'])) {
        // Update username logic
        $new_username = $_POST['username'];
        
        // Check if the new username is different and not empty
        if (!empty($new_username) && $new_username != $username) {
            $update_sql = "UPDATE login SET username = ? WHERE username = ?";
            $update_stmt = $link->prepare($update_sql);
            $update_stmt->bind_param("ss", $new_username, $username);
            
            if ($update_stmt->execute()) {
                // Update session username
                $_SESSION['username'] = $new_username;

                // Set success message
                $_SESSION['message'] = "Username updated successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error updating username.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "No changes were made to the username.";
            $_SESSION['message_type'] = "error";
        }
    }

    if (isset($_POST['change_password'])) {
        // Update password logic
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch the current password from the database
        $password_sql = "SELECT password FROM login WHERE username = ?";
        $password_stmt = $link->prepare($password_sql);
        $password_stmt->bind_param("s", $username);
        $password_stmt->execute();
        $password_result = $password_stmt->get_result();
        $password_data = $password_result->fetch_assoc();

        // Check if current password is correct
        if (password_verify($current_password, $password_data['password'])) {
            // Check if new password and confirm password match
            if ($new_password == $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_password_sql = "UPDATE login SET password = ? WHERE username = ?";
                $update_password_stmt = $link->prepare($update_password_sql);
                $update_password_stmt->bind_param("ss", $hashed_password, $username);

                if ($update_password_stmt->execute()) {
                    $_SESSION['message'] = "Password changed successfully!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Error changing password.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "New password and confirm password do not match.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Current password is incorrect.";
            $_SESSION['message_type'] = "error";
        }
    }

    header("Location: profile-student.php");
    exit();
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="opac.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" href="bcplogo-mini.png">
    <script type="text/javascript"> 
        window.onload = function() {
            <?php if (isset($_SESSION['message'])): ?>
                var message = "<?php echo $_SESSION['message']; ?>";
                var messageType = "<?php echo $_SESSION['message_type']; ?>";

                var alertBox = document.getElementById('alertBox');
                var alertMessage = document.getElementById('alertMessage');
                alertBox.style.display = 'block';
            
                if (messageType === 'success') {
                    alertBox.classList.add('success');
                    alertMessage.innerHTML = message;
                } else {
                    alertBox.classList.add('danger');
                    alertMessage.innerHTML = message;
                }

                <?php unset($_SESSION['message']); ?>
                <?php unset($_SESSION['message_type']); ?>
            <?php endif; ?>
        }

        // Toggle password visibility
        function togglePasswordVisibility(id) {
            var passwordInput = document.getElementById(id);
            var eyeIcon = passwordInput.nextElementSibling;

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } 
            else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
<div id="sidenav" class="sidenav">
        <?php
        include('student_side_nav.php');
        ?>
    </div>

<div id="uppernav" class="uppernav" >
        <div class="upnav">
          <button class="openbtn" onclick="toggleNav()">☰</button>
        </div>

        <!-- MY PROFILE -->
        <div class="up_profile">
            <h1>My Profile</h1>

            <div id="alertBox" class="alert" style="display: none;">
                <strong id="alertMessage"></strong>
            </div>

            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <button type="submit" name="update_username">Update Username</button>
            </form>
        </div>

        <div class="ch_password">
            <h2>Change Password</h2>
            <form method="post">
                <label for="current_password">Current Password:</label>
                <div class="password-container">
                    <input type="password" id="current_password" name="current_password" required>
                    <i class="fa fa-eye" onclick="togglePasswordVisibility('current_password')"></i>
                </div>
                
                <label for="new_password">New Password:</label>
                <div class="password-container">
                    <input type="password" id="new_password" name="new_password" required>
                    <i class="fa fa-eye" onclick="togglePasswordVisibility('new_password')"></i>
                </div>

                <label for="confirm_password">Confirm New Password:</label>
                <div class="password-container">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <i class="fa fa-eye" onclick="togglePasswordVisibility('confirm_password')"></i>
                </div>

                <button type="submit" name="change_password">Change Password</button>
            </form>
        </div>
    </div>

    <script type="text/javascript">
         // Sidebar toggle
         function toggleNav() {
            const sidenav = document.getElementById("sidenav");
            const uppernav = document.getElementById("uppernav");

            if (sidenav.style.left === "0px") {
                sidenav.style.left = "-280px";
                uppernav.style.marginLeft = "0";
            } else {
                sidenav.style.left = "0";
                uppernav.style.marginLeft = "280px";
            }
        }

        // Dropdown toggle
        var dropdown = document.getElementsByClassName("drpdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }

        // Profile popup toggle
        document.getElementById('userBtn').addEventListener('click', function(event) {
            event.stopPropagation(); 
            var popup = document.getElementById('profilePopup');
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
                this.setAttribute('aria-expanded', 'false');
                popup.setAttribute('aria-hidden', 'true');
            } else {
                popup.style.display = 'block';
                this.setAttribute('aria-expanded', 'true');
                popup.setAttribute('aria-hidden', 'false');
            }
        });

        window.addEventListener('click', function(event) {
            var popup = document.getElementById('profilePopup');
            var userBtn = document.getElementById('userBtn');
            if (!popup.contains(event.target) && !userBtn.contains(event.target)) {
                popup.style.display = 'none';
                userBtn.setAttribute('aria-expanded', 'false');
                popup.setAttribute('aria-hidden', 'true');
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                var popup = document.getElementById('profilePopup');
                var userBtn = document.getElementById('userBtn');
                popup.style.display = 'none';
                userBtn.setAttribute('aria-expanded', 'false');
                popup.setAttribute('aria-hidden', 'true');
            }
        });
    </script>
</body>
</html>
