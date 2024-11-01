<?php
session_start();
include('C:\xampp\htdocs\Capstone Project\Admin\connection.php'); // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get tomorrow's date
$tomorrow = date('Y-m-d', strtotime('+1 day'));

// Fetch due books data from the database
$studentId = $_SESSION['student_id']; // Assuming you store the student ID in the session
$query = "SELECT b.title, b.author, b.category, br.due_date 
          FROM borrowers br
          JOIN books b ON br.book_title = b.title 
          WHERE br.student_id = ? AND br.due_date = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("is", $studentId, $tomorrow); // Assuming student_id is an integer and due_date is a string
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Books</title>
    <link rel="stylesheet" href="opac.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" href="bcplogo-mini.png">
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

        <div class="listbook-container">
            <h4 class="list-name">Tomorrow's Due Books</h4>
            <table class="tbl-container">
                <div class="search-con">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="search-btn">🔍</button>
                </div>
                
                <thead class="list-head">
                    <tr>
                        <th class="list-book">Title</th>
                        <th class="list-title">Author</th>
                        <th class="list-title">Categories</th>
                        <th colspan="3" class="list-title">Due Date</th>
                    </tr>
                </thead>
                
                <tbody class="list-tbody">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="list-tiles"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="list-pad"><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="list-pad"><?php echo htmlspecialchars($row['category']); ?></td>
                            <td class="list-pad"><?php echo htmlspecialchars($row['due_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="list-pad">No due books found for tomorrow.</td>
                    </tr>
                <?php endif; ?>
            </table>
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