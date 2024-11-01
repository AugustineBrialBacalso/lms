<?php
session_start();
include 'connection.php';

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "No ID provided.";
    exit();
}

$username = $_SESSION['username'];

// Debugging: Output the ID being used
echo "ID: " . htmlspecialchars($id) . "<br>";  // Ensure to escape output to prevent XSS

// Prepare and execute the query
$student_query = "SELECT * FROM borrowers WHERE id = ?";
$stmt = $link->prepare($student_query);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check the number of rows returned
echo "Rows found: " . $result->num_rows . "<br>";

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_name = $student['student_name'];
    $student_id = $student['student_id'];
    $book_title = $student['book_title'];

    // Insert into transaction_history
    $sql = "INSERT INTO transaction_history (std_name, title, transaction_type, processed_by) VALUES (?, ?, 'Returned', ?)";
    $insert_stmt = $link->prepare($sql);
    $insert_stmt->bind_param('sss', $student_name, $book_title, $username);

    if (!$insert_stmt->execute()) {
        echo "Error inserting transaction: " . $link->error;
        exit();
    }

    // Delete the borrower
    $query = "DELETE FROM borrowers WHERE id = ?";
    $delete_stmt = $link->prepare($query);
    $delete_stmt->bind_param('s', $id);
    
    if ($delete_stmt->execute()) {
        header("Location: borrow-book.php");
        exit();
    } else {
        echo "Error deleting borrower: " . $link->error;
        exit();
    }
} else {
    echo "Transaction not found";
    exit();
}
?>
