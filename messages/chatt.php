<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor-Patient Chat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Aclonica" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            color: #777;
            background-color: #f2f2f2;
        }
        .chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            height: 400px;
            overflow-y: scroll;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .message.patient {
            background-color: #d0e9c6;
        }
        .message.doctor {
            background-color: #f7c6c7;
        }
        .chat-input {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Doctor-Patient Chat</h2>
        <div class="chat-box" id="chatBox">
            <?php
            // Fetch the chat history from the database
            $email = $_SESSION['email'];
            $query = "SELECT * FROM messages WHERE (sender_email='$email' OR receiver_email='$email') ORDER BY timestamp ASC";
            $result = mysqli_query($db, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $sender = ($row['sender_email'] == $email) ? 'patient' : 'doctor';
                echo "<div class='message $sender'>{$row['message']}</div>";
            }
            ?>
        </div>
        <form action="chat.php" method="POST">
            <textarea name="message" class="form-control chat-input" placeholder="Type your message..." rows="3"></textarea><br>
            <button type="submit" name="sendMessage" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <?php
    if (isset($_POST['sendMessage'])) {
        $message = mysqli_real_escape_string($db, $_POST['message']);
        $receiver_email = "doctor@example.com"; // You would retrieve this based on the chat context

        if (!empty($message)) {
            // Insert the new message into the database
            $query = "INSERT INTO messages (sender_email, receiver_email, message) VALUES ('$email', '$receiver_email', '$message')";
            if (mysqli_query($db, $query)) {
                echo "<script>window.location.reload();</script>";
            } else {
                echo "<p class='text-danger'>Error sending message. Please try again.</p>";
            }
        }
    }
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
