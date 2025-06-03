<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "project");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $exam_date = $_POST['exam_date'];

    echo "<h2>Performance Data Received</h2>";
    echo "Student ID: " . htmlspecialchars($student_id) . "<br>";
    echo "Subject: " . htmlspecialchars($subject) . "<br>";
    echo "Marks: " . htmlspecialchars($marks) . "<br>";
    echo "Exam Date: " . htmlspecialchars($exam_date) . "<br>";

    // Insert data into the database
    $sql = "INSERT INTO student_performance (student_id, subject, marks, exam_date)
            VALUES ('$student_id', '$subject', '$marks', '$exam_date')";

    if (mysqli_query($con, $sql)) {
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: " . mysqli_error($con);
    }
} else {
    echo "No data submitted.";
}
?>
