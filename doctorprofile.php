<?php

session_start(); // Start session
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}
if (!isset($_SESSION["email"]) || !isset($_SESSION["drid"])) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}

$drid = $_SESSION["drid"];
$email = $_SESSION["email"];

$dsn = "mysql:host=localhost;dbname=vithealthcare";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM doctor where drid= $drid";
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
    <link rel="stylesheet" href="./docprof.css">
    <!-- <link rel="stylesheet" href="./studprof.css"> -->
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
            <a href="doctorview.php" class="home">
                <i class="fa fa-home" aria-hidden="true"></i> Home
            </a>
            <a href="doctorprofile.php" class="profile">
                <i class="fa fa-user" aria-hidden="true"></i> Profile
            </a>
            <a href="dochistory.php" class="query">
                <i class="fa fa-question-circle" aria-hidden="true"></i> History
            </a>
        </div>
    </div>
    <div class="main">
        <div class="profile-cont">
            <div class="left">
                <img src="./doc.jpg" class="doctor">
            </div>
            <div class="right">
                <p>
                <h4 class="head">PROFILE

                </h4>
                <p class="name">
                    <?php echo $record['firstname']; ?>
                    <?php echo $record['lastname']; ?>
                </p>
                <h4 class="head">DOCTOR ID </h4>
                <h5 class="content">
                    <?php echo $record['drid']; ?>
                </h5>
                <h4 class="head">SPECIALITY</h4>
                <h5 class="content">
                    <?php echo $record['speciality']; ?>
                </h5>
                <h4 class="head">DATE OF BIRTH</h4>
                <h5 class="content">
                    <?php echo $record['dob']; ?>
                </h5>
                <h4 class="head">GENDER</h4>
                <h5 class="content">
                    <?php if ($record['gender'] == 'M') {
                        echo "Male";
                    } else {
                        echo "Female";
                    }
                    ?>
                </h5>
                <h4 class="head">CONTACT</h4>
                <h5 class="content">
                    <?php echo $record['email']; ?><br>
                    <?php echo $record['mobile']; ?>
                </h5>
                </h5>
                </p>
            </div>
        </div>
    </div>
</body>

</html>