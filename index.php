<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $contact = $_POST['contact'];
    $transaction = $_POST['transaction'];
    $player1 = $_POST['player1'];
    $level1 = $_POST['level1'];
    $player2 = $_POST['player2'];
    $level2 = $_POST['level2'];

    // Create the entry to save
    $entry = "Contact - [{$contact}]\nTransaction - [{$transaction}]\nUID1 - ({$player1}) : (Level {$level1})\nUID2 - ({$player2}) : (Level {$level2})\n\n";

    // Path to the file where registration data will be stored
    $filePath = 'registrations.txt';

    // Check if file exists and read its content
    if (file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);

        // Check if the entry already exists in the file
        if (strpos($fileContent, $entry) !== false) {
            $response = ['success' => false, 'message' => 'You have already registered with this information.'];
            echo json_encode($response);
            exit;
        }
    }

    // Append new entry to the file
    file_put_contents($filePath, $entry, FILE_APPEND);

    // Return a success response
    $response = ['success' => true, 'message' => 'Registration successful! Thank you for registering.'];
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Fire Tournament Registration</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
            background: linear-gradient(to right, #ff7f00, #ffcc00);
            color: #333;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #222;
            color: #fff;
            padding: 15px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
        }

        .header-buttons button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #ffcc00;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container {
            max-width: 800px;
            margin: 120px auto 50px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            color: #ff7f00;
            margin-bottom: 30px;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            width: 100%;
        }

        .terms {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #ff7f00;
            color: #fff;
            font-size: 1.2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .footer {
            background-color: #222;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .form-group {
                grid-template-columns: 1fr;
            }

            .header-buttons button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="header-content">
            <h1>Free Fire Tournament</h1>
            <div class="header-buttons">
                <button onclick="window.location.href='#'">Open QR</button>
                <button onclick="window.location.href='#'">Join Telegram</button>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Register for the Tournament</h2>
        <form id="registrationForm" method="POST">
            <label for="contact">Contact No</label>
            <input type="text" id="contact" name="contact" required pattern="\d{10}" placeholder="Enter 10-digit number">

            <div class="form-group">
                <div>
                    <label for="player1">Player 1 UID</label>
                    <input type="text" id="player1" name="player1" required>
                    <label for="level1">Level</label>
                    <input type="number" id="level1" name="level1" required>
                </div>
                <div>
                    <label for="player2">Player 2 UID</label>
                    <input type="text" id="player2" name="player2" required>
                    <label for="level2">Level</label>
                    <input type="number" id="level2" name="level2" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2025 Free Fire Tournament. All rights reserved.</p>
    </div>

    <script>
        document.getElementById('registrationForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('index.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => alert(data.message))
              .catch(error => alert('Error submitting registration.'));
        };
    </script>

</body>
</html>
