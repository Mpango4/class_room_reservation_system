<?php
// Include the necessary files and start the session

include("db_connection.php");


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $re_new_password = $_POST['re_new_password'];

    // Fetch the user's current password from the database
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Check if the current password matches
    if (password_verify($current_password, $hashed_password)) {
        // Check if the new passwords match
        if ($new_password === $re_new_password) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);

            if ($update_stmt->execute()) {
                $message = "<div class='alert alert-success'>Password changed successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error updating password: " . $conn->error . "</div>";
            }

            $update_stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>New passwords do not match.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Current password is incorrect.</div>";
    }
}
?>
  
                   
                    <form method="post" action="profile.php">
                    <?php if (isset($message)) echo $message; ?>
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="current_password" type="password" class="form-control" id="currentPassword" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="new_password" type="password" class="form-control" id="newPassword" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="re_new_password" type="password" class="form-control" id="renewPassword" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
               
