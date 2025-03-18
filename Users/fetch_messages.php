<?php
include "connection.php";

// Retrieve the patient ID and doctor ID from the GET request
$pid = isset($_GET['pid']) ? (int) $_GET['pid'] : 0;
$sid = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;

if ($pid > 0 && $sid > 0) {
    // Fetch chat messages between the patient and doctor
    $query = "SELECT * FROM message WHERE (pid = '$pid' AND sid = '$sid') OR (sid = '$sid' AND pid = '$pid') ORDER BY date ASC";
    $run = $db->query($query);

    if ($run) {
        while ($row = $run->fetch_array()) {
            $message = htmlspecialchars($row['message']);
            $role = htmlspecialchars($row['role']);
            $date = htmlspecialchars($row['date']);

            // Display the message
            if ($role == 'patient') {
                echo "<div style='color: green;'><strong>Patient:</strong> $message <span style='float:right;'>$date</span></div>";
            } elseif ($role == 'doctor') {
                echo "<div style='color: blue;'><strong>Doctor:</strong> $message <span style='float:right;'>$date</span></div>";
            }
        }
    } else {
        echo "No messages available.";
    }
}
?>
