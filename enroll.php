<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['course_id'])) {
    header("Location: courses.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];

// Check if already enrolled
$check_query = "SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    // Insert enrollment record
    $query = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['enrolled_success'] = true;
    }
}

header("Location: courses.php");
exit();
?>
