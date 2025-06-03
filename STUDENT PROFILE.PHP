<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "project");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];

    echo "<h2>Student Information Received:</h2>";
    echo "Name: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Phone: " . htmlspecialchars($phone) . "<br>";
    echo "Class: " . htmlspecialchars($class) . "<br>";

    // Insert into database
    $sql = "INSERT INTO students (name, email, phone, class) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $class);
        mysqli_stmt_execute($stmt);
        echo "<br>Data saved successfully to the database.";
        mysqli_stmt_close($stmt);
    } else {
        echo "<br>Error: " . mysqli_error($con);
    }
} else {
    echo "No data submitted.";
}

mysqli_close($con);
?>
