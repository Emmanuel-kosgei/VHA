<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>

    <!-- Bootstrap v4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- W3.CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        /* Basic Styling */
        body {
            font-family: 'Lato', sans-serif;
            color: #555;
            background-image: url(../pic/1.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        h1, h3 {
            font-family: 'Montserrat', sans-serif;
        }

        .w3-card-4 {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin-top: 100px;
            transition: transform 0.3s ease;
        }

        .w3-card-4:hover {
            transform: translateY(-10px);
        }

        h1 {
            font-size: 50px;
            text-align: center;
            color: #007BFF;
        }

        h3 {
            font-size: 18px;
            line-height: 1.8;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
        }

        .profile-link {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .profile-link:hover {
            text-decoration: underline;
        }

        .pager li a {
            font-weight: bold;
            color: #007BFF;
            text-transform: uppercase;
        }

        .pager li a:hover {
            color: #0056b3;
        }

        /* Button Style */
        .btn-custom {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .btn-custom:focus {
            outline: none;
            box-shadow: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 40px;
            }

            .container {
                padding: 20px;
            }

            .w3-card-4 {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="w3-card-4">
            <div class="w3-container">
                <h1 class="text-center font-weight-bold text-primary">Personal Profile</h1>
                <hr>

                <h3>
                    <?php
                    session_start();
                    include("connection.php");
                    include '../translate.php';

                    if (!isset($_SESSION['email'])) {
                        // Redirect to login if session doesn't exist
                        header("Location: login.php");
                        exit;
                    }

                    $email = $_SESSION['email'];

                    // Use prepared statements for security
                    $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($row = $result->fetch_assoc()) {
                        echo "<strong>ID:</strong> " . $row['id'] . "<br />";
                        echo "<strong>Name:</strong> " . $row['f_name'] . " " . $row['l_name'] . " <a href='u_fl_name.php' class='profile-link'>edit</a><br />";
                        echo "<strong>Email Address:</strong> " . $row['email'] . " <a href='u_email.php' class='profile-link'>edit</a><br />";
                        echo "<strong>Contact Number:</strong> " . $row['contact'] . " <a href='u_contact.php' class='profile-link'>edit</a><br />";
                        echo "<strong>Address:</strong> " . $row['address'] . " <a href='u_address.php' class='profile-link'>edit</a><br />";
                        echo "<strong>Change Password:</strong> <a href='u_pswd.php' class='profile-link'>edit</a><br />";
                    } else {
                        echo "User not found.";
                    }

                    // Close the prepared statement
                    $stmt->close();
                    ?>
                </h3>

                <!-- Pagination -->
                <div class="container">
                    <ul class="pager">
                        <li class="previous"><a href="view_user_home_page.php">Previous</a></li>
                        <li class="next"><a href="../doctor_list.php">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>
