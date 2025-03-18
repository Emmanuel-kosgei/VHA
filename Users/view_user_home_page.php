<?php
// Start the session
session_start();
include("connection.php");  // Include your database connection file

// Ensure that the user is logged in
if(!isset($_SESSION['email'])) {
    header("Location: userlogin.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user's email and id
$user_email = $_SESSION['email'];

// Query to get the user’s id based on their email
$query_user_id = "SELECT id FROM user WHERE email = '$user_email'";
$user_result = mysqli_query($db, $query_user_id);
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

// Query to get the number of unread prescriptions for the logged-in user
$query_unread_count = "SELECT COUNT(*) AS unread_count FROM medicine_prescription WHERE patient_id = '$user_id' AND status = 'unread'";
$result_unread_count = mysqli_query($db, $query_unread_count);
$unread_count = mysqli_fetch_assoc($result_unread_count)['unread_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Home Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ececec;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
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

        /* Carousel Section */
        .carousel-inner img {
            width: 100%;
            height: auto;
            filter: grayscale(80%);
        }

        /* Profile Card Styling */
        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 70%;
            max-width: 500px;
            margin-top: 50px;
            color: #333;
        }

        .profile-card h1 {
            font-size: 36px;
            color: #3a5a7b;
        }

        .profile-card h2 {
            font-size: 24px;
            color: #16a085;
        }

        .profile-card p {
            font-size: 18px;
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

        /* Navbar Header Styling */
        .navbar-header a {
            font-size: 1.8em;
            color: #d5d5d5;
        }

        /* Mobile-friendly styling */
        .navbar-nav li a {
            font-size: 14px;
        }

        /* Profile Card Adjustments for Smaller Screens */
        @media (max-width: 768px) {
            .profile-card {
                width: 90%;
                padding: 20px;
            }

            .carousel-inner img {
                max-height: 300px;
            }

            .footer {
                font-size: 12px;
            }

            .navbar-header a {
                font-size: 1.5em;
            }

            .navbar-nav li a {
                font-size: 12px;
            }

            /* Adjust search form on smaller screens */
            .navbar-nav form {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
            }

            .navbar-nav input[type="text"] {
                margin: 5px 0;
                width: 80%;
                padding: 5px;
            }

            .navbar-nav input[type="submit"] {
                margin-top: 10px;
                width: 80%;
                padding: 5px;
            }
        }
    </style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<!-- User Profile and Navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand text-dark" href="#myPage"><strong>VHA</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href='profile.php'>Profile</a></li>
                <li><a href="../disease_prediction.php">Suggest Doctor</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#Appointment">Appointments <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../View_Doctor_Appointment_Schedule/medicine.php">Booking Appointment</a></li>
                        <li><a href="view_users_appointment.php">My Appointments</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#Consulting">Consulting <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../view_consulting_hour/doctor_schedule_list.php">Consulting Hour</a></li>
                        <li><a href="chat.php">Doctor-Patient Chat</a></li>
                    </ul>
                </li>
                <!-- Prescription Notification Icon -->
                <li><a href="view_prescription.php">Prescriptions<i class="fa fa-bell"><span style="color:red"><?php if($unread_count > 0) echo ' (' . $unread_count . ')'; ?></span></i></a></li>

                <li>
                    <form action="../search.php" method="POST">
                        <input type="text" name="f_name" placeholder="Search By Doctor Name..." />
                        <input type="submit" name="search" value="GO" />
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carousel Section -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="../pic/1.jpg" alt="img1" width="1500" height="800" title="User Home Page">
            <div class="w3-display-middle w3-margin-top w3-center">
                <!-- Profile Section -->
                <div class="profile-card">
                    <h1>Welcome Again!<h2> <?php echo $l_name; ?></h2></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>&copy; 2025 Virtual healthcare Assistant. All rights reserved. <a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-service.php">Terms of Service</a></p>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
