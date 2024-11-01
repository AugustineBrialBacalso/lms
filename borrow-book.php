<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Query to get the total number of borrowed books per student
$sql = "SELECT student_id, student_name, COUNT(book_title) AS num_borrowed_books 
        FROM borrowers 
        GROUP BY student_id, student_name";

$result = $link->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin</title>
    <link rel="stylesheet" href="Admin.css"/>
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

    <div id="uppernav" class="uppernav" >
        <div class="upnav">
          <button class="openbtn" onclick="toggleNav()">☰</button>
          <?php
            if (isset($_SESSION['error_message'])) {
            ?>
                <span class="update-error">
                    <?php echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                </span>
            <?php
            }

            if (isset($_SESSION['success_message'])) {
            ?>
                <span class="update-success">
                    <?php echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                    ?>
                </span>
            <?php
            }
            ?>
        </div>

        <div class="tab-container">
        <table class="tab-con">
            <thead class="tab-head">
                <h4 class="tabcon-head">Borrow Book</h4>
                <a href="add-new-borrow.php"><button class="addnew-borrow" title="Add New Borrower"> <i class="fa-solid fa-plus"></i> Add new</button></a>

                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search...">
                    <button class="search-button">🔍</button>
                </div>

                <tr>
                    <th class="tab-id">Student ID</th>
                    <th class="tab-stdname">Student Name</th>
                    <th class="tab-borrow">No. of Books Borrowed</th>
                    <th colspan="3" class="tab-action">Action</th>
                </tr>
            </thead>
            
            <tbody class="borrower">
                <?php
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                        echo "<td class='data'>" . htmlspecialchars($row['num_borrowed_books']) . " Books</td>";
                        $studentName = htmlspecialchars($row['student_name']);
                        echo "<td><a href='view-borrow.php?id=" . $row['student_id'] . "' title='View'><button class='view-btn-borrower'> <i class='fa-solid fa-eye'></i> </button></a></td>";
                        echo "<td><a href='update-borrow.php?id=" . $row['student_id'] . "' title='Update'><button class='update-btn-borrower'> <i class='fa-solid fa-pencil'></i> </button></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No borrowers found</td></tr>";
                }
                ?>
            </tbody>
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