<?php
include("connection.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: userlogin.php"); // Redirect if not logged in
    exit();
}

// Get user ID from session
$user_email = $_SESSION['email'];
$query_user_id = "SELECT id FROM user WHERE email = '$user_email'";
$user_result = mysqli_query($db, $query_user_id);
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

// Check if the prescription ID is passed and mark it as read
if (isset($_GET['prescription_id'])) {
    $prescription_id = $_GET['prescription_id'];

    // Update the status to 'read'
    $query_update_status = "UPDATE medicine_prescription SET status = 'read' WHERE id = '$prescription_id' AND patient_id = '$user_id'";
    $update_result = mysqli_query($db, $query_update_status);

    if ($update_result) {
        // Redirect to prescriptions page after updating status
        header("Location: view_prescription.php");
        exit();
    } else {
        $error_msg = "Failed to mark prescription as read.";
    }
}

// Fetch the unread prescription count for the logged-in user
$query_unread_prescriptions = "
    SELECT COUNT(*) as unread_count 
    FROM medicine_prescription 
    WHERE patient_id = '$user_id' AND status = 'unread'
";
$unread_result = mysqli_query($db, $query_unread_prescriptions);
$unread_data = mysqli_fetch_assoc($unread_result);
$unread_count = $unread_data['unread_count'];
?>
