<?php
session_start(); // Start session

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  // User is not logged in, redirect to login page
  header("location: adminlogin.php");
  exit;
}
if (!isset($_SESSION["emailadmin"])) {
    // User is not logged in, redirect to login page
    header("location: adminlogin.php");
    exit;
}

// User is logged in, get user ID from session
$email = $_SESSION["emailadmin"];
$dsn = "mysql:host=localhost;dbname=vithealthcare";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
  $pdo = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM doctor ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="adminstyle.css">
    <script src="https://kit.fontawesome.com/62f865ac5b.js" crossorigin="anonymous"></script>
   
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
        <button class="button-29" role="button"  onclick="window.location.href='logout.php'">Logout</button>

    </div>   
    <div class="admin-main">
        <div class="add-doctor">
            <button class="button-29" role="button"  onclick="window.location.href='adddoc.php'">Add Doctor</button>
        </div>

        <div class="doctor-container">
            <!-- main -->
            <div class="table">

                <div class="row header blue">
                    <div class="cell">
                        <i class="fa fa-key"></i>
                        DrID
                    </div>
                    <div class="cell">
                        <div class="doc-icon"></div>
                        Doctor
                    </div>
                    <div class="cell">
                        <i class="fa fa-stethoscope"></i>
                        Speciality
                    </div>
                    <div class="cell">
                        <i class="fa fa-envelope"></i>
                        Email
                    </div>
                    <div class="cell">
                    <i class="fa fa-link"></i>
                        Details
                    </div>
                </div>
                <?php foreach ($records as $record): ?>
                <div class="row">
                    <div class="cell" data-title="drid">
                <?php echo $record['drid']; ?>
                    </div>

                    <div class="cell" data-title="dname">
                <?php echo $record['firstname']; echo " "; ?>
                <?php echo $record['lastname']; ?>
                    </div>

                    <div class="cell" data-title="spec">
                <?php echo $record['speciality']; ?>
                    </div>

                    <div class="cell" data-title="email">
                <?php echo $record['email']; ?>
                    </div>
                    <div class="cell" data-title="details">
                        <a href="#">View More</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</body>
</html>