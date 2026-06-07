<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../database/config.php");
$result = mysqli_query($conn, "SELECT * FROM messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Admin | Blackwell Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("admin-navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Messages</p>
        <h1 class="page-title">Incoming Visitor Messages</h1>
    </section>

    <section class="details-section">
        <div class="container">
            <?php if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <article class="card">
                        <div class="card-body">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                            <a href="delete-message.php?id=<?php echo $row['id']; ?>" class="btn btn-outline" onclick="return confirm('Remove this message?');">Delete</a>
                        </div>
                    </article>
                <?php }
            } else { ?>
                <div class="empty-state">No messages have been received yet.</div>
            <?php } ?>
        </div>
    </section>
</main>

</body>
</html>