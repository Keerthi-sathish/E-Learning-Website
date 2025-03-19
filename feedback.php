<?php
session_start();
include('server.php');

if (!isset($_SESSION['user_id'])) {
    header("location: login.html"); 
    exit();
}

$rating = 0; 
$thankYouMessage = '';

if (isset($_SESSION['thank_you_shown']) && $_SESSION['thank_you_shown'] == true) {
    $thankYouMessage = "Thank you for your feedback!";
    unset($_SESSION['thank_you_shown']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = $_POST['feedback'];
    if (isset($_POST['rating'])) {
        $rating = $_POST['rating']; 
    }
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO feedback (user_id, feedback, rating) VALUES ('$user_id', '$feedback', '$rating')";
    if ($conn->query($query) === TRUE) {
        $_SESSION['thank_you_shown'] = true;
        header("Location: feedback.php"); 
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url("login1.jpg");
            background-size: cover;
            background-position: center;
        }
        .star-container {
            display: flex;
            justify-content: center; 
            gap: 5px; 
        }

        .star {
            font-size: 3rem;  
            cursor: pointer;
            color: lightgray;  
        }

        .star.selected, .star:hover {
            color: yellow;  
        }

        .thank-you-message {
            display: none; 
            text-align: center;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            opacity: 0;
            animation: showMessage 0.5s ease-in-out forwards;
        }

        @keyframes showMessage {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .underline-input {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #000;
            outline: none;
            background: transparent;
            font-size: 1rem;
            color: black;
            white-space: pre-wrap; 
            word-wrap: break-word; 
        }

        .underline-input:focus {
            border-color: #4CAF50;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
    </style>
    <link rel="stylesheet" href="response.css">

</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-opacity-50">

    <div class="w-full max-w-md p-8 bg-white bg-opacity-10 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-black mb-6">Feedback</h2>
        <form method="POST" class="space-y-4 form-container">
            <div>
                <label class="block text-sm font-medium text-black">Your Feedback</label>
                <textarea name="feedback" class="underline-input" rows="3"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-black">Rating</label>
                <div class="star-container">
                    <div class="star" id="star1" data-index="1">&#9733;</div>
                    <div class="star" id="star2" data-index="2">&#9733;</div>
                    <div class="star" id="star3" data-index="3">&#9733;</div>
                    <div class="star" id="star4" data-index="4">&#9733;</div>
                    <div class="star" id="star5" data-index="5">&#9733;</div>
                </div>

                <input type="hidden" name="rating" id="rating" value="0">
            </div>

            <button type="submit" class="w-full py-2 mt-4 text-lg font-semibold text-center text-black bg-gray-900 bg-opacity-20 rounded-lg hover:bg-opacity-30">Submit Feedback</button>
        </form>

        <?php if ($thankYouMessage): ?>
            <div class="thank-you-message" id="thankYouMessage">
                <?php echo $thankYouMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                ratingInput.value = index;  
                stars.forEach(star => {
                    if (parseInt(star.getAttribute('data-index')) <= index) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            });
        });

        <?php if ($thankYouMessage): ?>
            window.onload = function() {
                const thankYouMessage = document.getElementById('thankYouMessage');
                thankYouMessage.style.display = 'block';
                setTimeout(function() {
                    window.location.href = 'homepage.html'; 
                }, 3000);
            };
        <?php endif; ?>
    </script>
</body>
</html>
