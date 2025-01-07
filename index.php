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
    $entry = "Contact - [{$contact}]\nTransaction - [{$transaction}]\nUID1 - ({$player1}) : (Level {$level1})\nUID2 - ({$player2}) : (Level {$level2})\n";

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
    <link rel="stylesheet" href="styles.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
            background: linear-gradient(to right, #ff7f00, #ffcc00);
            color: #333;
        }

        /* Header section with fixed position for top buttons */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #222;
            color: #fff;
            padding: 10px 0;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        .header-buttons {
            display: flex;
            gap: 20px;
        }

        .header-buttons button {
            padding: 12px 25px;
            font-size: 1.2rem;
            background-color: #ffcc00;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 150px;
        }

        .header-buttons button:hover {
            background-color: #e6b800;
        }

        .header-content h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #ff7f00;
        }

        /* Container for registration form */
        .container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            color: #ff7f00;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: bold;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group div {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="checkbox"] {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #ff7f00;
        }

        input.small-box {
            width: 80px;
            padding: 10px;
        }

        .terms {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .terms input {
            margin-right: 10px;
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
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #e6b800;
        }

        /* Transaction info button */
        .info-button {
            padding: 8px 15px;
            background-color: #ff7f00;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-left: 10px;
        }

        .note {
            margin: 20px 0;
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            color: #333;
        }

        .footer {
            background-color: #222;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Success Popup Styles */
        .success-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #28a745;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 1.2rem;
            z-index: 200;
        }

        .success-popup button {
            background-color: #fff;
            color: #28a745;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .success-popup button:hover {
            background-color: #e6f7e6;
        }

    </style>
</head>
<body>

    <!-- Header section with top buttons -->
    <header>
        <div class="header-content">
            <h1>Free Fire Tournament</h1>
            <div class="header-buttons">
                <button onclick="window.location.href='https://i.ibb.co/wMyq20V/IMG-20250107-WA0031.jpg'">Open QR</button>
                <button onclick="window.location.href='https://t.me/fftournamentsbsp'">Join Telegram</button>
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
                    <input type="text" id="player1" name="player1" required placeholder="Player 1 UID">
                    <label for="level1">Level</label>
                    <input type="number" class="small-box" id="level1" name="level1" required placeholder="Level">
                </div>
                <div>
                    <label for="player2">Player 2 UID</label>
                    <input type="text" id="player2" name="player2" required placeholder="Player 2 UID">
                    <label for="level2">Level</label>
                    <input type="number" class="small-box" id="level2" name="level2" required placeholder="Level">
                </div>
            </div>

            <div class="transaction-info">
                <label for="transaction">Transaction ID</label>
                <button type="button" class="info-button" onclick="window.open('https://basiccomputerhindi.com/wp-content/uploads/2020/11/Phonepe-Transaction.jpg', '_blank')">What Is Transaction ID</button>
            </div>
            <input type="text" id="transaction" name="transaction" required placeholder="Transaction ID">

            <div class="terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I accept the <a href="https://darkcollectorss.blogspot.com/2025/01/terms-conditions.html" target="_blank">Terms and Conditions</a></label>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>

        <div class="note">
            Join our Telegram for match details and direct communication with the organizers.
        </div>
    </div>

    <!-- Success Popup -->
    <div class="success-popup" id="successPopup">
        <p>Registration successful! Thank you for registering.</p>
        <button onclick="document.getElementById('successPopup').style.display='none'">Close</button>
    </div>

    <!-- Footer section -->
    <div class="footer">
        <p>&copy; 2025 Free Fire Tournament. All rights reserved.</p>
    </div>

    <script>
        const form = document.getElementById('registrationForm');

        form.onsubmit = function(e) {
            e.preventDefault();

            // Submit form via AJAX
            const formData = new FormData(form);

            fetch('index.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successPopup').style.display = 'block';
                    form.reset(); // Reset form after success
                } else {
                    alert(data.message);
                }
            })
            .catch(error => alert('Error submitting registration.'));
        };
    </script>

</body>
</html>
