<?php
include("database/config.php");

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    mysqli_query($conn,
        "INSERT INTO messages(name,email,message)
         VALUES('$name','$email','$message')");

    $success = "Message sent successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Blackwell Events</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("assets/navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Talk to us</p>
        <h1 class="page-title">Contact the Blackwell Events Team</h1>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <?php if (isset($success)) { ?>
                    <p style="color: #a4f3a1; font-weight: 700; margin-bottom: 18px;"><?php echo $success; ?></p>
                <?php } ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Jane Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="jane@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" placeholder="How can we help you?" required></textarea>
                    </div>
                    <button type="submit" name="send">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>