<?php
include("../database/config.php");

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id=$id"));

if(isset($_POST['update'])){

$title = $_POST['title'];
$organizer = $_POST['organizer'];
$venue = $_POST['venue'];
$image_description = mysqli_real_escape_string($conn, $_POST['image_description']);

mysqli_query($conn, "UPDATE events SET 
title='$title',
organizer='$organizer',
venue='$venue',
image_description='$image_description'
WHERE id=$id");

header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>

<body>

<h2>Edit Event</h2>

<form method="POST">

<input type="text" name="title" value="<?php echo $data['title']; ?>"><br><br>

<input type="text" name="organizer" value="<?php echo $data['organizer']; ?>"><br><br>

<input type="text" name="venue" value="<?php echo $data['venue']; ?>"><br><br>

<label for="image_description">Image Description</label><br>
<textarea name="image_description" rows="4" cols="50"><?php echo isset($data['image_description']) ? $data['image_description'] : ''; ?></textarea><br><br>

<button name="update">Update</button>

</form>

</body>
</html>