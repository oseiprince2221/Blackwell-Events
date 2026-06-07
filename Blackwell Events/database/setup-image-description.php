<?php
/**
 * Setup Helper - Add Image Description Column
 * 
 * This script adds the image_description column to the events table if it doesn't exist.
 * Run this once to initialize the feature.
 */

include("config.php");

// Check if the column already exists
$result = mysqli_query($conn, "SHOW COLUMNS FROM events LIKE 'image_description'");

if (mysqli_num_rows($result) == 0) {
    // Column doesn't exist, so add it
    $sql = "ALTER TABLE events ADD COLUMN image_description LONGTEXT";
    
    if (mysqli_query($conn, $sql)) {
        echo "✓ Successfully added 'image_description' column to events table!";
    } else {
        echo "✗ Error adding column: " . mysqli_error($conn);
    }
} else {
    echo "✓ Column 'image_description' already exists in the events table!";
}

mysqli_close($conn);
?>
