<?php
// connection.php

// Database connection settings
$host = 'localhost';  // Replace if necessary
$user = 'root';       // Your MySQL username
$password = '';       // Your MySQL password
$database = 'library';    // Your database name

// Create connection
$link = mysqli_connect($host, $user, $password, $database);

// Check if the connection was successful
if (!$link) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
