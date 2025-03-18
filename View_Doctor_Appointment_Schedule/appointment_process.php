<?php
// Include the database connection
include("../connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $doctor_id = $_POST['doctor_id'];
    $time_slot = $_POST['time_slot'];
    $user_name = $_POST['user_name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $appointment_date = date("Y-m-d H:i:s"); // Set current date and time

    // Insert the appointment request into the database
    $query = "INSERT INTO appointments (doctor_id, user_name, contact, email, time_slot, appointment_date, status) 
              VALUES ('$doctor_id', '$user_name', '$contact', '$email', '$time_slot', '$appointment_date', 'Pending')";

    if (mysqli_query($db, $query)) {
        // Redirect to the doctor's appointment request page in the 'doctor' folder
        echo "<script>alert('Appointment request sent successfully!'); window.location.href='./user_appointment_request.php';</script>";
    } else {
        // Show an error message if the query fails
        echo "<script>alert('Error: " . mysqli_error($db) . "'); window.history.back();</script>";
    }
}
?>
