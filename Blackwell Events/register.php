<?php
include("database/config.php");

$event_id = "";
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
}

if (isset($_POST['submit'])) {
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "INSERT INTO registrations(event_id, fullname, phone, email)
            VALUES('$event_id','$name','$phone','$email')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Registration Successful!";
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
    <title>Register | Blackwell Events</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("assets/navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Register</p>
        <h1 class="page-title">Secure Your Event Spot</h1>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <?php if (isset($msg)) { ?>
                    <p style="color: #a4f3a1; font-weight: 700; margin-bottom: 18px;"><?php echo $msg; ?></p>
                <?php } ?>

                <form method="POST">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com">
                    </div>
                    <button type="submit" name="submit">Register Now</button>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>