<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form inputs
$title = $_POST['title'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];

// Prepare and execute the SQL statement safely
$sql = "INSERT INTO assignments (title, description, due_date) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sss", $title, $description, $due_date);
    mysqli_stmt_execute($stmt);
    echo "Assignment created!";
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
