<?php
session_start();
include("../database/config.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// stats
$eventsCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM events")
);

$usersCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM registrations")
);

// events list
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");

// registration totals per event
$registrationCounts = [];
$registrationQuery = mysqli_query($conn, "SELECT event_id, COUNT(*) AS total FROM registrations GROUP BY event_id");
if ($registrationQuery) {
    while ($countRow = mysqli_fetch_assoc($registrationQuery)) {
        $registrationCounts[$countRow['event_id']] = $countRow['total'];
    }
}

// messages (optional)
$messages = mysqli_query($conn, "SELECT * FROM messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Blackwell Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("admin-navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Admin Dashboard</p>
        <h1 class="page-title">Manage Events & Registrations</h1>
    </section>

    <section class="upcoming">
        <div class="hero-actions" style="justify-content: center; gap: 18px; margin-bottom: 40px;">
            <a href="add-event.php" class="btn">+ Add New Event</a>
            <a href="registrations.php" class="btn">View Registrations</a>
            <a href="messages.php" class="btn btn-outline">View Messages</a>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>Total Events</h2>
                    <p><?php echo $eventsCount['total']; ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Registrations</h2>
                    <p><?php echo $usersCount['total']; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="details-section">
        <div class="section-intro">
            <p>Events management</p>
            <h2>All Published Events</h2>
        </div>

        <div class="container">
            <?php while ($row = mysqli_fetch_assoc($events)) { ?>
                <article class="card">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($row['venue']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                        <div class="hero-actions" style="flex-wrap: wrap; justify-content: flex-start; gap: 10px; margin-top: 18px;">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                            <a href="delete-event.php?id=<?php echo $row['id']; ?>" class="btn btn-outline" onclick="return confirm('Delete this event?');">Delete</a>
                            <a href="registrations.php?event_id=<?php echo $row['id']; ?>" class="btn btn-outline">View Registrations (<?php echo isset($registrationCounts[$row['id']]) ? $registrationCounts[$row['id']] : 0; ?>)</a>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </div>
    </section>

    <section class="details-section">
        <div class="section-intro">
            <p>Latest events</p>
            <h2>Recent Events</h2>
        </div>

        <div class="container">
            <?php
            $incoming = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC LIMIT 6");
            while ($row = mysqli_fetch_assoc($incoming)) {
            ?>
                <article class="card">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($row['event_date']); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($row['venue']); ?></p>
                    </div>
                </article>
            <?php } ?>
        </div>
    </section>

    <section class="details-section">
        <div class="section-intro">
            <p>Community feedback</p>
            <h2>Incoming Messages</h2>
        </div>

        <div class="container">
            <?php if ($messages) {
                while ($msg = mysqli_fetch_assoc($messages)) { ?>
                    <article class="card">
                        <div class="card-body">
                            <h3><?php echo htmlspecialchars($msg['name']); ?></h3>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        </div>
                    </article>
                <?php }
            } ?>
        </div>
    </section>
</main>

</body>
</html>