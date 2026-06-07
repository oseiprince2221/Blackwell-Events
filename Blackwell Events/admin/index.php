<?php
// Redirect to login if not authenticated, otherwise redirect to dashboard
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
