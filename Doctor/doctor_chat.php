<?php
session_start();
include("connection.php");

// Check if the doctor is logged in
if (!isset($_SESSION['email'])) {
    echo "<script> window.location='doctor_login.php'; </script>";
    exit();
}

// Get the logged-in doctor's email
$doctor_email = $_SESSION['email'];

// Fetch the doctor's details from the database
$query_doctor = "SELECT * FROM doctor WHERE email = '$doctor_email' LIMIT 1";
$result_doctor = mysqli_query($db, $query_doctor);
$doctor = mysqli_fetch_assoc($result_doctor);

if (!$doctor) {
    echo "Doctor not found.";
    exit;
}

$doctor_id = $doctor['id'];  // Get the doctor's ID

// Fetch the list of patients that the doctor has communicated with
$query_patients = "
    SELECT DISTINCT u.id, u.f_name, u.l_name, u.email
    FROM user u
    JOIN message m ON m.pid = u.id
    WHERE m.sid = '$doctor_id' AND m.deleted = 0
    ORDER BY u.f_name ASC
";
$result_patients = mysqli_query($db, $query_patients);
$patients = mysqli_fetch_all($result_patients, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Chat List</title>
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
        .patient-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .patient-item {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #e0f7fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .patient-item a {
            color: #00796b;
            font-weight: bold;
            text-decoration: none;
        }
        .patient-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Chat with Patients</h1>

<div class="patient-list">
    <?php if ($patients): ?>
        <?php foreach ($patients as $patient): ?>
            <div class="patient-item">
                <span><?php echo $patient['f_name'] . " " . $patient['l_name']; ?></span>
                <a href="profile_chat.php?patient_id=<?php echo $patient['id']; ?>">Chat</a>
                <!-- Button to view real-time data -->
                
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No patients found.</p>
    <?php endif; ?>
</div>

</body>
</html>
