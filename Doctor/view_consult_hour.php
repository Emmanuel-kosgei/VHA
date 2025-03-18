<?php
session_start();
include("connection.php");
include '../translate.php';
$d_email = $_SESSION['email'];
$show_schedule = "SELECT * 
                  FROM doctor 
                  INNER JOIN consulting_schedule ON consulting_schedule.d_id = doctor.id 
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
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            color: #333;
            background-image: url('../pic/Doctor_Time.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* Overlay for background image */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark overlay */
            z-index: -1;
        }

        .container {
            padding: 20px;
        }

        .w3-card-4 {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Light background for readability */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: #004c99; /* Healthcare blue */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h3 {
            color: #333;
            margin: 10px 0;
            font-size: 1.2rem;
        }

        .schedule-item {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
        }

        .pager a {
            color: #28a745; /* Healthcare green */
            font-weight: bold;
            text-decoration: underline;
        }

        .pager a:hover {
            color: #218838;
        }

        .schedule-container {
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #004c99; /* Healthcare blue */
            text-decoration: none;
        }

        .footer a:hover {
            color: #218838;
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
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="w3-card-4 w3-margin w3-white">
        <div class="w3-container">
            <h1 class="font-weight-bold">My Schedule Time</h1>
            <hr>

            <?php while ($drow = mysqli_fetch_array($show_schedule_query)) { ?>
                <div class="schedule-container">
                    <h3>Name: <?php echo $drow['f_name'] . ' ' . $drow['l_name']; ?> - Specialist in <?php echo $drow['specialist']; ?></h3>

                    <?php
                    for ($i = 1; $i <= 7; $i++) {
                        if (!empty($drow["Day_Time" . $i])) {
                            echo "<h3 class='schedule-item'>" . $drow["Day_Time" . $i] . "</h3>";
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <div class="text-center">
                <ul class="pager">
                    <li><a href="updating_consulting_hour.php">Update Consulting Hour</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2025 Healthcare System. All rights reserved.</p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
