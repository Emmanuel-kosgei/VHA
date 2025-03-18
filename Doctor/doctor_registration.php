<?php 
include("connection.php");

if (isset($_POST["submit"])) {
    // Get form input data
    $d_id = $_POST['id'];
    $d_f_name = $_POST['f_name'];
    $d_l_name = $_POST['l_name'];
    $d_email = $_POST['email'];   
    $d_contact = ($_POST['contact']);
    $d_specialist = ($_POST['specialist']);
    $d_qualification = ($_POST['qualification']);
    $d_DOB = $_POST['DOB'];
    $d_age = $_POST['age'];
    $d_gender = $_POST['gender'];
    $d_address = $_POST['address'];
    $d_bmdc_reg_num = $_POST['bmdc_reg_num'];
    $d_pswd = $_POST['pswd'];
    $d_pswd_len = strlen($d_pswd);
    $d_date = date("Y-m-d");

    // Form validation
    if (empty($d_f_name)) {
        $error_msg = "Please Enter Your First Name";
    } elseif (empty($d_l_name)) {
        $error_msg = "Please Enter Your Last Name";
    } elseif (empty($d_email)) {
        $error_msg = "Please Enter Your Email Address";
    } elseif (!filter_var($d_email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Please Enter A Valid Email Address";
    } elseif (empty($d_contact)) {
        $error_msg = "Please Enter Your Contact Information";
    } elseif (empty($d_specialist)) {
        $error_msg = "Please Enter Your Specialism";
    } elseif (empty($d_qualification)) {
        $error_msg = "Please Enter Your Qualification Section";
    } elseif (empty($d_DOB)) {
        $error_msg = "Please Enter Your Date of Birth (DOB)";
    } elseif (empty($d_gender)) {
        $error_msg = "Please Select Your Gender";
    } elseif (empty($d_bmdc_reg_num)) {
        $error_msg = "Please Provide Your BMDC Registration Number";
    } elseif (!filter_var($d_bmdc_reg_num, FILTER_VALIDATE_INT)) {
        $error_msg = "Please Enter A Valid BMDC Registration Number";
    } elseif (empty($d_pswd)) {
        $error_msg = "Please Enter Your Password";
    } elseif ($d_pswd_len <= 8) {
        $error_msg = "Your Password Should Be More Than 8 Characters Long";
    } else {
        // SQL query to insert doctor registration data into the database
        $d_query = "INSERT INTO doctor(f_name, l_name, email, contact, specialist, qualification, DOB, gender, address, bmdc_reg_num, pswd, date, permission) 
                    VALUES('$d_f_name', '$d_l_name', '$d_email', '$d_contact', '$d_specialist', '$d_qualification', '$d_DOB', '$d_gender', '$d_address', '$d_bmdc_reg_num', '$d_pswd', '$d_date', 'Pending')";
        
        // Execute query and check for success
        if (mysqli_query($db, $d_query)) {
            $success_msg = "Thank You For Registration. Please Wait For Admin's Approval";
        } else {
            $error_msg = "Error: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Aclonica|Open+Sans&display=swap" rel="stylesheet">
  <title>Doctor Registration</title>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f4f9fc;
      color: #333;
    }
    .navbar {
      background-color: #1e3a8a;
	  border-radius: 5px;
	  height: 10vh;
	  text-align: center;
    }
	.navbar a{
		font-size: 40px;
	}
	.container{
		margin: auto;
		width: 60%;;
	}
    .navbar-brand {
      color: white;
      font-weight: bold;
    }
    .form-container {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 40px;
      margin-top: 50px;
    }
    .form-container h1 {
      color: #1e3a8a;
      font-size: 30px;
      margin-bottom: 20px;
    }
    .form-container label {
      color: #555;
      font-weight: 600;
    }
    .form-container input, .form-container select, .form-container textarea {
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
      width: 100%;
      margin-bottom: 15px;
      font-size: 16px;
    }
    .form-container input[type="submit"] {
      background-color: #1e3a8a;
      color: white;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }
    .form-container input[type="submit"]:hover {
      background-color: #3b6bbf;
    }
    .form-container .form-check-label {
      font-weight: 500;
    }
    .alert {
      text-align: center;
      font-size: 16px;
    }
    .footer {
      background-color: #1e3a8a;
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: 40px;
    }
    .footer a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="#">HealthCare Registration</a>
</div>

<div class="container form-container">
  <h1><strong>Doctor Registration</strong></h1>
  <p><strong>Please fill in this form to create an account.</strong></p>

  <?php 
    if (isset($error_msg)) {
      echo '<div class="alert alert-danger">' . $error_msg . '</div>';
    }
    if (isset($success_msg)) {
      echo '<div class="alert alert-success">' . $success_msg . '</div>';
    }
  ?>

  <form action="doctor_registration.php" method="POST">
    <div class="form-group">
      <label for="f_name"><i class="fa fa-user"></i> First Name:</label>
      <input type="text" class="form-control" placeholder="Enter Your First Name" name="f_name" required>
    </div>
    <div class="form-group">
      <label for="l_name"><i class="fa fa-user"></i> Last Name:</label>
      <input type="text" class="form-control" placeholder="Enter Your Last Name" name="l_name" required>
    </div>
    <div class="form-group">
      <label for="email"><i class="fa fa-envelope"></i> Email Address:</label>
      <input type="email" class="form-control" placeholder="Enter Your Email Address" name="email" required>
    </div>
    <div class="form-group">
      <label for="contact"><i class="fa fa-phone"></i> Contact Number:</label>
      <input type="tel" class="form-control" placeholder="Enter Your Contact Number" name="contact" pattern="[0-9]{11}" required>
    </div>
    <div class="form-group">
      <label for="specialist"><i class="fa fa-stethoscope"></i> Specialist:</label>
      <select name="specialist" class="form-control" required>
        <option value="Orthopedic">Orthopedic</option>
        <option value="Gynecologist">Gynecologist</option>
        <option value="Dentist">Dentist</option>
        <option value="Medicine">Medicine</option>
        <option value="Cardiologist">Cardiologist</option>
        <option value="Cardiac Electrophysiologist">Cardiac Electrophysiologist</option>
        <option value="Surgeon">Surgeon</option>
      </select>
    </div>
    <div class="form-group">
      <label for="qualification"><i class="fa fa-graduation-cap"></i> Qualification:</label>
      <input type="text" class="form-control" placeholder="Enter Your Qualification" name="qualification" required>
    </div>
    <div class="form-group">
      <label for="DOB"><i class="fa fa-calendar"></i> Date of Birth:</label>
      <input type="date" class="form-control" name="DOB" required>
    </div>
    <div class="form-group">
      <label><i class="fa fa-venus-mars"></i> Gender:</label><br>
      Male<input type="radio" name="gender" value="male" required> 
      Female<input type="radio" name="gender" value="female" required> 
    </div>
    <div class="form-group">
      <label for="address"><i class="fa fa-building"></i> Hospital/Clinic Address:</label>
      <input type="text" class="form-control" placeholder="Enter Clinic/Hospital Address" name="address" required>
    </div>
    <div class="form-group">
      <label for="bmdc_reg_num"><i class="fa fa-id-card"></i> BMDC Registration Number:</label>
      <input type="number" class="form-control" placeholder="Enter Your Registration Number" name="bmdc_reg_num" required>
      <small class="form-text text-muted">Only input numeric values (without the prefix "A-" like 1, 2, 3).</small>
    </div>
    <div class="form-group">
      <label for="pswd"><i class="fa fa-key"></i> Create Password:</label>
      <input type="password" class="form-control" placeholder="Create Your Password" name="pswd" required>
      <small class="form-text text-muted">Password should be at least 8 characters long.</small>
    </div>
    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Register">
  </form>
  <p class="mt-3 text-center"><strong>Already a member? <a href="doctor_login.php">Login</a></strong></p>
  <p class="text-center"><a href="../index.php">Back</a></p>
</div>

<div class="footer">
  <p>&copy; 2025 HealthCare System. All rights reserved.</p>
</div>

</body>
</html>
