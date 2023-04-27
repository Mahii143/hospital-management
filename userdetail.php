<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION["email"])) {
  // User is not logged in, redirect to login page
  header("location: login.php");
  exit;
}

// Get email from session
$email = $_SESSION["email"];

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get data from form
  $regno = $_POST["regno"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $dob = $_POST["date"];
  $gender = $_POST["gender"];
  $roomno = $_POST["roomno"];
  $batch = $_POST["batch"];
  $mob = $_POST["mob"];

  // TODO: Validate form data

  // Insert data into the database using PDO
  try {
    // Define database credentials
    $host = "localhost";
    $dbname = "vithealthcare";
    $user = "root";
    $password = "";

    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL query for insertion
    $sql = "INSERT INTO user (regno, firstname, lastname, dob, sex, roomno, batch, mobile, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Bind values to statement
    $stmt->bindParam(1, $regno);
    $stmt->bindParam(2, $fname);
    $stmt->bindParam(3, $lname);
    $stmt->bindParam(4, $dob);
    $stmt->bindParam(5, $gender);
    $stmt->bindParam(6, $roomno);
    $stmt->bindParam(7, $batch);
    $stmt->bindParam(8, $mob);
    $stmt->bindParam(9, $email);

    // Execute the statement
    $result = $stmt->execute();

    if ($result && $stmt->rowCount() > 0) {
        // Insert query was successful
        // Redirect to some other page after insertion
        header("location: studentview.php");
        exit;
    } else {
        // Insert query was not successful
        $inserterr = "Reg No already linked to an account";
        exit;
      }
  } catch (PDOException $e) {     
    echo  '<script>alert("Reg No already linked to an account")</script>';
  }
}

// Display the form
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="style3.css" />
    <title>HOSPITAL MANAGEMENT</title><style>
        *{
            box-sizing: border-box;
        }
        body{
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .whole-cont{
            /* position: absolute; */
            /* justify-content: center; */
            /* margin: 15vh 10vw; */
            display: flex;
            flex-direction: row; 
            border: 2px solid black;
            border-radius: 15px;
            /* box-shadow: 3px black; */
            box-shadow: 5px 10px grey ;
            width: 80%;
            /* overflow: scroll; */
            height: 80%;
        }
        .cont1,.cont2{
            width: 50%;
            height: 100%;

        }
        .cont1{
            overflow: scroll;
        }

        .form{
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
            padding: 2vh 8vw;
        }
        img{
            width: 100%;
            height: 100%;
        }
        input{
            border: none;
            border-bottom: 1px solid black;
            /* margin-bottom: 5%;
            /* width:60%; */ 
        }
        .creta{
            text-align: center;
            font-weight: bold;
            padding: 10% 0%;
        }
        button{
            justify-content: center;
            text-align: center;
            width: fit-content;
            color: white;
            background-color: black;
            width: 100%;
            /* height: 5%; */
            padding: 2%;
            /* padding-top: 0%; */
            /* gap: 0.5rem; */
        }
        .cont2 .img-cont {
            height:100%;
            width: 100%;
            /* background-image: url('/img1.jpg');
            /* background-repeat: no-repeat; */
            /* background-position: center; */
            /* background-size: cover; */
            border-radius: 0 15px 15px 0; 
        }
        span{
            font-weight: bold;
            /* padding-left: 10px; */
        }
        .close{
            text-align: center;
        }
    </style>
  </head>
  <body>
    <form class="whole-cont" method="post">
      <div class="cont1">
        <div class="form">
          <div class="logo"><i class="fa fa-heart"></i> Logo</div>
          <div class="creta">Enter User Details</div>
          <label for="regno">Register No</label>
          <input type="text" name="regno" id="regno" required/>
          <label for="fname">Enter First Name</label>
          <input type="text" name="fname" id="fname" required/>
          <label for="lname">Enter Last Name</label>
          <input type="text" name="lname" id="lname" required/>
          <label for="date">DOB</label>
          <input type="date" name="date" id="date" required/>
          <label for="gender">Gender:</label>
          <div class="radio-cont">
            <div class="div1">
                <input type="radio" id="male" name="gender" value="M" required>
                <label for="male">Male</label>
            </div>
            <div class="div1">
                <input type="radio" id="female" name="gender" value="F" required>
                <label for="female">Female</label>
            </div>
          </div>
          <label for="roomno">Enter Room No.</label>
          <input type="text" name="roomno" id="roomno" required/>
          <label for="batch">Enter Batch</label>
          <input type="number" min="1900" max="2099" step="1" value="2023" name="batch" id="batch" required/>
          <label for="mob">Enter Mobile</label>
          <input type="text" name="mob" id="mob" required/>
          <button type="submit" >Sign Up</button>
          <div class="close">
            Already Have an Account?
            <span><a href="./index.html">Log In</a></span>
          </div>
        </div>
      </div>
      <div class="cont2">
        <div class="img-cont">
          <img src="./img3.jpg" />
        </div>
      </div>
      
      <?php if (isset($inserterr)) { echo "<p style='color:red'>$inserterr</p>"; } ?>
    </form>
  </body>
</html>














