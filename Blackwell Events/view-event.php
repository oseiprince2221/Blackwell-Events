<?php
include("database/config.php");

if (!isset($_GET['id'])) {
    die("Missing event ID");
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE id='$id'");

if (!$result || mysqli_num_rows($result) == 0) {
    die("Event not found");
}

$event = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> | Blackwell Events</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("assets/navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Event details</p>
        <h1 class="page-title"><?php echo htmlspecialchars($event['title']); ?></h1>
    </section>

    <section class="details-section">
        <div class="container">
            <article class="detail-panel">
                <?php if (!empty($event['flyer'])) { ?>
                    <img src="assets/uploads/<?php echo $event['flyer']; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                    <?php if (!empty($event['image_description'])) { ?>
                        <p class="image-description"><em><?php echo htmlspecialchars($event['image_description']); ?></em></p>
                    <?php } ?>
                <?php } ?>

                <div class="card-body">
                    <span class="badge"><?php echo htmlspecialchars($event['category']); ?></span>
                    <div class="event-meta">
                        <p><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($event['event_time']); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                    </div>
                    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    <a href="register.php?event_id=<?php echo $event['id']; ?>" class="btn">Register for this event</a>
                </div>
            </article>
        </div>
    </section>
</main>

</body>
</html>