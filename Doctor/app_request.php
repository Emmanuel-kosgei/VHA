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

        /* Carousel */
        .carousel-inner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            padding: 20px;
        }

        .carousel-item.active {
            height: 70vh;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            background-color: #ffffff;
        }

        .card-header {
            background-color: #3a5a7b;
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 18px;
        }

        .card-body {
            padding: 20px;
        }

        /* Button Styling */
        .btn-custom {
            background-color: #3a5a7b;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #2c3e50;
        }

        /* Footer Styling */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .footer a {
            color: #1abc9c;
            text-decoration: none;
        }

        .footer a:hover {
            color: #16a085;
        }

        /* Forms */
        .form-control {
            border-radius: 4px;
            border: 1px solid #ccc;
            box-shadow: none;
            font-size: 16px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            width: 100%;
            background-color: #f7f7f7;
        }

        /* Scroll to Top Button */
        .scroll-to-top-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #3a5a7b;
            color: white;
            border-radius: 50%;
            padding: 15px;
            font-size: 18px;
            display: none;
            cursor: pointer;
        }

        .scroll-to-top-btn:hover {
            background-color: #2c3e50;
        }
    </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<?php
include("connection.php");
session_start();

$d_email = $_SESSION['email']; // Store the logged-in doctor's email

// Query to get the doctor's profile and appointments
$edit_doctor_profile_query = "SELECT * FROM doctor 
                               JOIN schedule ON schedule.d_id = doctor.id 
                               JOIN appointment ON appointment.sid = schedule.s_id 
                               JOIN user ON appointment.pid = user.id 
                               WHERE doctor.email = '$d_email'";
$edit_run_doctor_profile_query = mysqli_query($db, $edit_doctor_profile_query);
while($drow = mysqli_fetch_array($edit_run_doctor_profile_query)) {
    // You can extract doctor's details from $drow here if needed
}
?>

<?php
// Query to get the number of pending appointments
$queryPermission = "WHERE permission='Pending'";
$show_number_pending_request_query = "SELECT * 
                                      FROM doctor 
                                      JOIN schedule ON schedule.d_id = doctor.id 
                                      JOIN appointment ON appointment.sid = schedule.s_id 
                                      JOIN user ON appointment.pid = user.id 
                                      WHERE doctor.email = '$d_email' AND appointment.permission = 'Pending'";
$run = mysqli_query($db, $show_number_pending_request_query);
$count = mysqli_num_rows($run);

// Query to get the number of deleted appointments
$queryPermission = "WHERE permission='Deleted'";
$show_number_deleted_request_query = "SELECT * 
                                      FROM doctor 
                                      JOIN schedule ON schedule.d_id = doctor.id 
                                      JOIN appointment ON appointment.sid = schedule.s_id 
                                      JOIN user ON appointment.pid = user.id 
                                      WHERE doctor.email = '$d_email' AND appointment.permission = 'Deleted'";
$run1 = mysqli_query($db, $show_number_deleted_request_query);
$count1 = mysqli_num_rows($run1);
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#myPage"><strong>e-healthcare</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="view_doctor_profile.php">Profile</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Schedule <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="view_my_schedule.php">My Schedule</a></li>
                        <li><a href="view_consult_hour.php">My Consulting Hour</a></li>
                    </ul>
                </li>
                <li><a href="user_appointment_request.php">Appointment's Request<?php echo ($count > 0) ? ' (' . $count . ')' : ''; ?></a></li>
                <li><a href="deleted_appointment_notification.php"><i class="fa fa-bell"><?php echo ($count1 > 0) ? ' (' . $count1 . ')' : ''; ?></i></a></li>
                <li><a href="../messages/d_message.php"><i class="fa fa-comments"><?php echo ($count1 > 0) ? ' (' . $count1 . ')' : ''; ?></i></a></li>
                <li><a href="doctorlogout.php"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carousel Section -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="../pic/1.jpg" alt="img1" width="1500" height="800" title="Doctor Home Page">
            <div class="carousel-caption">
                <h1><b>Manage Your Appointments, View Requests, and Update Your Schedule</b></h1>
                <p>Everything you need to manage your practice efficiently</p>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button -->
<div class="scroll-to-top-btn" onclick="window.scrollTo(0, 0);">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>&copy; 2025 e-healthcare. All rights reserved. <a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-service.php">Terms of Service</a></p>
</div>

</body>
</html>
