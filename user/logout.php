<?php
include '..\includes/header.php';
session_start();
session_destroy();
session_reset();
header("Location: " . APP_URL . "index.php");

exit();
?>