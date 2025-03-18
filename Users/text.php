<?php
session_start(); // Start the session to access session variables
include "connection.php"; // Database connection

// Check if session variable is set
if (!isset($_SESSION['email'])) {
    echo "You must be logged in to chat.";
    exit;
}

// Fetch the user ID from the 'users' table based on the session email
$email = $_SESSION['email']; // Assuming email is stored in the session
$query_user = "SELECT id FROM user WHERE email = '$email' LIMIT 1";
$result_user = mysqli_query($db, $query_user);

if ($result_user && mysqli_num_rows($result_user) > 0) {
    $user = mysqli_fetch_assoc($result_user);
    $patient_id = $user['id']; // Get the patient (user) ID
} else {
    echo "User not found.";
    exit;
}

// Initialize doctor_id to null
$doctor_id = null;

// Check if the patient has selected a doctor
if (isset($_GET['sid'])) {
    $doctor_id = $_GET['sid'];

    // Fetch doctor details from the database
    $query_doctor = "SELECT * FROM doctor WHERE id = '$doctor_id' LIMIT 1";
    $result_doctor = mysqli_query($db, $query_doctor);
    $doctor = mysqli_fetch_assoc($result_doctor);

    if (!$doctor) {
        echo "Doctor not found!";
        exit;
    }

    // Fetch existing chat messages between the patient and the doctor, excluding deleted ones
    $query_messages = "SELECT * FROM message WHERE (pid = '$patient_id' AND sid = '$doctor_id' AND deleted = 0) OR (pid = '$doctor_id' AND sid = '$patient_id' AND deleted = 0) ORDER BY date ASC";
    $result_messages = mysqli_query($db, $query_messages);
}

// Handle message sending
$feedback_message = '';
if (isset($_POST['submit'])) {
    $message = mysqli_real_escape_string($db, $_POST['message']);
    $role = 'patient'; // Assuming the message is sent by the patient, you can change this for doctors

    // Check if the message is not empty
    if (!empty($message)) {
        // Insert the new message into the database
        $query_insert = "INSERT INTO message (pid, sid, message, role) VALUES ('$patient_id', '$doctor_id', '$message', '$role')";
        $result_insert = mysqli_query($db, $query_insert);

        if ($result_insert) {
            // Success: Redirect back to the same page to prevent resubmission on refresh
            header("Location: " . $_SERVER['PHP_SELF'] . "?sid=" . $doctor_id); // Redirect after POST
            exit; // Make sure no further code is executed
        } else {
            // Error: Show message not sent feedback
            $feedback_message = 'Error sending message. Please try again.';
        }
    } else {
        // Error: Empty message
        $feedback_message = 'Message cannot be empty.';
    }
}

// Handle deleting a message (AJAX request)
if (isset($_GET['delete_message_id'])) {
    $message_id = $_GET['delete_message_id'];

    // Sanitize message ID to avoid SQL injection
    $message_id = mysqli_real_escape_string($db, $message_id);

    // Mark the message as deleted in the database
    $query_delete = "UPDATE message SET deleted = 1 WHERE id = '$message_id' AND (pid = '$patient_id' OR sid = '$doctor_id')";
    $result_delete = mysqli_query($db, $query_delete);

    if ($result_delete) {
        echo 'Message marked as deleted.';
    } else {
        echo 'Error deleting message.';
    }

    exit;
}

// Fetch messages for AJAX request
if (isset($_GET['fetch_messages'])) {
    $query_messages = "SELECT * FROM message WHERE (pid = '$patient_id' AND sid = '$doctor_id' AND deleted = 0) OR (pid = '$doctor_id' AND sid = '$patient_id' AND deleted = 0) ORDER BY date ASC";
    $result_messages = mysqli_query($db, $query_messages);
    
    $messages = [];
    while ($message = mysqli_fetch_assoc($result_messages)) {
        $messages[] = [
            'id' => $message['id'], // Add message ID
            'role' => $message['role'],
            'message' => $message['message'],
            'date' => $message['date']
        ];
    }

    echo json_encode($messages);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Chat</title>
    <link href="https://fonts.googleapis.com/css?family=Aclonica" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        #chatbox {
            background-color: #fff;
            padding: 100px;
            border-radius: 8px;
            width: 80%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        #chat-content {
            flex: 1;
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            font-size: 14px;
            word-wrap: break-word;
            max-width: 80%;
        }
        .patient {
            background-color: #e0ffe0;
            text-align: right;
            margin-left: auto;
        }
        .doctor {
            background-color: #e0f7fa;
            text-align: left;
            margin-right: auto;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            font-size: 14px;
            resize: none;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .feedback {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<h1>Enjoy IT!</h1>

<!-- Chat Box -->
<?php if (isset($doctor_id) && isset($patient_id)) : ?>
    <div id="chatbox">

        <div id="chat-content">
            <?php while ($message = mysqli_fetch_assoc($result_messages)) : ?>
                <div class="message <?= ($message['role'] == 'patient') ? 'patient' : 'doctor'; ?>" id="message-<?= $message['id']; ?>">
                    <p><?= $message['message']; ?></p>
                    <span style="font-size: 12px; color: #aaa;"><?= $message['date']; ?></span>
                    <button onclick="deleteMessage(<?= $message['id']; ?>)">Delete</button>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="post" action="">
            <textarea name="message" placeholder="Enter your message" required></textarea>
            <input type="hidden" name="pid" value="<?= $patient_id; ?>">
            <input type="hidden" name="sid" value="<?= $doctor_id; ?>">
            <input type="hidden" name="role" value="patient">
            <input type="submit" name="submit" value="Send Message">
        </form>
    </div>
<?php endif; ?>

<script>
    // Function to delete message from chat display (and mark as deleted in the database)
    function deleteMessage(messageId) {
        const messageElement = document.getElementById('message-' + messageId);
        if (messageElement) {
            // Make an AJAX call to mark the message as deleted in the database
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'text.php?delete_message_id=' + messageId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Message marked as deleted.');
                    messageElement.remove();  // Remove the message from chat display
                } else {
                    alert('Failed to delete the message.');
                }
            };
            xhr.send();
        }
    }
</script>

</body>
</html>
