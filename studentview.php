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
// User is logged in, get user ID from session
$email = $_SESSION["email"];
$dsn = "mysql:host=localhost;dbname=vithealthcare";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
  $pdo = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM medical_record where regno= '$regno'";
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
        <!-- main -->
        <div class="table">

            <div class="row header blue">
                <div class="cell">
                    MrID
                </div>
                <div class="cell">
                    Disease
                </div>
                <div class="cell">
                    Diagonised Time
                </div>
                <div class="cell">
                    Status
                </div>
                <div class="cell">
                    Details
                </div>
            </div>
            <?php foreach ($records as $record): ?>
            <div class="row">
                <div class="cell" data-title="mrid">
                <?php echo $record['mrid']; ?>
                </div>

                <div class="cell" data-title="dname">
                <?php echo $record['disease_title']; ?>
                </div>

                <div class="cell" data-title="dtime">
                <?php echo $record['created_timestamp']; ?>
                </div>

                <div class="cell" data-title="status">
                <?php if( $record['status']==0){
                        echo 'Pending';
                      }else{
                        echo 'Prescribed';
                      } ?>
                </div>
                <div class="cell" data-title="details">
                    <a href="mrecordstu.php?mrid=<?php echo $record['mrid'] ?>">View More</a>
                </div>
            </div>
            <?php endforeach; ?>


        </div>
    </div>

</body>

</html>