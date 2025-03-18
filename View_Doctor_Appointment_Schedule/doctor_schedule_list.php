<?php 
include("../connection.php");
include '../translate.php';
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Doctor List</title>

    <style>
        /* General Body Styling */
        body {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../pic/1.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            height: 100vh;
            width: 100%;
            background-attachment: fixed;
        }

        /* Overlay for background image */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Slight overlay to make text more readable */
            z-index: -1;
        }

        /* Heading Style */
        h1 {
            font-size: 50px;
            text-align: center;
            padding-top: 30px;
            color: #004c99; /* Healthcare blue */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Table Style */
        .table {
            margin-top: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* White background for readability */
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Table Header Style */
        .table th {
            background-color: #28a745; /* Healthcare green */
            color: white;
            font-size: 18px;
        }

        .table td {
            font-size: 18px;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1; /* Slight hover effect */
        }

        /* Links Style */
        .table a {
            color: #004c99;
            font-weight: bold;
            text-decoration: none;
        }

        .table a:hover {
            color: #28a745; /* Hover effect to green */
            text-decoration: underline;
        }

        /* Pagination Style */
        .pager {
            text-align: center;
            font-weight: bold;
        }

        .pager li a {
            color: #004c99;
        }

        .pager li a:hover {
            color: #28a745; /* Green color on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .table {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body class="container display-4">

    <h1 class="text-white shadow-lg">All The Doctor's Schedule List</h1>

    <!-- Doctor Schedule Table -->
    <table class="table table-hover table-bordered table-dark">
        <thead>
            <tr>
                <th scope="col" class="text-center">Specialist Name</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center"><a href="medicine.php">Medicine</a></td></tr>
            <tr><td class="text-center"><a href="bone.php">Orthopedic</a></td></tr>
            <tr><td class="text-center"><a href="dentist.php">Dentist</a></td></tr>
            <tr><td class="text-center"><a href="cardiac_electrophysiologist.php">Cardiac Electrophysiologist</a></td></tr>
            <tr><td class="text-center"><a href="cardiologist.php">Cardiologist</a></td></tr>
            <tr><td class="text-center"><a href="surgeon.php">Surgeon</a></td></tr>
            <tr><td class="text-center"><a href="gynecologist.php">Gynecologist</a></td></tr>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="container">
        <ul class="pager">
            <li class="previous"><a href="../Users/view_user_home_page.php">Previous</a></li>
            <li class="next"><a href="../Users/view_users_appointment.php">Next</a></li>
        </ul>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>
</html>
