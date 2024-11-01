<?php
include 'connection.php';

$id = $_GET['id'];

$query = "DELETE from books where id = '$id'";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($link));
}
header("Location: list-of-books.php");
