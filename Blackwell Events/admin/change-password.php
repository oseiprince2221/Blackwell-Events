<?php
session_start();
include("../database/config.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['admin'];
$msg = "";
$error = "";

if(isset($_POST['change'])){
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Verify current password
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$admin_username' AND password='$current_password'");
    
    if(mysqli_num_rows($result) == 0){
        $error = "Current password is incorrect";
    } else if($new_password !== $confirm_password){
        $error = "New passwords do not match";
    } else if(strlen($new_password) < 4){
        $error = "New password must be at least 4 characters long";
    } else {
        // Update password
        $update_query = "UPDATE admin SET password='$new_password' WHERE username='$admin_username'";
        if(mysqli_query($conn, $update_query)){
            $msg = "Password changed successfully!";
        } else {
            $error = "Error updating password: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Admin | Blackwell Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("admin-navbar.php"); ?>

<main class="page-shell">
    <section class="page-header">
        <p class="eyebrow">Account Settings</p>
        <h1 class="page-title">Change Password</h1>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <?php if (!empty($msg)): ?>
                    <p style="color: #a4f3a1; font-weight:700; margin-bottom: 18px;"><?php echo $msg; ?></p>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <p style="color: #f08f8f; font-weight:700; margin-bottom: 18px;"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" value="<?php echo htmlspecialchars($admin_username); ?>" disabled>
                        <small style="color: var(--muted);">Username cannot be changed</small>
                    </div>

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter your current password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>

                    <button type="submit" name="change">Change Password</button>
                    <a href="dashboard.php" class="btn btn-outline" style="margin-top: 10px;">Back to Dashboard</a>
                </form>
            </div>
        </div>
    </section>
</main>

</body>
</html>
