<?php
session_start();
include("connection.php");
include '../translate.php';
$d_email = $_SESSION['email'];
$show_schedule = "SELECT * 
                  FROM doctor INNER JOIN schedule ON schedule.d_id = doctor.id 
                  WHERE email='$d_email'";

$show_schedule_query = mysqli_query($db, $show_schedule);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule Updating</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Aclonica" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            color: #777;
            background-image: url('../pic/Doctor_Time.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .w3-card-4 {
            margin-top: 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        h3 {
            color: #fff;
        }

        .pager a {
            color: #dc3545;
            font-weight: bold;
        }

        .pager a:hover {
            text-decoration: underline;
        }

        .schedule-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
        }

        .schedule-item {
            margin: 10px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            .container {
                padding: 15px;
            }

            .w3-card-4 {
                margin-top: 10px;
            }

            .schedule-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="w3-card-4 w3-margin w3-black">
        <div class="w3-container">
            <h1 class="text-center font-weight-bold">My Schedule Time</h1>
            <hr>

            <?php while ($drow = mysqli_fetch_array($show_schedule_query)) { ?>
                <div class="schedule-container">
                    <h3 class="text-center">Name: <?php echo $drow['f_name'] . ' ' . $drow['l_name']; ?> - Specialist in <?php echo $drow['specialist']; ?></h3>
                    <hr>

                    <?php
                    for ($i = 1; $i <= 7; $i++) {
                        if (!empty($drow["Day_Time" . $i])) {
                            echo "<h3 class='schedule-item text-center'>" . $drow["Day_Time" . $i] . "</h3>";
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <div class="text-center">
                <ul class="pager">
                    <li><a href="doctor_appointment_schedule_updating.php">Update Appointment Schedule</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
