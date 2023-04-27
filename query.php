<?php
session_start();

if (!isset($_SESSION["email"]) || !isset($_SESSION["regno"])) {
      // User is not logged in, redirect to login page
  header("location: login.php");
  exit;
}
$regno = $_SESSION["regno"];
$email = $_SESSION["email"];
// echo '<script>alert("'.$regno.'")</script>';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
//   $regno = $_POST["regno"];
  $disease_title = $_POST["dtitle"];
  $symptoms = $_POST["symptoms"];
  $howlong = $_POST["howlong"];
  $diseasedescription = $_POST["description"];
  $severity = $_POST["severity"];

  // Validate form data (you can add your own validation rules here)

  // Insert data into database
  $dsn = "mysql:host=localhost;dbname=vithealthcare";
  $username = "root";
  $password = "";
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

  try {
    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "INSERT INTO medical_record (regno, disease_title, symptoms, howlong, disease_description, severity) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $regno);
    $stmt->bindParam(2, $disease_title);
    $stmt->bindParam(3, $symptoms);
    $stmt->bindParam(4, $howlong);
    $stmt->bindParam(5, $diseasedescription);
    $stmt->bindParam(6, $severity);
    $result = $stmt->execute();
    
    if ($result && $stmt->rowCount() > 0) {
        // Insert query was successful
        // Redirect to some other page after insertion
        //$inserterr = "successfull";
        header("location: querysuccess.php");
        exit;
    } else {
        // Insert query was not successful
        $inserterr = "Error";
    }
    // Redirect to some other page after insertion
  } catch (PDOException $e) {
    // Handle database error
    echo '<script>alert("Error on Submission")</script>';

  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>
    <div class="top-header">
        <div class="logo-content">
            <img src="./logo-removebg-preview.webp" style="background-color: white;" width="60px" height="50px"
                style="margin-top: .6vh;" alt="logo">
            <div>
                <h2 style="color:white;text-align: center;">VIT</h2>
                <hr style="color:white">
                <h4 style="color:white">Hospital Management System</h4>
            </div>
        </div>
        <!-- <button class="logout">Logout</button> -->
        <!-- HTML !-->
        <div style="display:flex;" class="headlog">
            <p style="color:white;padding-top: 15px;padding-right: 10px;"><?php echo $email ?></p>
            <button class="button-29" role="button" onclick="window.location.href='logout.php'" >Logout</button>
        </div>
    </div>

    <div class="side-header">
        <div class="side-cont">
            <a href="studentview.php" class="home">
                <i class="fa fa-home" aria-hidden="true"></i> Home
            </a>
            <a href="studentprofile.php" class="profile">
                <i class="fa fa-user" aria-hidden="true"></i> Profile
            </a>
            <a href="query.php" class="query">
                <i class="fa fa-question-circle" aria-hidden="true"></i> Raise Query
            </a>
        </div>
    </div>
    <div class="main">
        <form class="form-container" method="post" >
            <h1>Tell us what's happening to you?</h1>
            <input type="text" name="dtitle" id="dtitle" placeholder="Appointment for? (Title)" required>

            <input type="text" name="symptoms" id="symptoms" placeholder="Symptoms" required>
            
            <input type="text" name="howlong" id="howlong" placeholder="How long?" required>
            
            <textarea name="description" id="description"placeholder="Briefly Describe the Problem"></textarea>
            <input type="text" name="severity" id="severity" placeholder="Severity" required>
            
            <button type="submit"  class="button-29 btn" >submit</button>
            <?php if (isset($inserterr)) { echo "<p style='color:red'>$inserterr</p>"; } ?>
        </form>
    </div>


</body>
</html>