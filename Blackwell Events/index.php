<?php
include("database/config.php");

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC LIMIT 3");
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackwell Events</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("assets/navbar.php"); ?>

<header class="hero">
    <div class="hero-inner">
        <p class="eyebrow">Upcoming Events</p>
        <h1>Discover powerful events that bring your community together.</h1>
        <p>Explore inspiring concerts, summits, festivals, outreach initiatives, and celebrations happening soon in your area.</p>

        <div class="hero-actions">
            <a href="events.php" class="btn">Explore Events</a>
            <a href="contact.php" class="btn btn-outline">Get in Touch</a>
        </div>

        <div class="countdown" id="countdown">Find your next unforgettable event.</div>
    </div>
</header>

<section class="programs page-shell">
    <div class="section-intro">
        <p>Curated event experiences</p>
        <h2>Featured Events</h2>
    </div>

    <div class="program-grid">
        <div class="program-card">
            <img src="assets/images/event1.jpeg" alt="Revival event">
            <div class="card-body">
                <span class="badge">Revival</span>
                <h3>AMGBLACK Revival</h3>
                <p>A moving night of worship, prayer and renewal for all families.</p>
            </div>
        </div>

        <div class="program-card">
            <img src="assets/images/event2.jpeg" alt="Carol Night">
            <div class="card-body">
                <span class="badge">Carols</span>
                <h3>Black Church Carol Night</h3>
                <p>Experience traditional and contemporary carols in a joyful celebration.</p>
            </div>
        </div>

        <div class="program-card">
            <img src="assets/images/event3.jpeg" alt="Gospel Concert">
            <div class="card-body">
                <span class="badge">Concert</span>
                <h3>Gospel Concert</h3>
                <p>Lift your voice with inspiring gospel music and powerful praise.</p>
            </div>
        </div>

        <div class="program-card">
            <img src="assets/images/event4.jpeg" alt="Youth Festival">
            <div class="card-body">
                <span class="badge">Youth</span>
                <h3>Youth Festival</h3>
                <p>A vibrant night of worship, games and fresh inspiration.</p>
            </div>
        </div>
    </div>
</section>

<section class="upcoming page-shell">
    <div class="section-intro">
        <p>Happening soon</p>
        <h2>Upcoming Events</h2>
    </div>

    <div class="container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card">
                <?php if (!empty($row['flyer'])) { ?>
                    <img src="assets/uploads/<?php echo $row['flyer']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                <?php } else { ?>
                    <img src="assets/images/event1.jpeg" alt="Event image">
                <?php } ?>

                <div class="card-body">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><strong>Organizer:</strong> <?php echo htmlspecialchars($row['organizer']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($row['venue']); ?></p>
                    <a href="view-event.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<footer class="footer page-shell">
    <p>© <?php echo date('Y'); ?> Blackwell Events — Mr Black</p>
</footer>

<script>
const countdownElement = document.getElementById("countdown");
countdownElement.textContent = "Check back soon for the next featured event on Blackwell Events.";
</script>

</body>
</html>