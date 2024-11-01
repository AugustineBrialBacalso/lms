<?php
session_start();
require 'connection.php'; // Add database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Fetch the book details based on the passed ID in the URL
if (!isset($_GET['id'])) {
    header("location: borrow-book.php");
} else {
    $borrower_id = $_GET['id'];
}

if (isset($_POST['submit'])) {
    // Capture the form data
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $book_title = $_POST['book_title'];

    $sql = "UPDATE borrowers SET student_id='$student_id', student_name='$student_name', book_title='$book_title' WHERE id ='$borrower_id'";

    // Execute the query and check if the book was successfully added
    if (mysqli_query($link, $sql)) {
        $_SESSION['success_message'] = 'Borrower updated successfully';
        header("Location: borrow-book.php"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['error_message'] = 'Error Update Borrower!' . mysqli_error($link);
        header("Location: add-new-borrow.php"); // Redirect to the same page
        exit();
    }
}


$sql = "SELECT * FROM borrowers WHERE id = ?"; // Use prepared statement to avoid SQL injection
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $borrower_id); // Bind the ID
$stmt->execute();
$result = $stmt->get_result();

// Check if the book was found
if ($result->num_rows > 0) {
    $borrower = $result->fetch_assoc(); // Fetch the borrower details
} else {
    $_SESSION['error'] = "Book not found";
    header("location: view-borrow.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin</title>
    <link rel="stylesheet" href="Admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" href="img/bcplogo-mini.png">
</head>

<body>
    <div id="sidenav" class="sidenav">
        <?php
        include('side_nav.php');
        ?>
    </div>

    <div id="uppernav" class="uppernav">
        <div class="upnav">
            <button class="openbtn" onclick="toggleNav()">☰</button>
        </div>

        <div class="update-borrow-container">
            <form class="update-con" method="post">
                <div class="update-name">
                    <h4>Update Borrower</h4>
                </div>

                <label class="update-borrow-label">Student Id:</label>
                <input class="update-input-borrow" type="text" name="student_id" value="<?php echo htmlspecialchars($borrower['student_id']); ?>" placeholder="Student Id" required></input>

                <label class="update-borrow-label">Student Name:</label>
                <input class="update-input-borrow" type="text" name="student_name" value="<?php echo htmlspecialchars($borrower['student_name']); ?>" placeholder="Student Name" required></input>

                <label class="update-borrow-label">Title:</label>
                <input class="update-input-borrow" type="text" name="book_title" value="<?php echo htmlspecialchars($borrower['book_title']); ?>" placeholder="Title" required></input>

                <input class="reset" type="reset"></input>
                <button class="update-borrow" name="submit">Submit</button>
                <a class="update-borrow-cancel" href="borrow-book.php">Cancel</a>

            </form>
        </div>

    </div>

    <script type="text/javascript">
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

        var dropdown = document.getElementsByClassName("drpdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
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

        // Toggle Profile Popup
        document.getElementById('userBtn').addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the click from propagating to the window
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

        // Hide the popup when clicking outside of it
        window.addEventListener('click', function(event) {
            var popup = document.getElementById('profilePopup');
            var userBtn = document.getElementById('userBtn');
            if (!popup.contains(event.target) && !userBtn.contains(event.target)) {
                popup.style.display = 'none';
                userBtn.setAttribute('aria-expanded', 'false');
                popup.setAttribute('aria-hidden', 'true');
            }
        });

        // Close popup with Esc key
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