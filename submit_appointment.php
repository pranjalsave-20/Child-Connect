<?php
include 'db_connect.php'; // Ensure this file is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guardian_name = $_POST['gname'];
    $guardian_email = $_POST['gmail'];
    $child_name = $_POST['cname'];
    $child_age = $_POST['cage'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $message = $_POST['message'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO appointments 
        (guardian_name, guardian_email, child_name, child_age, phone, address, message) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error in SQL: " . $conn->error); // Show error if query preparation fails
    }

    $stmt->bind_param("sssssss", $guardian_name, $guardian_email, $child_name, $child_age, $phone, $address, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Execution error: " . $stmt->error; // Show execution errors
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>