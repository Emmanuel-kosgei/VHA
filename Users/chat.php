<?php
include "connection.php"; // Database connection

// Fetch available doctors from the database
$query = "SELECT * FROM doctor WHERE available = 1";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Chat</title>
    <link href="https://fonts.googleapis.com/css?family=Aclonica" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            margin: 0;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .doctor-list {
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
        }

        .doctor-profile {
            display: flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
        }

        .doctor-profile:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #f9f9f9;
        }

        .doctor-profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .doctor-info {
            flex-grow: 1;
        }

        .doctor-info h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .doctor-info p {
            margin: 5px 0;
            color: #777;
        }

        .doctor-profile button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .doctor-profile button:hover {
            background-color: #45a049;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .doctor-profile {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<h1>Doctor Chat</h1>

<div class="doctor-list">
    <?php while ($doctor = mysqli_fetch_assoc($result)) : ?>
        <div class="doctor-profile">
            <img src="doctor_profile_pic.jpg" alt="Doctor Profile"> <!-- Placeholder for doctor's image -->
            <div class="doctor-info">
                <h3><?= $doctor['f_name'] . " " . $doctor['l_name']; ?></h3>
                <p><?= $doctor['specialist']; ?></p>
            </div>
            <a href="text.php?sid=<?= $doctor['id']; ?>&pid=<?= $_SESSION['pid']; ?>"> <!-- Redirect to chat page -->
                <button>Start Chat</button>
            </a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
