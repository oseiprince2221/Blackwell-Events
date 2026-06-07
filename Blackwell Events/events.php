<?php
include("database/config.php");

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Blackwell Events</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("assets/navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Live events</p>
        <h1 class="page-title">Upcoming Events</h1>
    </section>

    <section class="upcoming">
        <div class="container">
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <article class="card event-card">
                        <?php if (!empty($row['flyer'])) { ?>
                            <img src="assets/uploads/<?php echo $row['flyer']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <?php } else { ?>
                            <img src="assets/images/default.jpg" alt="Event image">
                        <?php } ?>

                        <div class="card-body">
                            <span class="badge"><?php echo htmlspecialchars($row['category']); ?></span>
                            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                            <div class="event-meta">
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                                <p><strong>Time:</strong> <?php echo htmlspecialchars($row['event_time']); ?></p>
                                <p><strong>Venue:</strong> <?php echo htmlspecialchars($row['venue']); ?></p>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <div class="hero-actions">
                                <a href="register.php?event_id=<?php echo $row['id']; ?>" class="btn">Register</a>
                                <a href="view-event.php?id=<?php echo $row['id']; ?>" class="btn btn-outline">View Details</a>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            <?php } else { ?>
                <div class="empty-state">No events are available yet. Check back soon for new events.</div>
            <?php } ?>
        </div>
    </section>
</main>

</body>
</html>