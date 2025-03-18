<?php
session_start();
include("connection.php");

// Check if the doctor is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    echo "<script> window.location='doctor_login.php'; </script>";
    exit();
}

// Get the logged-in doctor's email from session
$doctor_email = $_SESSION['email'];

// Fetch the doctor's details based on the email
$query_doctor = "SELECT * FROM doctor WHERE email = '$doctor_email' LIMIT 1";
$result_doctor = mysqli_query($db, $query_doctor);
$doctor = mysqli_fetch_assoc($result_doctor);

// If the doctor doesn't exist
if (!$doctor) {
    echo "Doctor not found.";
    exit;
}

$doctor_id = $doctor['id'];  // Get the doctor's ID
$doctor_name = $doctor['f_name'] . " " . $doctor['l_name'];

// Fetch the list of patients that the doctor has communicated with
$query_patients = "
    SELECT DISTINCT u.id, u.f_name, u.l_name, u.email
    FROM user u
    JOIN message m ON (m.pid = u.id AND m.sid = '$doctor_id')
    WHERE m.deleted = 0
    ORDER BY u.f_name ASC
";
$result_patients = mysqli_query($db, $query_patients);
$patients = mysqli_fetch_all($result_patients, MYSQLI_ASSOC);

// If a patient is selected
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch the selected patient's details
    $query_patient = "SELECT * FROM user WHERE id = '$patient_id' LIMIT 1";
    $result_patient = mysqli_query($db, $query_patient);
    $patient = mysqli_fetch_assoc($result_patient);

    if (!$patient) {
        echo "Patient not found.";
        exit;
    }

    // Fetch the chat history with the selected patient
    $query_messages = "
        SELECT m.id, m.message, m.role, m.date
        FROM message m
        WHERE (m.pid = '$patient_id' AND m.sid = '$doctor_id' AND m.deleted = 0) 
            OR (m.pid = '$doctor_id' AND m.sid = '$patient_id' AND m.deleted = 0)
        ORDER BY m.date ASC
    ";
    $result_messages = mysqli_query($db, $query_messages);
}

// Handle message sending
if (isset($_POST['submit'])) {
    $message = mysqli_real_escape_string($db, $_POST['message']);
    $patient_id = $_POST['patient_id'];
    $role = 'doctor'; // Since the doctor is sending the message

    if (!empty($message)) {
        $query_insert = "INSERT INTO message (pid, sid, message, role) VALUES ('$patient_id', '$doctor_id', '$message', '$role')";
        $result_insert = mysqli_query($db, $query_insert);

        if ($result_insert) {
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF'] . "?patient_id=" . $patient_id);
            exit();
        } else {
            echo "<script>alert('Error sending message. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Message cannot be empty.');</script>";
    }
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
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
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
            background-color: #e0ffe0; /* Patient's message background */
            text-align: left; /* Patient message on the left */
            margin-right: auto; /* Align it to the left */
        }
        .doctor {
            background-color: #e0f7fa; /* Doctor's message background */
            text-align: right; /* Doctor message on the right */
            margin-left: auto; /* Align it to the right */
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
    </style>
</head>
<body>

<h1>Reply to Patients</h1>

<!-- Patient Selection -->
<div id="patient-list">
    <h2>Patients</h2>
    <ul>
        <?php foreach ($patients as $patient): ?>
            <li><a href="?patient_id=<?= $patient['id']; ?>"><?= $patient['f_name'] . " " . $patient['l_name']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php if (isset($patient_id)): ?>
    <div id="chatbox">

        <div id="chat-content">
            <?php while ($message = mysqli_fetch_assoc($result_messages)): ?>
                <div class="message <?= ($message['role'] == 'doctor') ? 'doctor' : 'patient'; ?>" id="message-<?= $message['id']; ?>">
                    <p><?= $message['message']; ?></p>
                    <span style="font-size: 12px; color: #aaa;"><?= $message['date']; ?></span>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="post" action="">
            <textarea name="message" placeholder="Enter your message" required></textarea>
            <input type="hidden" name="patient_id" value="<?= $patient_id; ?>">
            <input type="submit" name="submit" value="Send Message">
        </form>
    </div>
<?php endif; ?>

</body>
</html>
