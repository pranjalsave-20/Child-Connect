<?php
// Include the database connection
require_once 'db_connect.php';

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect form inputs
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL Insert query
    $sql = "INSERT INTO contacts (name, email, phone, subject, message)
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    // Attempt to execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='contact.html';</script>";
    }

    // Close the connection
    mysqli_close($conn);

// If not a POST request, show connection test result
} else {
    if ($conn) {
        echo "Database connection is working.<br>";
    } else {
        echo "❌ Database connection failed: " . mysqli_connect_error();
    }
}
?>
