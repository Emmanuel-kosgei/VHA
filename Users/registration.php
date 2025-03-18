<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Aclonica|Roboto" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
        }
        
        .container {
            max-width: 800px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }
        
        .form-title {
            text-align: center;
            font-size: 30px;
            color: #f4511e;
            margin-bottom: 20px;
            font-family: 'Aclonica', sans-serif;
        }
        
        .form-group label {
            font-size: 16px;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .form-group textarea {
            resize: vertical;
            height: 120px;
        }

        .form-group input[type="radio"] {
            margin-right: 10px;
        }

        .btn-custom {
            background-color: #f4511e;
            color: white;
            font-size: 16px;
            width: 100%;
            padding: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-custom:hover {
            background-color: #e43e14;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #f4511e;
            text-decoration: none;
            font-weight: bold;
        }

        .form-footer a:hover {
            color: #e43e14;
        }
        
        .alert {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php 
include("connection.php");

if (isset($_POST["submit"])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];   
    $contact = ($_POST['contact']);
    $address = $_POST['address'];
    $DOB = $_POST['DOB'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $maritialstatus = $_POST['maritialstatus'];
    $pswd = $_POST['pswd'];
    $pswd_len = strlen($pswd);
    $d_date = date("Y/m/d");

    // Validation
    if (empty($f_name)) {
        $error_msg = "Please Enter Your First Name";
    } elseif (empty($l_name)) {
        $error_msg = "Please Enter Your Last Name";
    } elseif (empty($email)) {
        $error_msg = "Please Enter Your Email Address";
    } elseif (empty($contact)) {
        $error_msg = "Please Enter Your Contact Information";
    } elseif (empty($gender)) {
        $error_msg = "Please Select Your Gender";
    } elseif (empty($pswd)) {
        $error_msg = "Please Enter Your Password";
    } elseif ($pswd_len < 8) {
        $error_msg = "Your Password Should Be More Than 8 Characters Long";
    } else {
        // Prepared statement to avoid SQL injection
        $stmt = $db->prepare("INSERT INTO user (f_name, l_name, email, contact, address, DOB, gender, pswd, date) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $f_name, $l_name, $email, $contact, $address, $DOB, $gender, $pswd, $d_date);
        if ($stmt->execute()) {
            $success_msg = "Thank You For Registration";
            echo "<script> window.location='login.php'; </script>";
        } else {
            $error_msg = "Error in registration. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<div class="container">
    <h1 class="form-title">Registration</h1>
    <p class="text-center">Please fill in this form to create an account.</p>
    <hr>

    <?php
    if (isset($error_msg)) {
        echo "<div class='alert alert-danger'>$error_msg</div>";
    }
    if (isset($success_msg)) {
        echo "<div class='alert alert-success'>$success_msg</div>";
    }
    ?>

    <form action="registration.php" method="POST">

        <div class="form-group">
            <label for="f_name"><i class="fa fa-user"></i> First Name: *</label>
            <input type="text" name="f_name" placeholder="Enter Your First Name" required>
        </div>

        <div class="form-group">
            <label for="l_name"><i class="fa fa-user"></i> Last Name: *</label>
            <input type="text" name="l_name" placeholder="Enter Your Last Name" required>
        </div>

        <div class="form-group">
            <label for="email"><i class="fa fa-envelope"></i> Email Address: *</label>
            <input type="email" name="email" placeholder="Enter Your Email Address" required>
        </div>

        <div class="form-group">
            <label for="contact"><i class="fa fa-phone"></i> Contact Number: *</label>
            <input type="text" name="contact" pattern="[0-9]{10}" placeholder="Enter Your Contact Number" required>
        </div>

        <div class="form-group">
            <label for="address"><i class="fa fa-address-book"></i> Address:</label>
            <textarea name="address" placeholder="Enter Your Address"></textarea>
        </div>

        <div class="form-group">
            <label for="DOB"><i class="fa fa-calendar"></i> Date of Birth: *</label>
            <input type="date" name="DOB" required>
        </div>

        <div class="form-group">
            <label><i class="fa fa-user"></i> Gender: *</label><br>
            <input type="radio" name="gender" value="male" required><b> Male</b>
            <input type="radio" name="gender" value="female" required><b> Female</b>
        </div>

        <div class="form-group">
            <label><i class="fa fa-heart"></i> Marital Status:</label><br>
            <input type="radio" name="maritialstatus" value="married"><b> Married</b>
            <input type="radio" name="maritialstatus" value="single"><b> Single</b>
        </div>

        <div class="form-group">
            <label for="pswd"><i class="fa fa-key"></i> Create New Password: *</label>
            <input type="password" name="pswd" placeholder="Create Your Password" required>
            <small>Password should be more than 8 characters long.</small>
        </div>

        <button type="submit" name="submit" class="btn-custom">Register</button>

    </form>

    <div class="form-footer">
        <p>Already a member? <a href="login.php">Login</a></p>
        <p><a href="../index.php">Back</a></p>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
