<?php
session_start();
session_unset();
session_destroy();

// Redirect with logout flag
header("Location: register.html?logout=1");
exit();
?>
