<?php
$servername = "localhost";
$username = "root"; // Change this if using a different database user
$password = ""; // Add your password if required
$dbname = "kidweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo " connected ";
?>