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

// If the "Mark as Read" button is clicked, update the status in the database
if (isset($_GET['mark_read_id'])) {
    $prescription_id = $_GET['mark_read_id'];

    // Update the status of the prescription to 'read'
    $query_update_status = "UPDATE medicine_prescription SET status = 'read' WHERE id = '$prescription_id' AND patient_id = '$user_id'";
    mysqli_query($db, $query_update_status);
}

// Query to get prescriptions for the logged-in user
$query_prescriptions = "
    SELECT mp.id, mp.medicine_name, mp.description, d.f_name AS doctor_first_name, d.l_name AS doctor_last_name, mp.status
    FROM medicine_prescription mp
    JOIN doctor d ON d.email = mp.doctor_email
    WHERE mp.patient_id = '$user_id'
";
$prescriptions_result = mysqli_query($db, $query_prescriptions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Prescriptions</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

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

        .container {
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin-top: 20%;
        }

        .prescription-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .prescription-card h3 {
            color: #2d3e50;
        }

        .btn-primary {
            background-color: #1abc9c;
            border: none;
        }

        .btn-primary:hover {
            background-color: #16a085;
        }

        .btn-mark-read {
            background-color: #1abc9c;
            color: white;
        }

        .btn-mark-read:hover {
            background-color: #16a085;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">e-healthcare</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="user_profile.php">Profile</a></li>
                <li><a href="user_logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Your Prescriptions</h2>
        <hr>

        <?php
        // Check if the user has any prescriptions
        if (mysqli_num_rows($prescriptions_result) > 0) {
            // Loop through each prescription and display
            while ($prescription = mysqli_fetch_assoc($prescriptions_result)) {
        ?>
                <div class="prescription-card">
                    <h3>Medicine Name: <?php echo $prescription['medicine_name']; ?></h3>
                    <p><strong>Prescribed by:</strong> Dr. <?php echo $prescription['doctor_first_name'] . ' ' . $prescription['doctor_last_name']; ?></p>
                    <p><strong>Description:</strong> <?php echo $prescription['description']; ?></p>
                    <!-- Mark as Read Button -->
                    <?php if ($prescription['status'] == 'unread') { ?>
                        <a href="view_prescription.php?mark_read_id=<?php echo $prescription['id']; ?>" class="btn btn-mark-read">Mark as Read</a>
                    <?php } else { ?>
                        <span class="label label-success">Read</span>
                    <?php } ?>
                </div>
        <?php
            }
        } else {
            // No prescriptions found
            echo "<p>You have no prescriptions at the moment.</p>";
        }
        ?>
    </div>

    <!-- Footer Section -->
    <div class="footer" style="background-color: #2c3e50; color: white; text-align: center; padding: 10px 0; position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2025 e-healthcare. All rights reserved.</p>
    </div>
</body>
</html>
