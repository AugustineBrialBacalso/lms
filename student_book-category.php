<?php
session_start();
// Include the database connection file
include('C:\xampp\htdocs\Capstone Project\Admin\connection.php'); // Include your database connection

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}
if (!isset($_GET['course_code'])){
header("Location: index.php");
}else{
    $course_code = $_GET['course_code'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="opac.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" href="img/bcplogo-mini.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</head>

<body>
    <div id="sidenav" class="sidenav">
        <?php
        include('student_side_nav.php');
        ?>
    </div>

    <div id="uppernav" class="uppernav">
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

        <div class="listbook-container">
            <h4 class="list-name">Books for <?php echo $course_code;?></h4>

            <table class="tbl-container">
                <div class="search-con">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="search-btn">🔍</button>
                </div>

                <thead class="list-head">
                    <tr>
                        <th class="list-book">Title</th>
                        <th class="list-title">Author</th>
                        <th class="list-quantity">Quantity</th>
                    </tr>
                </thead>

                <tbody class="list-tbody">
                    <?php
                    // Loop through the fetched book records and display in the table
                    $query = "SELECT id, title, author, quantity FROM books WHERE category = '$course_code'" ; // Removed 'status'
                    $result = mysqli_query($link, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='list-tiles'>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td class='list-pad'>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td class='list-pad'>" . htmlspecialchars($row['quantity']) . "</td>";
                            $title = htmlspecialchars($row['title']);
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='no-data'>No books found</td></tr>";
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

        //message confirmation
        $(document).ready(function() {
            $("a.delete").click(function(e) {
                if (!confirm('Are you sure you want to delete this book?')) {
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });

    </script>


</body>

</html>