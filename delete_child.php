<?php
include 'db.php';
$id = $_POST['id'];
mysqli_query($conn, "DELETE FROM appointments WHERE id = $id");
header("Location: dash.php");
?>
