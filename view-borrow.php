<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Get the student_id from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query to get the student details and borrowed books
    $student_query = "SELECT student_name, student_id FROM borrowers WHERE student_id = ?";
    $stmt = $link->prepare($student_query);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $student_name = $student['student_name'];
        $student_id = $student['student_id'];
        
        // Query to get the borrowed books by the student
        $books_query = "SELECT book_title, borrowed_date, due_date FROM borrowers WHERE student_id = ?";
        $stmt = $link->prepare($books_query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $books_result = $stmt->get_result();
    } else {
        echo "Student not found.";
        exit();
    }
}

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
        </div>

        <div class="viewborrow-container">
            <h4 class="borrow-name"><?php echo htmlspecialchars($student_name); ?></h4>
            <h2 class="borrow-id"><?php echo htmlspecialchars($student_id); ?></h2>
        
            <table class="view-tbl-container">
                <thead class="borrow-head">
                    <tr>
                        <th class="view-booktitle">Title</th>
                        <th class="view-borrowdate">Borrowed Date</th>
                        <th class="view-duedate">Due Date</th>
                        <th class="view-action">Action</th>
                    </tr>
                </thead>

                <tbody class="borrow-body">
                <?php
                if ($books_result->num_rows > 0) {
                    while ($book = $books_result->fetch_assoc()) {
                        $borrow_date = $book['borrowed_date'];
                        $due_date = $book['due_date'];
                        
                        echo "<tr>";
                        echo "<td class='view-title-data'>" . htmlspecialchars($book['book_title']) . "</td>";
                        // echo "<td class='view-borrowdate-data'>" . htmlspecialchars($book['borrowed_date']) . "</td>";
                        echo "<td class='view-borrowdate-data'>" . date('m/d/Y', strtotime(($borrow_date))) . "</td>";
                        echo "<td class='view-duedate-data'>" . date('m/d/Y', strtotime(($due_date))) . "</td>";
                        
                        // Add a form for the return button
                        echo "<td>
                               
                                     <a class='view-returnbtn' href='process-return.php?id=" . $id . "' title='Delete'><button class='view-returnbtn'><i class='fa-solid fa-reply'></i></button></a>


                                
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No books found for this student</td></tr>";
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

        $(document).ready(function() {
            $("a.view-returnbtn").click(function(e) {
                if (!confirm('Return this book?')) {
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });
    </script>
</body>
</html>