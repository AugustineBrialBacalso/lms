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

if (isset($_POST['submit'])) {
    // Capture the form data
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $date_published = $_POST['date_published'];

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

    $sql = "UPDATE books SET title = '$title', isbn='$isbn', author='$author', publisher='$publisher', category='$category', quantity='$quantity', date_published='$date_published', shelf_no='$shelf_no' WHERE id ='$book_id'";

    // Execute the query and check if the book was successfully added
    if (mysqli_query($link, $sql)) {
        $_SESSION['success_message'] = 'Book updated successfully';
        header("Location: list-of-books.php"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['error_message'] = 'Error Adding Book!' . mysqli_error($link);
        header("Location: add-books.php"); // Redirect to the same page
        exit();
    }
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
    $_SESSION['error'] = "Book not found";
    header("location: view-list-books.php");
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

        <div class="update-container">
            <form class="updatebook" method="post">
                <div class="updatename">
                    <h4>Update Details</h4>
                </div>

                <!-- Populate the input fields with the retrieved data from the database -->
                <label class="view-label">Title:</label>
                <input class="update-input" type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($book['title']); ?>" title="Title" required></input>

                <label class="view-label">ISBN:</label>
                <input class="update-input" type="text" name="isbn" placeholder="ISBN" value="<?php echo htmlspecialchars($book['isbn']); ?>" title="ISBN" required></input>

                <label class="view-label">Author:</label>
                <input class="update-input" type="text" name="author" placeholder="Author" value="<?php echo htmlspecialchars($book['author']); ?>" title="Author" required></input>

                <label class="view-label">Publisher:</label>
                <input class="update-input" type="text" name="publisher" placeholder="Publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" title="Publisher" required></input>

                <label class="view-label">Category:</label>
                <select class="update-categories" name="category" required>
                    <?php
                    $course_code = htmlspecialchars($book['category']);
                    $sql = "SELECT * FROM course WHERE course_code = '$course_code'";
                    $result = mysqli_query($link, $sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <option disable selected hidden value="<?php echo $row['course_code']; ?>"><?php echo $row['course_description']; ?></option>
                        <?php
                        }
                    }
                    $sql = "SELECT * FROM course WHERE status = 'Active' ORDER BY course_description";
                    $result = mysqli_query($link, $sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['course_code']; ?>"><?php echo $row['course_description']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                    
                <label class="update-label-qty">Quantity:</label>
                <input class="update-qty" type="number" name="quantity" min="0" placeholder="Quantity" value="<?php echo htmlspecialchars($book['quantity']); ?>" title="Quantity" required></input>

                <label class="update-label-date">Date Published:</label>
                <input class="update-date" type="text" name="date_published" placeholder="Date Published" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo htmlspecialchars($book['date_published']); ?>" title="Date Published" required></input>

                <input class="update-removed" type="reset"></input>
                <button class="update-sub-btn" type="submit" name="submit">Submit</button>
                <a class="update-cancel" href="list-of-books.php">Cancel</a>
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