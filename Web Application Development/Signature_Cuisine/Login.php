<?php

$conn = mysqli_connect('localhost', 'root', '', 'user_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $user_type = $row['user_type']; 

        if (password_verify($password, $hashed_password)) {

            if ($user_type === 'admin') {
                header('Location: Admin.html');
                exit();
            } else if ($user_type === 'user') {
                header('Location: Index.html');
                exit();
            }
        } else {
            // Incorrect password
            $error = 'Incorrect password!';
        }
    } else {
        // User not found
        $error = 'User not found!';
    }
}

mysqli_close($conn);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/Register_Login.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login Now</h3>
            <?php
            if (isset($error)) {
                echo '<p>' . $error . '</p>';
            }
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Login" class="form-btn">
            <p>Don't have an account? <a href="Register.php">Register now</a></p>
        </form>
    </div>
</body>
</html>

