<?php
session_start();
include 'db_connect.php'; // same file you use in register.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        die("Error: All fields are required!");
    }

    // Hash password using MD5 to match registration
    $hashed_password = md5($password);

    // Prepare SQL query
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Login successful
        $user = $result->fetch_assoc();
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: dash.php");
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid email or password. Please try again.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
