<?php
session_start();
include("../database/config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$eventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$event = null;
$registrations = [];

if ($eventId > 0) {
    $eventResult = mysqli_query($conn, "SELECT * FROM events WHERE id = $eventId");
    if ($eventResult && mysqli_num_rows($eventResult) > 0) {
        $event = mysqli_fetch_assoc($eventResult);
    }
    $registrationQuery = mysqli_query($conn, "SELECT * FROM registrations WHERE event_id = $eventId ORDER BY id DESC");
} else {
    $registrationQuery = mysqli_query($conn, "SELECT r.*, e.title AS event_title FROM registrations r LEFT JOIN events e ON r.event_id = e.id ORDER BY r.id DESC");
}

if ($registrationQuery) {
    while ($row = mysqli_fetch_assoc($registrationQuery)) {
        $registrations[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrations | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("admin-navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Registration records</p>
        <h1 class="page-title"><?php echo $event ? 'Registrations for: ' . htmlspecialchars($event['title']) : 'All Event Registrations'; ?></h1>
    </section>

    <section class="upcoming">
        <div class="hero-actions" style="justify-content: center; gap: 18px; margin-bottom: 40px;">
            <a href="dashboard.php" class="btn btn-outline">Back to Dashboard</a>
            <?php if ($event) { ?>
                <a href="registrations.php" class="btn">View All Registrations</a>
            <?php } ?>
        </div>

        <div class="container">
            <?php if (count($registrations) > 0) { ?>
                <?php foreach ($registrations as $registration) { ?>
                    <article class="card">
                        <div class="card-body">
                            <h2><?php echo htmlspecialchars($registration['fullname']); ?></h2>
                            <?php if ($event) { ?>
                                <p><strong>Event Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                            <?php } else { ?>
                                <p><strong>Event:</strong> <?php echo htmlspecialchars($registration['event_title'] ?: 'Unknown event'); ?></p>
                            <?php } ?>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($registration['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($registration['phone']); ?></p>
                            <?php if (!empty($registration['created_at'])) { ?>
                                <p><strong>Registered:</strong> <?php echo date('F j, Y', strtotime($registration['created_at'])); ?></p>
                            <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            <?php } else { ?>
                <div class="empty-state">No registrations found for this event yet.</div>
            <?php } ?>
        </div>
    </section>
</main>

</body>
</html>