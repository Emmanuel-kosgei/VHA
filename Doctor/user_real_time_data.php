<?php
// Start the session and include the connection to the database
session_start();
include("connection.php");

// Ensure the doctor is logged in (check for session or doctor ID)
if(!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php"); // Redirect to login if not logged in
    exit();
}

// Get the doctor ID from the session
$doctor_id = $_SESSION['doctor_id'];

// Get the patient ID from the URL or request
$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : null;

// If no patient_id is provided, show an error or redirect
if(!$patient_id) {
    echo "Patient not found.";
    exit();
}

// Fetch patient details from the 'user' table
$query_patient = "SELECT * FROM user WHERE id = '$patient_id'";
$result_patient = mysqli_query($db, $query_patient);
$patient = mysqli_fetch_assoc($result_patient);

// Calculate patient's age from the DOB field
$dob = new DateTime($patient['DOB']);
$today = new DateTime();
$age = $dob->diff($today)->y;

// Fetch patient's appointments
$query_appointments = "SELECT * FROM appointments WHERE doctor_id = '$doctor_id' AND user_name = '{$patient['f_name']}'";
$result_appointments = mysqli_query($db, $query_appointments);

// Fetch patient's prescriptions
$query_prescriptions = "SELECT * FROM medicine_prescription WHERE patient_id = '$patient_id' AND doctor_email = '{$patient['email']}'";
$result_prescriptions = mysqli_query($db, $query_prescriptions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Consultation</title>
    <link href="https://fonts.googleapis.com/css?family=Aclonica" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            margin: 0 auto;
            width: 80%;
        }
        .patient-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .patient-info h2 {
            color: #2d3e50;
        }
        .patient-info p {
            font-size: 18px;
            color: #333;
        }
        .appointments, .prescriptions {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .appointments h3, .prescriptions h3 {
            color: #2d3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
        }
        .status {
            padding: 5px;
            background-color: #16a085;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Patient Consultation - <?= $patient['f_name'] ?> <?= $patient['l_name'] ?></h1>

    <!-- Patient Information -->
    <div class="patient-info">
        <h2>Patient Information</h2>
        <p><strong>Name:</strong> <?= $patient['f_name'] ?> <?= $patient['l_name'] ?></p>
        <p><strong>Age:</strong> <?= $age ?> years</p>
        <p><strong>Gender:</strong> <?= $patient['gender'] ?></p>
        <p><strong>Marital Status:</strong> <?= $patient['maritialstatus'] ?></p>
        <p><strong>Contact:</strong> <?= $patient['contact'] ?></p>
        <p><strong>Address:</strong> <?= $patient['address'] ?></p>
    </div>

    <!-- Appointments Section -->
    <div class="appointments">
        <h3>Appointments</h3>
        <?php if(mysqli_num_rows($result_appointments) > 0): ?>
            <table>
                <tr>
                    <th>Appointment Date</th>
                    <th>Time Slot</th>
                    <th>Status</th>
                </tr>
                <?php while ($appointment = mysqli_fetch_assoc($result_appointments)): ?>
                    <tr>
                        <td><?= date('Y-m-d', strtotime($appointment['appointment_date'])) ?></td>
                        <td><?= $appointment['time_slot'] ?></td>
                        <td><span class="status"><?= $appointment['status'] ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No appointments found for this patient.</p>
        <?php endif; ?>
    </div>

    <!-- Prescriptions Section -->
    <div class="prescriptions">
        <h3>Prescriptions</h3>
        <?php if(mysqli_num_rows($result_prescriptions) > 0): ?>
            <table>
                <tr>
                    <th>Medicine Name</th>
                    <th>Description</th>
                    <th>Date Prescribed</th>
                    <th>Status</th>
                </tr>
                <?php while ($prescription = mysqli_fetch_assoc($result_prescriptions)): ?>
                    <tr>
                        <td><?= $prescription['medicine_name'] ?></td>
                        <td><?= $prescription['description'] ?></td>
                        <td><?= date('Y-m-d', strtotime($prescription['date_prescribed'])) ?></td>
                        <td><span class="status"><?= ucfirst($prescription['status']) ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No prescriptions found for this patient.</p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
