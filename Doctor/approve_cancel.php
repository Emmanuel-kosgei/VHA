<?php
include("../connection.php");

// Check if the action and appointment_id are set in the GET request
if(isset($_GET['action']) && isset($_GET['appointment_id'])){
    $action = $_GET['action'];
    $appointment_id = $_GET['appointment_id'];

    // Depending on the action, update the status in the database
    if ($action == 'approve') {
        $query = "UPDATE appointments SET permission = 'Approved' WHERE appointment_id = '$appointment_id'";
    } elseif ($action == 'cancel') {
        $query = "UPDATE appointments SET permission = 'Cancelled' WHERE appointment_id = '$appointment_id'";
    }

    // Execute the query
    if (mysqli_query($db, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
