<?php
// Start the session
session_start();
include("connection.php");  // Include your database connection file

// Ensure that the doctor is logged in
if(!isset($_SESSION['email'])) {
    header("Location: doctorlogin.php"); // Redirect to login page if not logged in
    exit();
}

// Get the doctor's email
$doctor_email = $_SESSION['email'];

// Handle form submission to save medicine description
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $medicine_name = $_POST['medicine_name'];
    $medicine_description = $_POST['medicine_description'];

    // Insert the description into the database
    $query = "INSERT INTO medicine_prescription (doctor_email, patient_id, medicine_name, description) 
              VALUES ('$doctor_email', '$patient_id', '$medicine_name', '$medicine_description')";
    $result = mysqli_query($db, $query);

    if ($result) {
        $success_msg = "Prescription successfully added.";
    } else {
        $error_msg = "Error: Could not add the prescription.";
    }
}

// Query to get all patients (no filtering by doctor)
$query_patients = "SELECT id, f_name, l_name FROM user"; // Fetch all patients
$patients_result = mysqli_query($db, $query_patients);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Prescription</title>

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
            height: 100vh;
            margin-top: 20%;
            margin-bottom: 20%;

        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #1abc9c;
            border: none;
        }

        .btn-primary:hover {
            background-color: #16a085;
        }

        .alert {
            margin-top: 20px;
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
                <li><a href="view_doctor_profile.php">Profile</a></li>
                <li><a href="view_my_schedule.php">My Schedule</a></li>
                <li><a href="doctorlogout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Write Prescription</h2>
        <hr>

        <!-- Display success or error message -->
        <?php if (isset($success_msg)) { ?>
            <div class="alert alert-success">
                <?php echo $success_msg; ?>
            </div>
        <?php } elseif (isset($error_msg)) { ?>
            <div class="alert alert-danger">
                <?php echo $error_msg; ?>
            </div>
        <?php } ?>

        <!-- Prescription Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="patient_id">Select Patient</label>
                <select class="form-control" name="patient_id" required>
                    <option value="">Select Patient</option>
                    <?php while ($patient = mysqli_fetch_assoc($patients_result)) { ?>
                        <option value="<?php echo $patient['id']; ?>"><?php echo $patient['f_name'] . ' ' . $patient['l_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="medicine_name">Medicine Name</label>
                <input type="text" class="form-control" name="medicine_name" required>
            </div>

            <div class="form-group">
                <label for="medicine_description">Medicine Description</label>
                <textarea class="form-control" name="medicine_description" rows="5" required></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Save Prescription</button>
        </form>
    </div>

    <!-- Footer Section -->
    <div class="footer" style="background-color: #2c3e50; color: white; text-align: center; padding: 10px 0; position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2025 e-healthcare. All rights reserved.</p>
    </div>
</body>
</html>
