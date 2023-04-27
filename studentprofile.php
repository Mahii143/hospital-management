<?php
session_start(); // Start session
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  // User is not logged in, redirect to login page
  header("location: login.php");
  exit;
}
if (!isset($_SESSION["email"]) || !isset($_SESSION["regno"])) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}

$regno = $_SESSION["regno"];
$email = $_SESSION["email"];
$dsn = "mysql:host=localhost;dbname=vithealthcare";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
  $pdo = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM user where regno= '$regno'";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $record = $records[0];
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./studprof.css">
    <link rel="stylesheet" href="./style4.css">
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
            <a href="studentview.php"  class="home">
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
    <div class="profile-cont">
        <div class="left">
          <img src="student.png" class="doctor">
        </div>
        <div class="right">
            <p>
               <p class="head">NAME</p>
               <p class="name">
                <?php echo $record['firstname']; ?>
                <?php echo $record['lastname']; ?></p>
               <p class="head">REG NO</p>
               <p class="content">
                <?php echo $record['regno']; ?></p></p>
               <p class="head">BATCH</h4>
               <p class="content">
                <?php echo $record['batch']; ?></h5>
               <p class="head">GENDER</h4>
               <p class="content">
                <?php if($record['sex']=='M'){
                    echo "Male";
                }else{
                    echo "Female";
                } ?></h5>
               <p class="head">DATE OF BIRTH</h4>
               <p class="content">
                <?php echo $record['dob']; ?></h5>
               <p class="head">ROOM NO</h4>
               <p class="content">
                <?php echo $record['roomno']; ?></h5>
               <p class="head">CONTACT</h4>
               <p class="content"> 
                <?php echo $record['email']; ?><br>
                <?php echo $record['mobile']; ?></h5>
            </p>
        </div>
    </div>
</div>
</body>
</html>