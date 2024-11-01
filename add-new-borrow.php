<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
} 

$username = $_SESSION['username'];

require_once 'connection.php'; // Include your database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $book_titles = $_POST['book_titles']; // This will be an array of book titles

    // Validate inputs
    if (!empty($student_id) && !empty($student_name) && !empty($book_titles)) {
        // Prepare an SQL query to insert borrower details into the database
        $borrowed_date = date("Y-m-d"); 
        $due_date = (date ('Y-m-j' , strtotime ( '3 weekdays' ) )); // 3 days from now

        // Loop through each book title and insert into the database
        foreach ($book_titles as $book_title) {
            if (!empty($book_title)) {
                $sql = "INSERT INTO borrowers (student_id, student_name, book_title, due_date) VALUES (?, ?, ?, ?)";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("ssss", $student_id, $student_name, $book_title, $due_date);

                if ($stmt->execute()) {
                    // You can handle individual success messages or just one for all
                } else {
                    echo "<script>alert('Error adding borrower: " . $link->error . "');</script>";
                }
                $stmt->close(); 
            }
            
        }
        // Redirect to the list of books page after successful insertion
        
       
    } else {
        echo "<script>alert('Please fill in all fields!');</script>";
    }

    $sql = "INSERT INTO transaction_history (std_name, title, transaction_type, processed_by) VALUES ('$student_name', '$book_title', 'Borrow', '$username')";

    if (mysqli_query($link, $sql)) {
        header("Location: borrow-book.php");
        exit();
            
        echo "<script>alert('Borrower(s) added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
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

<div id="uppernav" class="uppernav">
    <div class="upnav">
        <button class="openbtn" onclick="toggleNav()">☰</button>
    </div>

    <div class="addnew-container">
        <form class="addnew-con" method="POST" action="">
            <div class="addnew-name">
                <h4>Add New Borrower</h4>
            </div>
            
            <div class="add" onclick="addBookInput()" title="Add Another Book">
                <i class="fa-solid fa-plus"></i> Add Book
            </div>

            <input class="borrow-input" type="text" name="student_id" placeholder="Student Id" required></input>
            <input class="borrow-input" type="text" name="student_name" placeholder="Student Name" required></input>
            <div id="book-title-inputs">
                <div class="book-input-container">
                    <input class="borrow-input" type="text" name="book_titles[]" placeholder="Book Title" required></input>
                    <div class="x-icon" style="display: none;" onclick="removeBookInput(this)" title="Remove">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
            </div>
            <input class="reset-borrow" type="reset"></input>
            <button class="sub-borrow" type="submit">Submit</button>
            <a class="add-borrow-cancel" href="borrow-book.php">Cancel</a>
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

    function addBookInput() {
        const bookTitleInputs = document.getElementById('book-title-inputs');
        const newInputContainer = document.createElement('div');
        newInputContainer.className = 'book-input-container';
        
        const newInput = document.createElement('input');
        newInput.className = "borrow-input";
        newInput.type = "text";
        newInput.name = "book_titles[]"; // Use an array to store multiple book titles
        newInput.placeholder = "Book Title";
        newInput.required = true;

        const removeIcon = document.createElement('div');
        removeIcon.className = "x-icon";
        removeIcon.onclick = function() {
            removeBookInput(this);
        };
        removeIcon.title = "Remove";
        removeIcon.innerHTML = '<i class="fa-solid fa-xmark"></i>'; // Minus icon
        
        newInputContainer.appendChild(newInput);
        newInputContainer.appendChild(removeIcon);
        bookTitleInputs.appendChild(newInputContainer);
    }

    function removeBookInput(button) {
        const bookTitleInputs = document.getElementById('book-title-inputs');
        const inputContainers = bookTitleInputs.getElementsByClassName('book-input-container');
        
        // Check if there is more than one input before allowing removal
        if (inputContainers.length > 1) {
            button.parentElement.remove(); // Remove the input container
        } 
    }
</script>

</body>
</html>
