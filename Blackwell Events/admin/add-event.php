<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../database/config.php");

if(isset($_POST['submit'])){

    // SAFE INPUTS (FIXED SQL ISSUE)
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $flyer = "";
    $image_description = mysqli_real_escape_string($conn, $_POST['image_description']);

    // IMAGE UPLOAD (SAFE + NO OVERWRITE)
    if(!empty($_FILES['flyer']['name'])) {

        $ext = pathinfo($_FILES['flyer']['name'], PATHINFO_EXTENSION);
        $flyer = time() . "_" . rand(1000,9999) . "." . $ext;

        $tmp = $_FILES['flyer']['tmp_name'];

        move_uploaded_file($tmp, "../assets/uploads/" . $flyer);
    }

    // INSERT INTO DATABASE
    $sql = "INSERT INTO events 
    (title, organizer, category, event_date, event_time, venue, description, flyer, image_description)
    VALUES 
    ('$title','$organizer','$category','$event_date','$event_time','$venue','$description','$flyer','$image_description')";

    if(mysqli_query($conn, $sql)){
        $msg = "Event Added Successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event | Admin | Blackwell Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        #preview {
            width: 100%;
            max-width: 380px;
            display: none;
            border-radius: 18px;
            margin-top: 14px;
            box-shadow: 0 18px 36px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<?php include("admin-navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Create event</p>
        <h1 class="page-title">Add New Event</h1>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <?php if (isset($msg)): ?>
                    <p style="color: #a4f3a1; font-weight:700; margin-bottom: 18px;"><?php echo $msg; ?></p>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Event Title</label>
                        <input type="text" id="title" name="title" placeholder="Event Title" required>
                    </div>
                    <div class="form-group">
                        <label for="organizer">Organizer</label>
                        <input type="text" id="organizer" name="organizer" placeholder="Organizer" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" placeholder="Category">
                    </div>
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" id="event_date" name="event_date">
                    </div>
                    <div class="form-group">
                        <label for="event_time">Event Time</label>
                        <input type="time" id="event_time" name="event_time">
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <input type="text" id="venue" name="venue" placeholder="Venue">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="flyerInput">Event Flyer</label>
                        <input type="file" id="flyerInput" name="flyer" accept="image/*" onchange="previewImage(event)">
                        <img id="preview" alt="Flyer preview">
                    </div>
                    <div class="form-group">
                        <label for="image_description">Image Description</label>
                        <textarea id="image_description" name="image_description" placeholder="Describe the image/flyer" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit">Post Event</button>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById("preview");

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>