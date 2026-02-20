<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guardian_name = $_POST['gname'];
    $guardian_email = $_POST['gmail'];
    $preferred_child_name = $_POST['cname'] ;
    $preferred_child_age = $_POST['cage'];
    $reason = $_POST['reason'];
    $additional_message = $_POST['message'] ;
    $agreement = isset($_POST['agree']) ? 1 : 0;

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO adoption_inquiries 
        (guardian_name, guardian_email, preferred_child_name, preferred_child_age, reason, additional_message, agreement) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssi", $guardian_name, $guardian_email, $preferred_child_name, $preferred_child_age, $reason, $additional_message, $agreement);

    if ($stmt->execute()) {
        echo "<script>alert('Inquiry submitted successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>