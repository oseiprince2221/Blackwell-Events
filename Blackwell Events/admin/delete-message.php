<?php
session_start();
include("../database/config.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM messages WHERE id=$id");

header("Location: dashboard.php");
exit();
?>