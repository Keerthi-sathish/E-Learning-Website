<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$enrolled_courses = [];
$enroll_query = "SELECT course_id FROM enrollments WHERE user_id = $user_id";
$enroll_result = mysqli_query($conn, $enroll_query);
while ($row = mysqli_fetch_assoc($enroll_result)) {
    $enrolled_courses[] = $row['course_id'];
}

// Check if a specific course is selected
if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);

    // Check if the user is enrolled
    if (!in_array($course_id, $enrolled_courses)) {
        echo "<script>alert('You must enroll in this course to watch the video.'); window.location.href='courses.php';</script>";
        exit();
    }

    // Fetch course details
    $query = "SELECT * FROM courses WHERE id = $course_id";
    $result = mysqli_query($conn, $query);
    $course = mysqli_fetch_assoc($result);

    if (!$course) {
        echo "Course not found.";
        exit();
    }
    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $course['name']; ?> - Watch</title>
        <link rel="stylesheet" href="style1.css">
        <link rel="stylesheet" href="response.css">

        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
                background-color: #f4f4f4;
            }
            .video-container {
                text-align: center;
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(204, 10, 185, 0.1);
            }
            iframe {
                width: 800px;
                height: 450px;
                border-radius: 10px;
            }
            .back-btn {
                display: block;
                margin-top: 20px;
                padding: 10px 20px;
                background: blue;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            .header {
                display: flex;
                align-items: center;
                justify-content: space-between; 
                background-color: peachpuff;
                padding: 10px 20px;
                box-shadow: 0 2px 5px rgba(201, 182, 14, 0.1);
                position: sticky;
                top: 0;
                font-size: 1.2rem;
                z-index: 1;
            }
        </style>
    </head>
    <body>

    <div class="video-container">
        <h2><?php echo $course['name']; ?></h2>
        <p><?php echo $course['description']; ?></p>
        
        <iframe src="<?php echo $course['video_url']; ?>" allowfullscreen></iframe>
        
        <a href="courses.php" class="back-btn">Back to Courses</a>
    </div>

    </body>
    </html>
    <?php
    exit();
}

// If no specific course is selected, show all courses
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Courses</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<header class="navbar">
    <div class="logo">LMC</div>
    <nav background-color="peachpuff">
        <a href="homepage.html">Home</a>&nbsp;&nbsp;
        <a href="homepage.html#services">Services</a>&nbsp;&nbsp;
        <a href="homepage.html#about">About</a>&nbsp;&nbsp;
        <a href="courses.php">Courses</a>&nbsp;&nbsp;
        <a href="feedback.php">Feedback</a>&nbsp;&nbsp;
        <a href="homepage.html#contact">Contact</a>&nbsp;&nbsp;
        <a href="logout.php">Logout</a>&nbsp;&nbsp;
    </nav>
</header>

<div class="course-container">
    <?php while ($row = mysqli_fetch_assoc($result)) { 
        $courseId = $row['id'];
        $isEnrolled = in_array($courseId, $enrolled_courses);
    ?>
        <div class="course">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            
            <img src="<?php echo $row['image_url']; ?>" alt="Course Image" width="300" height="200" style="cursor: pointer;"
                onclick="window.location.href='courses.php?course_id=<?php echo $courseId; ?>'">
            
            <form action="enroll.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                <button type="submit" 
                    style="background-color: <?php echo $isEnrolled ? 'green' : 'blue'; ?>; color: white;">
                    <?php echo $isEnrolled ? 'Enrolled' : 'Enroll'; ?>
                </button>
            </form>
        </div>
    <?php } ?>
</div>

</body>
</html>
