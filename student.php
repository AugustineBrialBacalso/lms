<?php
session_start();
include('C:\xampp\htdocs\Capstone Project\Admin\connection.php'); // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="opac.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" href="img/bcplogo-mini.png">
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

        <div class="header">
    <table class="library"><br><br>
      <span class="main_txt"><b>Library Management</b></span><br>
      <span class="sub_txt"><b>Library</b></span>
  </div>
  <div class="search-container">
    <input type="text" class="search-bar" placeholder="Search...">
    <button class="search-button">🔍</button>
  </div>

  <h2 class="library-categories">Book Categories</h2>

<div class="content-container">
    <?php
    $query = "SELECT * FROM course WHERE status = 'Active'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <button class="category-box">
            <a style="text-decoration:none" href="student_book-category.php?course_code=<?php echo htmlspecialchars($row['course_code']); ?>">
                <h3 class="category-name"><?php echo htmlspecialchars($row['course_code']); ?></h3>
                <p class="description"><?php echo htmlspecialchars($row['course_description']); ?></p>
            </a>
        </button>
    <?php
        }
    }
    ?>
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