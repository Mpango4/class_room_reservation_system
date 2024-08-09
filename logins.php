<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, firstname, lastname, role, password, image,  department, phonenumber, class FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $firstname, $lastname, $role, $hashed_password, $image, $department,$phonenumber, $class);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $id;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['image'] = $image;
            $_SESSION['department'] = $department;
            $_SESSION['phonenumber'] = $phonenumber;
            $_SESSION['class'] = $class;
            // Store the image name in session
            
            // Redirect based on role
            if ($role == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($role == 'hod') {
                header("Location: admin/dashboard.php");
            } elseif ($role == 'CR') {
                header("Location: admin/dashboard.php");
            } elseif ($role == 'Lecture') {
                header("Location: admin/hod.php");
            } else {
                echo "Unauthorized access.";
                session_unset();
                session_destroy();
            }
            exit();
        } else {
            // Invalid password
            $error = "Invalid email or password.";
        }
    } else {
        // User doesn't exist
        $error = "Invalid email or password.";
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Users Login</h2>
        <form action="logins.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php
            if (isset($error)) {
                echo "<div class='error'>$error</div>";
            }
            ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
