<?php
session_start();
include("connection.php");
?>
<?php
// Ada Health API credentials
$apiKey = 'YOUR_ADA_API_KEY';  // Replace with your Ada API Key
$apiUrl = 'https://api.ada.com/v1/diagnoses';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptoms = $_POST['symptoms'];

    // Prepare the data for the API request
    $data = [
        "symptoms" => $symptoms
    ];

    // Headers for the API request
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ];

    // Initialize cURL to send POST request to Ada Health API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the request and get the response
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Error handling in case the API fails
    if (isset($responseData['error'])) {
        echo "Error: " . $responseData['error'];
    } else {
        // Process the response and display the results
        $conditions = $responseData['diagnoses'];
        $resultMessage = '';

        foreach ($conditions as $condition) {
            $resultMessage .= "<p><strong>Condition:</strong> {$condition['name']} - Likelihood: {$condition['likelihood']}%</p>";
            $resultMessage .= "<p><strong>Description:</strong> {$condition['description']}</p>";
            $resultMessage .= "<hr>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Symptom Checker</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Aclonica" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font: 400 15px/1.8 Lato, sans-serif;
            color: #555;
            background-color: #f2f9fc;
        }

        .navbar {
            background-color: #009688;
            border: 0;
            font-size: 16px !important;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .navbar a {
            color: #fff !important;
        }

        .navbar-nav li a:hover {
            color: #fff !important;
            background-color: #00796b !important;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #009688;
            font-weight: 700;
            text-align: center;
        }

        .form-group input, .form-group textarea {
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .form-group input[type="submit"] {
            background-color: #009688;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            width: auto;
            margin-top: 10px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #00796b;
        }

        .result {
            background-color: #f1f8f7;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 30px;
        }

        .result h4 {
            color: #00796b;
            font-weight: 700;
        }

        .result p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand text-dark" href="#myPage"><strong>e-healthcare</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="disease_prediction.php">Suggest Doctor</a></li>
                <li><a href="view_users_appointment.php">Appointments</a></li>
                <li><a href="consultation.php">Consultation</a></li>
                <li><a href="userlogout.php"><i class="fa fa-sign-out"></i></a></li>
                <li><a href="symptom_checker.php">Check Symptoms</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main content -->
<div class="container">
    <h2>Symptom Checker</h2>
    <form action="symptom_checker.php" method="POST">
        <div class="form-group">
            <label for="symptoms">Enter Your Symptoms:</label>
            <textarea id="symptoms" name="symptoms" rows="5" placeholder="Describe your symptoms here..." required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Check Symptoms">
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($resultMessage)) {
        echo "
            <div class='result'>
                <h4>Symptom Analysis:</h4>
                $resultMessage
            </div>
        ";
    }
    ?>

</div>

<!-- Include JavaScript libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
