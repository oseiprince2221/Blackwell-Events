<?php
session_start();
include("../database/config.php");

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn,
        "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Wrong login details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Blackwell Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<main class="page-shell">
    <section class="form-section">
        <div class="page-header">
            <p class="eyebrow">Admin portal</p>
            <h1 class="page-title">Secure Login</h1>
        </div>

        <div class="container">
            <div class="form-card">
                <?php if (isset($error)): ?>
                    <p style="color:#f08f8f; font-weight: 700; margin-bottom: 18px;"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="admin" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="login">Sign In</button>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>