<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-image: url(../pic/Doctor_Time.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.7); /* semi-transparent black */
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }

        .login-container h1 {
            text-align: center;
            font-size: 30px;
            color: #f4511e;
            margin-bottom: 30px;
        }

        .form-group label {
            font-size: 16px;
            color: #ddd;
        }

        .form-group input {
            font-size: 16px;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #f4511e;
            color: #fff;
            padding: 12px;
            font-size: 18px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-custom:hover {
            background-color: #e43e14;
        }

        .footer-links {
            text-align: center;
            margin-top: 20px;
        }

        .footer-links a {
            color: #f4511e;
            text-decoration: none;
            font-size: 16px;
        }

        .footer-links a:hover {
            color: #e43e14;
        }

        .alert {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
        }

        .alert-danger {
            color: #dc3545;
        }

        .alert-success {
            color: #28a745;
        }
    </style>
</head>
<body>

<?php
error_reporting(0);
session_start();
include("connection.php");
include ('../translate.php');

if (isset($_POST['submit'])) {
    $pswd = $_POST['pswd'];
    $email = $_POST['email'];

    if (empty($email) || empty($pswd)) {
        $error_msg = "Please fill in all the fields.";
    } else {
        // Query to check if the doctor exists and has a valid permission status
        $u_query = "SELECT * FROM doctor WHERE email='$email' AND pswd='$pswd' AND (permission='Approved' OR permission='Added')";
        $check = mysqli_query($db, $u_query);

        // Check if there is a matching doctor and their status is 'Approved' or 'Added'
        if (mysqli_num_rows($check) > 0) {
            $check_row = mysqli_fetch_assoc($check);
            $_SESSION['email'] = $check_row['email']; // Store session data (email of the doctor)
            $_SESSION['id'] = $check_row['id']; // Store session data (ID of the doctor)
            
            // Redirect doctor to the home page
            echo "<script> window.location='doctor_home_page.php'; </script>";
            exit(); // Ensure that the script stops executing after redirection
        } else {
            // Invalid login attempt (incorrect credentials or unapproved user)
            $invalid_msg = "Invalid email or password, or your account is not approved yet.";
        }
    }
}
?>

<!-- Login Form -->
<div class="login-container">
    <h1>Doctor Login</h1>
    
    <form action="doctor_login.php" method="post">
        <div class="form-group">
            <label for="email"><b>Email</b></label>
            <input type="text" class="form-control" placeholder="Enter e-mail" name="email" required>
        </div>

        <div class="form-group">
            <label for="pswd"><b>Password</b></label>
            <input type="password" class="form-control" placeholder="Enter Password" name="pswd" required>
        </div>

        <button type="submit" name="submit" value="login" class="btn-custom">Login</button>
    </form>

    <!-- Display error message if credentials are invalid or unapproved -->
    <?php
    if (isset($error_msg)) {
        echo "<div class='alert alert-danger'>$error_msg</div>";
    }
    if (isset($invalid_msg)) {
        echo "<div class='alert alert-danger'>$invalid_msg</div>";
    }
    ?>

    <div class="footer-links">
        <p>Not yet a member? <a href="doctor_registration.php"><strong>Register</strong></a></p>
        <p><a href="../index.php"><strong>Back to Home Page</strong></a></p>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
