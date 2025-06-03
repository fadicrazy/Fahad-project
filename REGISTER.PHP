<?php
session_start();

// Connect to MySQL database
$con = mysqli_connect("localhost", "root", "", "project");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Retrieve form inputs safely and trim whitespace
    $name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate all fields filled
    if ($name && $email && $password && $confirm_password) {

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color: red;'>Invalid email format.</p>";
        }
        // Check passwords match
        elseif ($password !== $confirm_password) {
            echo "<p style='color: red;'>Passwords do not match.</p>";
        }
        else {
            // Escape inputs to prevent SQL injection
            $nameEscaped = mysqli_real_escape_string($con, $name);
            $emailEscaped = mysqli_real_escape_string($con, $email);

            // Check if email already exists (optional but recommended)
            $checkEmail = "SELECT id FROM users WHERE email = '$emailEscaped' LIMIT 1";
            $result = mysqli_query($con, $checkEmail);

            if (mysqli_num_rows($result) > 0) {
                echo "<p style='color: red;'>Email already registered. Please use another email.</p>";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database
                $query = "INSERT INTO users (full_name, email, password) VALUES ('$nameEscaped', '$emailEscaped', '$hashedPassword')";

                if (mysqli_query($con, $query)) {
                    echo "<p style='color: green;'>Registration successful! Welcome, <strong>$name</strong>.</p>";
                } else {
                    echo "<p style='color: red;'>Error: Could not register user. Please try again later.</p>";
                }
            }
        }
    } else {
        echo "<p style='color: red;'>Please fill all the fields.</p>";
    }
}

// Close connection
mysqli_close($con);
?>
