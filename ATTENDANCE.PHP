<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "project");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['subject']) && isset($_POST['marks']) && isset($_POST['exam_date'])) {
        // Performance form submission
        $student_id = $_POST['student_id'];
        $subject = $_POST['subject'];
        $marks = $_POST['marks'];
        $exam_date = $_POST['exam_date'];

        echo "<h2>Performance Data Received</h2>";
        echo "Student ID: " . htmlspecialchars($student_id) . "<br>";
        echo "Subject: " . htmlspecialchars($subject) . "<br>";
        echo "Marks: " . htmlspecialchars($marks) . "<br>";
        echo "Exam Date: " . htmlspecialchars($exam_date) . "<br>";

        $sql = "INSERT INTO student_performance (student_id, subject, marks, exam_date)
                VALUES ('$student_id', '$subject', '$marks', '$exam_date')";

        if (mysqli_query($con, $sql)) {
            echo "Performance record inserted successfully.<br>";
        } else {
            echo "Error inserting performance record: " . mysqli_error($con);
        }
    } elseif (isset($_POST['status'])) {
        // Attendance form submission
        $student_id = $_POST['student_id'];
        $status = $_POST['status'];

        echo "<h2>Attendance Marked</h2>";
        echo "Student ID: " . htmlspecialchars($student_id) . "<br>";
        echo "Status: " . htmlspecialchars($status) . "<br>";

        $sql = "INSERT INTO student_attendance (student_id, status, date_marked)
                VALUES ('$student_id', '$status', NOW())";

        if (mysqli_query($con, $sql)) {
            echo "Attendance record inserted successfully.<br>";
        } else {
            echo "Error inserting attendance record: " . mysqli_error($con);
        }
    } else {
        echo "No valid form data submitted.";
    }
} else {
    echo "No data submitted.";
}
?>
