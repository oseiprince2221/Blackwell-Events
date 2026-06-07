<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "christmas_db"
);

if (!$conn) {
    die("Database connection failed");
}
?>