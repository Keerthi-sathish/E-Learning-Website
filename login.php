<?php
session_start();
include 'database.php'; 
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and Password are required!'); window.location.href='login.html';</script>";
        exit();
    }

    // Prepare and execute the SQL statement
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if user exists
    if ($user = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Store login details in the database
            $user_id = $user['id'];
            $login_time = date('H:i:s');
            $login_date = date('Y-m-d');

            $insert_session = "INSERT INTO user_sessions (user_id, login_time, login_date) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_session);
            mysqli_stmt_bind_param($stmt_insert, "iss", $user_id, $login_time, $login_date);
            mysqli_stmt_execute($stmt_insert);

            // Redirect to courses.php
            header("Location: courses.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password! Please try again.'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        // No user found with this email
        echo "<script>alert('No user found with this email! Please sign up.'); window.location.href='signup.html';</script>";
        exit();
    }
}
?>
