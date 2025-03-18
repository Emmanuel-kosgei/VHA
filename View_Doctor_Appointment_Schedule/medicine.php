<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Appointment Booking</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: #777;
      background-image: url('../pic/1.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      margin: 0;
      padding: 0;
      height: 100vh;
    }

    h1 {
      font-size: 50px;
      text-align: center;
      padding-top: 30px;
      color: #ffffff;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    }

    .container {
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
      margin-top: 30px;
      padding: 30px;
      width: 50%;
    }

    .form-control {
      margin-bottom: 15px;
    }

    .form-group label {
      font-weight: bold;
    }

    .submit-btn {
      background-color: #ffc107;
      color: #fff;
      font-size: 18px;
    }

    .submit-btn:hover {
      background-color: #ff9800;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Book Your Appointment</h1>

    <!-- Appointment Form -->
    <form action="appointment_process.php" method="post">
      
      <!-- Select Doctor -->
      <div class="form-group">
        <label for="doctor">Select Doctor</label>
        <select name="doctor_id" id="doctor" class="form-control" required>
          <option value="">Choose a Doctor</option>
          <?php
            include("../connection.php");

            $query = "SELECT * FROM doctor WHERE permission='approved' AND specialist LIKE 'm%' OR permission='Added' AND specialist LIKE 'm%'";
            $result = mysqli_query($db, $query);
            
            while($row = mysqli_fetch_array($result)) {
              echo "<option value='" . $row['id'] . "'>" . $row['f_name'] . " " . $row['l_name'] . " - " . $row['specialist'] . "</option>";
            }
          ?>
        </select>
      </div>

      <!-- Select Time Slot -->
      <div class="form-group">
        <label for="time_slot">Select Time Slot</label>
        <select name="time_slot" id="time_slot" class="form-control" required>
          <option value="">Choose a Time Slot</option>
          <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
          <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
          <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
          <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
          <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
        </select>
      </div>

      <!-- User Details -->
      <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" name="user_name" id="name" class="form-control" placeholder="Your Full Name" required>
      </div>

      <div class="form-group">
        <label for="contact">Your Contact Number</label>
        <input type="text" name="contact" id="contact" class="form-control" placeholder="Your Contact Number" required>
      </div>

      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Your Email Address" required>
      </div>

      <button type="submit" class="btn btn-lg submit-btn btn-block">Book Appointment</button>
    </form>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>
</html>
