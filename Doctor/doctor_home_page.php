<?php
include("connection.php");
session_start();

$d_email = $_SESSION['email']; // Store the logged-in doctor's email

// Query to get the number of pending and deleted appointments
$queryAppointmentCounts = "
    SELECT 
        SUM(CASE WHEN appointment.permission = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
        SUM(CASE WHEN appointment.permission = 'Deleted' THEN 1 ELSE 0 END) AS deleted_count
    FROM doctor
    JOIN schedule ON schedule.d_id = doctor.id
    JOIN appointment ON appointment.sid = schedule.s_id
    JOIN user ON appointment.pid = user.id
    WHERE doctor.email = '$d_email'
";
$runAppointmentCounts = mysqli_query($db, $queryAppointmentCounts);
$counts = mysqli_fetch_assoc($runAppointmentCounts);
$count = $counts['pending_count'];
$count1 = $counts['deleted_count'];

// Query to get doctor's profile
$edit_doctor_profile_query = "SELECT * FROM doctor WHERE email = '$d_email'";
$edit_run_doctor_profile_query = mysqli_query($db, $edit_doctor_profile_query);
$drow = mysqli_fetch_array($edit_run_doctor_profile_query);
$doctor_name = $drow['f_name'] . ' ' . $drow['l_name']; // Concatenate first and last name
$doctor_specialty = $drow['specialty'];
$doctor_email = $drow['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Medical Service</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1, h3, h4 {
            color: #2d3e50;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #3a5a7b;
            border: none;
            border-radius: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .navbar li a, .navbar .navbar-brand {
            color: white !important;
        }

        .navbar-nav li a:hover {
            background-color: #2c3e50 !important;
            color: white !important;
        }

        .navbar-nav li.active a {
            color: white !important;
            background-color: #1abc9c !important;
        }

        /* Card Styling */
        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 70%;
            max-width: 500px;
        }

        .profile-card h1 {
            font-size: 36px;
            color: #3a5a7b;
        }

        .profile-card p {
            font-size: 20px;
            color: #2d3e50;
            margin: 10px 0;
        }

        .profile-card span {
            font-size: 18px;
            color: #16a085;
            font-weight: 600;
        }

        /* Footer Styling */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: #1abc9c;
            text-decoration: none;
        }

        .footer a:hover {
            color: #16a085;
        }
    </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#myPage"><strong>e-healthcare</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="view_doctor_profile.php">Profile</a></li>
                <li><a href="view_my_schedule.php">My Schedule</a></li>
                <li><a href="prescription.php">Prescripe</a></li>
                <li><a href="patientData.php">View patient Data</a></li>
                <li><a href="user_appointment_request.php">Appointment Requests <?php echo ($count > 0) ? ' (' . $count . ')' : ''; ?></a></li>
                <li><a href="deleted_appointment_notification.php"><i class="fa fa-bell"><?php echo ($count1 > 0) ? ' (' . $count1 . ')' : ''; ?></i></a></li>
                <li><a href="doctor_chat.php"><i class="fa fa-comments"></i>Chat Now </a></li>
                <li><a href="doctorlogout.php"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Profile Section -->
<div class="profile-card">
    <h1>Welcome Again!<h2> <?php echo $doctor_name; ?></h2></h1>
    <p><strong>Email:</strong> <?php echo $doctor_email; ?></p>
    <p><strong>Specialty:</strong> <?php echo $doctor_specialty; ?></p>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>&copy; 2025 e-healthcare. All rights reserved. <a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-service.php">Terms of Service</a></p>
</div>

</body>
</html>
