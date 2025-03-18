<?php
session_start();
include("../connection.php");

// Get the doctor's email from session
$d_email = $_SESSION['email'];

// Query to get all appointments for the doctor
$query = "SELECT * FROM appointments 
          WHERE doctor_id IN (SELECT id FROM doctor WHERE email = '$d_email')";

$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appointment Requests</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: url('../pic/1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-size: 2.5rem;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 90%;
            max-width: 1200px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table td {
            background-color: #ffffff;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .status-column {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .status-column.approved {
            background-color: #28a745;
            color: white;
        }

        .status-column.cancelled {
            background-color: #dc3545;
            color: white;
        }

        .status-column.pending {
            background-color: #ffc107;
            color: black;
        }

        .icon-btn {
            font-size: 1.5em;
            cursor: pointer;
            margin: 0 10px;
        }

        .icon-btn:hover {
            opacity: 0.7;
        }

        .icon-btn.approve {
            color: #28a745; /* Green for approve */
        }

        .icon-btn.cancel {
            color: #dc3545; /* Red for cancel */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
                text-align: center;
            }

            .container {
                padding: 20px;
                width: 100%;
            }

            .table th, .table td {
                font-size: 0.9rem;
            }

            .icon-btn {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">View Appointment Requests</h1>

    <form action="user_appointment_request.php" method="POST">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Time Slot</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Approve</th>
                <th>Cancel</th>
            </tr>
            </thead>
            <tbody>

            <?php
            // Check if query returns any results
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr id="appointment-<?php echo $row['appointment_id']; ?>">
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['time_slot']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td id="status-<?php echo $row['appointment_id']; ?>" 
                            class="status-column <?php echo strtolower($row['permission']); ?>">
                            <?php echo $row['permission']; ?>
                        </td>
                        <td>
                            <?php if ($row['permission'] != 'Approved') { ?>
                                <!-- Approve Button as Green Tick Icon -->
                                <i class="fa fa-check icon-btn approve" data-id="<?php echo $row['appointment_id']; ?>"></i>
                            <?php } else { ?>
                                <span>Approved</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['permission'] != 'Cancelled') { ?>
                                <!-- Cancel Button as Red Cross Icon -->
                                <i class="fa fa-times icon-btn cancel" data-id="<?php echo $row['appointment_id']; ?>"></i>
                            <?php } else { ?>
                                <span>Cancelled</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php 
                }
            } else {
                echo "<tr><td colspan='8'>No appointments available.</td></tr>";
            }
            ?>

            </tbody>
        </table>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        // Approve button click
        $(".approve").click(function(){
            var appointment_id = $(this).data("id");

            $.ajax({
                url: 'approve_cancel.php',
                type: 'GET',
                data: { action: 'approve', appointment_id: appointment_id },
                success: function(response) {
                    if(response == 'success') {
                        // Update status in the table
                        $("#status-" + appointment_id).text('Approved').removeClass().addClass('status-column approved');
                        // Hide the approve and cancel buttons
                        $("#appointment-" + appointment_id + " .approve").hide();
                        $("#appointment-" + appointment_id + " .cancel").hide();
                    }
                }
            });
        });

        // Cancel button click
        $(".cancel").click(function(){
            var appointment_id = $(this).data("id");

            $.ajax({
                url: 'approve_cancel.php',
                type: 'GET',
                data: { action: 'cancel', appointment_id: appointment_id },
                success: function(response) {
                    if(response == 'success') {
                        // Update status in the table
                        $("#status-" + appointment_id).text('Cancelled').removeClass().addClass('status-column cancelled');
                        // Hide the approve and cancel buttons
                        $("#appointment-" + appointment_id + " .approve").hide();
                        $("#appointment-" + appointment_id + " .cancel").hide();
                    }
                }
            });
        });
    });
</script>

</body>
</html>
