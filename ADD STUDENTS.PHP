<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "project");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully<br>";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive form data
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $class = mysqli_real_escape_string($con, $_POST['class']);

    // Insert into the 'all_students' table
    $sql = "INSERT INTO all_students (student_name, student_id, age, class) 
            VALUES ('$student_name', '$student_id', '$age', '$class')";

    if (mysqli_query($con, $sql)) {
        echo "<h2>Student Added Successfully</h2>";
        echo "Name: " . htmlspecialchars($student_name) . "<br>";
        echo "Student ID: " . htmlspecialchars($student_id) . "<br>";
        echo "Age: " . htmlspecialchars($age) . "<br>";
        echo "Class: " . htmlspecialchars($class) . "<br>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "No data submitted.";
}

// Close connection
mysqli_close($con);
?>
