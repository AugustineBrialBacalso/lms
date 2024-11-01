<?php
session_start();
require 'connection.php'; // Add database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Fetch the book details based on the passed ID in the URL
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure the ID is valid

// If there's no ID, redirect back to the list of books
if ($book_id == 0) {
    header("Location: list-of-books.php");
    exit();
}

$sql = "SELECT * FROM books WHERE id = ?"; // Use prepared statement to avoid SQL injection
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $book_id); // Bind the ID
$stmt->execute();
$result = $stmt->get_result();

// Check if the book was found
if ($result->num_rows > 0) {
    $book = $result->fetch_assoc(); // Fetch the book details
} else {
    echo "Book not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin - View Book</title>
    <link rel="stylesheet" href="Admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
        <div class="view-container">
            <form class="viewbook">
                <div class="viewname">
                    <h4>View Details</h4>
                </div>

                <!-- Populate the input fields with the retrieved data from the database -->
                <label class="view-label">Title:</label>
                <input class="view-input" type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" readonly title="Title"></input>
                
                <label class="view-label">ISBN:</label>
                <input class="view-input" type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" readonly title="ISBN"></input>
                
                <label class="view-label">Author:</label>
                <input class="view-input" type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" readonly title="Author"></input>
                
                <label class="view-label">Publisher:</label>
                <input class="view-input" type="text" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" readonly title="Publisher"></input>
                
                <label class="view-label">Category:</label>
                <?php
                $course_code = htmlspecialchars($book['category']);
                    $sql = "SELECT * FROM course WHERE course_code = '$course_code'";
                    $result = mysqli_query($link, $sql);

                    if ($result->num_rows > 0) {
                    ?>
                        <?php

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <input class="view-categories" type="text" name="shelf_no" value="<?php echo $row['course_description']; ?>" readonly title="Shelf Number"></input>

                    <?php
                        }
                    }
                    ?>

                <label class="view-label">Shelf Number:</label>
                <input class="view-shelf" type="text" name="shelf_no" value="<?php echo htmlspecialchars($book['shelf_no']); ?>" readonly title="Shelf Number"></input>

                <label class="view-label-date">Date Published:</label>
                <input class="view-date" type="text" name="date_published" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo htmlspecialchars($book['date_published']); ?>" readonly title="Date Published"></input>

                <label class="view-label-qty">Quantity:</label>
                <input class="view-qty" type="text" name="quantity" min="0" value="<?php echo htmlspecialchars($book['quantity']); ?>" readonly title="Quantity"></input>
                            
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

        // Readonly the Select Option
        document.querySelector('.view-categories').addEventListener('mousedown', function(e) {
            e.preventDefault(); // Prevents dropdown from opening
        });

        
    </script>
</body>

</html>