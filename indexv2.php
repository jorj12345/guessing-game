<?php
session_start();

if (!isset($_SESSION['correct_number']) || isset($_POST['reset'])) {
    $_SESSION['correct_number'] = rand(1, 50);
    $_SESSION['tries_left'] = 5;
    $message = "You have 5 tries to guess the number between 1 and 50!<br>";
} elseif ($_SESSION['tries_left'] > 0) {
    $message = "You have {$_SESSION['tries_left']} tries remaining.";
}

if (isset($_POST['guess']) && $_POST['guess'] !== '' && $_SESSION['tries_left'] > 0) {
    $guess = intval($_POST['guess']);
    $_SESSION['tries_left']--;

    if ($guess == $_SESSION['correct_number']) {
        $message = "<span style='color: green;'>Congratulations! You guessed the correct number ({$_SESSION['correct_number']})!</span>";
        $_SESSION['tries_left'] = 0;
    } elseif ($_SESSION['tries_left'] > 0) {
        if ($guess > $_SESSION['correct_number']) {
            $message = "<span style='color: red;'>Too high!</span> Tries left: {$_SESSION['tries_left']}.";
        } else {
            $message = "<span style='color: blue;'>Too low!</span> Tries left: {$_SESSION['tries_left']}.";
        }
    } else {
        $message = "<span style='color: orange;'>Game over! The correct number was {$_SESSION['correct_number']}.</span>";
    }
} elseif (isset($_POST['guess']) && $_POST['guess'] === '') {
    $message = "<span style='color: purple;'>Please enter a valid number.</span> You still have {$_SESSION['tries_left']} tries left.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4caf50;
        }
        form {
            margin: 15px 0;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        input[type="number"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Guessing Game</h1>
        <p><?php echo $message; ?></p>

        <?php if ($_SESSION['tries_left'] > 0): ?>
            <form method="post">
                <label for="guess">Enter your guess:</label>
                <input type="number" name="guess" id="guess" min="1" max="50" required>
                <button type="submit">Submit Guess</button>
            </form>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="reset">Play Again</button>
            </form>
        <?php endif; ?>

        <br>
        <form method="post">
            <button type="submit" name="reset">Reset Game</button>
        </form>
    </div>
</body>
</html>
