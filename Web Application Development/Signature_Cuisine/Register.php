<?php

$conn = mysqli_connect('localhost','root','','user_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];


    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($password !== $cpassword) {
            $error[] = 'passwords does not match!';
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_password', '$user_type')";
            if (mysqli_query($conn, $insert)) {
                header('Location: Login.php');
                exit();
            } else {
                $error[] = 'Error inserting user data: ' . mysqli_error($conn);
            }
        }
    }
}

mysqli_close($conn);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/Register_Login.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $err) {
                    echo '<p>' . $err . '</p>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <select name="user_type">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register" class="form-btn">
            <p>Already have an account? <a href="Login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>

