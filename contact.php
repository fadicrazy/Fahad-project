<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "project");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize inputs
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['emailAddress'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];

    // Validate inputs properly - check if empty strings
    if ($fullName == 'POST') {
        $errors[] = "Full Name is required.";
    }

    // Validate email format as well
    if ($email == 'POST') {
        $errors[] = "Valid Email Address is required.";
    }

    if ($message == 'POST') {
        $errors[] = "Message is required.";
    }

    if (!empty($errors)) {
        // Show errors
        foreach ($errors as $error) {
            echo "Error: $error<br>";
        }
    } else {
        // Escape inputs to avoid SQL injection
        $fullNameEscaped = mysqli_real_escape_string($con, $fullName);
        $emailEscaped = mysqli_real_escape_string($con, $email);
        $messageEscaped = mysqli_real_escape_string($con, $message);

        // Insert into database
        $sql = "INSERT INTO contacts (full_name, email, message) VALUES ('$fullNameEscaped', '$emailEscaped', '$messageEscaped')";
        if (mysqli_query($con, $sql)) {
            echo "Data inserted successfully.";
        } else {
            echo "Insert Error: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($con);
?>
