<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['submit'])) {
    // Capture the form data
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $quantity = $_POST['quantity'];
    $date_published = $_POST['date_published'];
    $category = $_POST['category'];

    if ($category=="BLIS"){
        $shelf_no = "Book Shelve 1"; 
    }
    elseif ($category=="BSCPE"){
        $shelf_no = "Book Shelve 2"; 
    }
    elseif ($category=="BSP"){
        $shelf_no = "Book Shelve 3"; 
    }
    elseif ($category=="BSIT"){
        $shelf_no = "Book Shelve 4"; 
    }
    elseif ($category=="BSED"){
        $shelf_no = "Book Shelve 5"; 
    }
    elseif ($category=="BSCRIM"){
        $shelf_no = "Book Shelve 6"; 
    }
    elseif ($category=="BSAIS"){
        $shelf_no = "Book Shelve 7"; 
    }
    elseif ($category=="BSENTREP"){
        $shelf_no = "Book Shelve 8"; 
    }
    elseif ($category=="BSBA"){
        $shelf_no = "Book Shelve 9"; 
    }
    elseif ($category=="BSOA"){
        $shelf_no = "Book Shelve 10"; 
    }
    elseif ($category=="BSTM"){
        $shelf_no = "Book Shelve 11"; 
    }
    elseif ($category=="BSHM"){
        $shelf_no = "Book Shelve 12"; 
    }

    // Prepare an SQL insert statement
    $sql = "INSERT INTO books (title, isbn, author, publisher, quantity, date_published, category, shelf_no) 
                VALUES ('$title', '$isbn', '$author', '$publisher', '$quantity', '$date_published', '$category', '$shelf_no')";

    // Execute the query and check if the book was successfully added
    if (mysqli_query($link, $sql)) {
        $_SESSION['success_message'] = 'Book added successfully';
        header("Location: list-of-books.php"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['error_message'] = 'Error Adding Book!' . mysqli_error($link);
        header("Location: add-books.php"); // Redirect to the same page
        exit();
    }

    // Close the database connection
    mysqli_close($link);
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

    <?php
    // Check for success message
    if (isset($_SESSION['success_message'])) {
        echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
        unset($_SESSION['success_message']);
    }

    // Check for error message
    if (isset($_SESSION['error_message'])) {
        echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
        unset($_SESSION['error_message']);
    }
    ?>

    <div id="sidenav" class="sidenav">
        <?php
        include('side_nav.php');
        ?>
    </div>

    <div id="uppernav" class="uppernav">
        <div class="upnav">
            <button class="openbtn" onclick="toggleNav()">☰</button>
        </div>

        <div class="book-container">
            <form class="addbook" method="POST" action="add-books.php">
                <div class="addname">
                    <h4>Add Book</h4>
                </div>
                <input class="title" name="title" type="text" placeholder="Title" required>
                <input class="title" name="isbn" type="text" placeholder="ISBN" required>
                <input class="title" name="author" type="text" placeholder="Author" required>
                <input class="title" name="publisher" type="text" placeholder="Publisher" required>
                
                <select class="categories" name="category" required>
                    <?php
                    $sql = "SELECT * FROM course WHERE status = 'Active' ORDER BY course_description";
                    $result = mysqli_query($link, $sql);

                    if ($result->num_rows > 0) {
                    ?>
                        <option value="" disable selected hidden>Select Categories</option>
                        <?php

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['course_code']; ?>"><?php echo $row['course_description']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>

                <input class="date" name="date_published" type="text" placeholder="Date Published" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                <input class="qty" name="quantity" type="number" min="0" placeholder="Quantity" required>
                <input class="removed" type="reset">
                <button class="sub-btn" type="submit" name="submit">Submit</button>
                <a class="add-cancel" href="list-of-books.php">Cancel</a>
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