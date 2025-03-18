<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users Appointment</title>
    
    <!-- Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-image: url('../pic/1.jpg');
            background-size: cover;
            color: #777;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 50px;
            text-align: center;
            color: #000066;
            padding-top: 30px;
        }
        h3 {
            font-size: 24px;
            letter-spacing: 4px;
        }
        .appointment-table {
            width: 100%;
            margin-top: 30px;
        }
        .appointment-table th, .appointment-table td {
            text-align: center;
            padding: 15px;
        }
        .appointment-table thead {
            background-color: #343a40;
            color: #fff;
        }
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        .form-group {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group input[type="id"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .page-navigation {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-white shadow-lg">All The Appointments</h1>
        
        <!-- Appointment Table Form -->
        <form action="view_users_appointment.php" method="POST" class="appointment-form">
            <div class="form-group">
                <h3 class="active font-weight-bold text-warning">
                    Enter Your ID: 
                    <input type="id" name="id" placeholder="Enter Your ID" class="form-control text-center" required />
                </h3>
            </div>

            <table class="table table-hover appointment-table">
                <thead>
                    <tr>
                        <th><h3>Appointment To</h3></th>
                        <th><h3>Appointment Date</h3></th>
                        <th><h3>Appointment Time</h3></th>
                        <th><h3>Status</h3></th>
                        <th><h3>Cancel Booking</h3></th>
                    </tr>
                </thead>

                <?php
                session_start();
                include("connection.php");

                $email = $_SESSION['email'];

                // Fetch user ID
                $doctor_sid_show_squery = "SELECT * FROM user WHERE email='$email'";
                $doctor_sid_squery = mysqli_query($db, $doctor_sid_show_squery);
                while($d_s_row = mysqli_fetch_array($doctor_sid_squery)) {
                    echo "<h3 class='active font-weight-bold text-warning'>Enter Your ID: " . $d_s_row['id'] . "</h3><hr>";
                }

                // Handle form submission
                if (isset($_POST["submit1"])) {
                    $check = $_POST["check"];
                    $save = implode(",", $check);

                    // Prepared statement to delete selected appointments
                    $update_doctor_schedule_query = "UPDATE doctor
                                                      INNER JOIN schedule ON schedule.d_id = doctor.id
                                                      INNER JOIN appointment ON appointment.sid = schedule.s_id
                                                      INNER JOIN user ON appointment.pid = user.id
                                                      SET appointment.permission = 'Deleted'
                                                      WHERE appointment.sid IN ($save) AND user.email = '$email'";

                    if (mysqli_query($db, $update_doctor_schedule_query)) {
                        echo "<script>alert('Successfully Deleted');</script>";
                    } else {
                        echo "<script>alert('Error: Could not delete the appointment.');</script>";
                    }
                }

                // Fetch appointments
                $edit_doctor_profile_query = "SELECT schedule.s_id, doctor.f_name, doctor.l_name, appointment.booking_date, 
                                              appointment.booking_time, appointment.permission, appointment.sid AS asid 
                                              FROM doctor 
                                              JOIN schedule ON schedule.d_id = doctor.id 
                                              JOIN appointment ON appointment.sid = schedule.s_id  
                                              JOIN user ON appointment.pid = user.id 
                                              WHERE user.email = '$email' 
                                              AND (appointment.permission = 'Approved' OR appointment.permission = 'Pending')";

                $edit_run_doctor_profile_query = mysqli_query($db, $edit_doctor_profile_query);
                while($drow = mysqli_fetch_array($edit_run_doctor_profile_query)) {
                    ?>
                    <tr>
                        <td><h3><a href="../Admin/detail.php?s_id=<?php echo $drow['s_id']; ?>"><?php echo $drow['f_name'] . " " . $drow['l_name']; ?></a></h3></td>
                        <td><h3><?php echo $drow['booking_date']; ?></h3></td>
                        <td><h3><?php echo $drow['booking_time']; ?></h3></td>
                        <td><h3><?php echo $drow['permission']; ?></h3></td>
                        <td><input type="checkbox" name="check[]" value="<?php echo $drow['asid']; ?>"></td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <div class="form-group">
                <input class="btn btn-danger" type="submit" value="Cancel Booking" name="submit1">
            </div>

        </form>

        <div class="page-navigation">
            <ul class="pager font-weight-bold text-monospace">
                <li class="previous"><a href="view_user_home_page.php">Previous</a></li>
                <li class="next"><a href="accept_appointment.php">Next</a></li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>
