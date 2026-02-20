<?php 
include 'db_connect.php';
session_start(); // Ensure session is started early

//  Proper session status check
if (isset($_SESSION) && session_id() !== '') {
    echo "<p style='color: green; font-weight: bold;'>✅ Session is running!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ No active session.</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Error: All fields are required!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format!");
    }

    if ($password !== $confirm_password) {
        die("Error: Passwords do not match!");
    }

    // Hash the password (less secure MD5 version as requested)
    $hashed_password = md5($password);

    // Prepare SQL statement
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('sss', $name, $email, $hashed_password);

    // Execute and check success
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name; // Store username in session
        header("Location: welcome.php"); // Redirect to welcome page
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
