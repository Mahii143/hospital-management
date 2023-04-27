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
// doctor is logged in,
$email = $_SESSION["email"];
$dsn = "mysql:host=localhost;dbname=vithealthcare";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM medical_record where status= 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Dashboard</title>
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
        <!-- main -->
        <h1>Completed records</h1>
        <div class="table">

            <div class="row header blue">
                <div class="cell">
                    MrID
                </div>
                <div class="cell">
                    Name
                </div>
                <div class="cell">
                    Title
                </div>
                <div class="cell">
                    Diagonised Time
                </div>
                <div class="cell">
                    Status
                </div>
                <div class="cell">
                    Severity
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

                    <div class="cell" data-title="uname">

                        <?php
                        $regno = $record['regno'];
                        $host = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "vithealthcare";

                        $conn = mysqli_connect($host, $username, $password, $dbname);
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql = "SELECT firstname FROM user WHERE regno = $regno";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $name = $row["firstname"];
                        } else {
                            $row = "No data found";
                        }
                        mysqli_close($conn);
                        ?>
                        <?php echo $name; ?>

                    </div>
                    <div class="cell" data-title="dtitle">
                        <?php echo $record['disease_title']; ?>
                    </div>
                    <div class="cell" data-title="dtime">
                        <?php echo $record['created_timestamp']; ?>
                    </div>
                    <div class="cell" data-title="status">
                        <?php if ($record['status'] == 0) {
                            echo 'Pending';
                        } else {
                            echo 'Diagnose Completed';
                        } ?>
                    </div>
                    <div class="cell" data-title="severity">
                        <?php echo $record['severity']; ?>
                    </div>
                    <div class="cell" data-title="details">
                        <a href="mrecordhisdoc.php?mrid=<?php echo $record['mrid'] ?>">View
                            More</a>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
    </div>

</body>

</html>