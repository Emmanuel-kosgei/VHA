<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Disease Prediction</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- W3.CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: #777;
      background-image: url('pic/1.jpg');
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
      color: #000066;
    }

    .container {
      padding: 50px 15px;
      max-width: 1200px;
      margin: 0 auto;
      background-color: rgba(255, 255, 255, 0.8); /* Slight transparency for readability */
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    }

    h3 {
      font-size: 20px;
      line-height: 1.8;
      margin-bottom: 30px;
    }

    .table-hover {
      width: 100%;
      margin-top: 30px;
    }

    .table-dark {
      background-color: #343a40;
    }

    .table-dark th {
      color: #ffc107;
      text-align: center;
    }

    .table-dark a {
      color: #ffc107;
      font-weight: bold;
      text-decoration: none;
    }

    .table-dark a:hover {
      color: #ffb300;
      text-decoration: underline;
    }

    .pager {
      font-weight: bold;
      text-align: center;
      margin-top: 20px;
    }

    .pager li a {
      color: #007BFF;
      text-transform: uppercase;
      font-weight: bold;
      transition: color 0.3s;
    }

    .pager li a:hover {
      color: #0056b3;
    }

    .btn-custom {
      background-color: #007BFF;
      color: white;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      transition: background-color 0.3s;
    }

    .btn-custom:hover {
      background-color: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      h1 {
        font-size: 40px;
      }

      .container {
        padding: 20px;
      }

      .table {
        font-size: 16px;
      }
    }

  </style>
</head>
<body>

  <div class="container">
    <h1>Disease Prediction</h1>
    <h3>
      <script>
        var name1 = prompt('Are you experiencing any of these symptoms?\n\n' +
          'a) Fever, Cough, Headache, Abdominal pain, Yellow-eye, Vomiting, Constipation,\nLoose-motion,Burning chest, Itching, Skin-Lashion\n\n' +
          'b) Chest pain, Breathlessness, Palpitation, Vertigo, Swelling leg, Senseless, Headache, Neck-pain\n\n' +
          'c) Pregnancy, P/V bleeding during pregnancy, Less fetal movement, Excessive whitish discharge P/V, Severe lower abdominal pain during menstruation, Lower abdominal pain\n' +
          'd) Fractures, Dislocation, Joint pain, Swelling of joint, Bone Pain\n' +
          'e) Bleeding gum, Gum-swelling, Toothache, Cavities in teeth');

        if (name1 == 'a') {
          alert('Contact with our Medicine specialist...');
        } else if (name1 == 'b') {
          alert('Contact with our Cardiologist...');
        } else if (name1 == 'c') {
          alert('Contact with our Gynecologist...');
        } else if (name1 == 'd') {
          alert('Contact with our Orthopedic...');
        } else if (name1 == 'e') {
          alert('Contact with our Dentist...');
        } else if (name1 == 'ab') {
          var name2 = prompt('Are you experiencing any of these symptoms?\n\n' +
            'a) Fever, Cough, Abdominal pain, Yellow-eye, Vomiting, Constipation, Loose-motion, Burning chest, Itching, Skin-Lashion\n\n' +
            'b) Chest pain, Breathlessness, Palpitation, Vertigo, Swelling leg, Senseless, Neck-pain');
          if (name2 == 'a') {
            alert('Contact with our Medicine specialist...');
          } else if (name2 == 'b') {
            alert('Contact with our Cardiologist...');
          }
        }
        // More conditions can go here as per the original logic...
      </script>

      <div id="google_translate_element"></div>
      <script type="text/javascript">
        function googleTranslateElementInit() {
          new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
          }, 'google_translate_element');
        }
      </script>
      <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </h3>

    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th scope="col" class="text-center text-warning">Specialist Name</th>
        </tr>
      </thead>
      <tbody>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/medicine.php">Medicine</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/bone.php">Orthopedic</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/dentist.php">Dentist</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/cardiac_electrophysiologist.php">Cardiac Electrophysiologist</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/cardiologist.php">Cardiologist</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/surgeon.php">Surgeon</a></th></tr>
        <tr><th class="text-center"><a href="Display_doctor_list_on_users_home_page/gynecologist.php">Gynecologist</a></th></tr>
      </tbody>
    </table>

    <div class="pager">
      <ul class="pager">
        <li class="previous"><a href="index.php">Previous Page</a></li>
        <li class="next"><a href="../doctor_list.php">Next Page</a></li>
      </ul>
    </div>
  </div>

  <!-- Include JS libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>
</html>
