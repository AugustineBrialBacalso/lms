<?php
session_start();
require 'connection.php'; // Add database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
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

        <div class="transaction-container">
            <table class="transaction">
                <thead class="transaction-head">
                    <?php
                    $query = "SELECT * from transaction_history";
                    $result = mysqli_query($link, $query);
                    ?>

                    <h4 class="transaction-title-history">Transaction History</h4>
                    <tr>
                        <th class="transactionname">Name</th>
                        <th class="transaction-content">Type</th>
                        <th class="transaction-title">Title</th>
                        <th class="transaction-content">Date</th>
                        <th class="transaction-content">Time</th>
                    </tr>
                </thead>

                <tbody class="data-history">
                    <?php
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {

                            $date = $row['timestamp'];
                            echo "<tr>";
                            echo "<td>" . $row['std_name'] . "</td>";
                            echo "<td class='content-data'>" . $row['transaction_type'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td class='content-data'>" . date('m/d/Y', strtotime($date)) . "</td>";
                            echo "<td class='content-data'>" . date('h:i:s A', strtotime($date)) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td rowspan='5'>" . "No Transaction Available" . "</td></tr>";
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