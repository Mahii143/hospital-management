<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get email and password from form
  $email = $_POST["email"];
  $password = $_POST["password"];
  $radioVal = $_POST["type"];
  // Connect to database
  $conn = mysqli_connect("localhost", "root", "", "vithealthcare");

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  if ($radioVal == "stu") {
    // Prepare SQL statement
    $sql = "SELECT * FROM student_login WHERE email = '$email'";

    // Execute SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if email exists in database
    if (mysqli_num_rows($result) == 1) {
      // Get row from result set
      $row = mysqli_fetch_assoc($result);
      // Check if password matches
      if ($password == $row["password"]) {
        // Successful login, set session variable
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $row["email"];

        $sql = "SELECT * FROM user WHERE email = '$email'";

        // Execute SQL statement
        $result1 = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result1) == 0) {
          header("location: userdetail.php");
          exit;
        }
        $row1 = mysqli_fetch_assoc($result1);
        $_SESSION["regno"] = $row1["regno"];

        // Redirect to welcome page
        header("location: studentview.php");
        exit;
      } else {
        // Invalid password, show error message
        echo '<script>alert("Invalid email or password")</script>';
      }
    } else {
      // Email not found, show error message
      echo '<script>alert("Invalid email or password")</script>';
    }
  } else if ($radioVal == "doc") {
    // Prepare SQL statement
    $sql = "SELECT * FROM doctor_login WHERE email = '$email'";

    // Execute SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if email exists in database
    if (mysqli_num_rows($result) == 1) {
      // Get row from result set
      $row = mysqli_fetch_assoc($result);
      // Check if password matches
      if ($password == $row["password"]) {
        // Successful login, set session variable
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $row["email"];

        $sql = "SELECT * FROM doctor WHERE email = '$email'";

        // Execute SQL statement
        $result1 = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result1);
        $_SESSION["drid"] = $row1["drid"];

        // Redirect to welcome page
        header("location: doctorview.php");
        exit;
      } else {
        // Invalid password, show error message
        $login_err = "Invalid email or password";
      }
    } else {
      // Email not found, show error message
      $login_err = "Invalid email or password";
    }
  }

  // Close database connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="style.css" />
  <title>HOSPITAL MANAGEMENT</title>
  <style>
    .form {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 1rem;
      padding: 2vh 8vw;
      width: 100%;
    }

    .radio-cont {
      display: flex;
      justify-content: space-between;
      padding: 3%;
    }

    .input-hidden {
      /* For Hiding Radio Button Circles */
      position: absolute;
      left: -9999px;
    }

    img {
      width: 100%;
      height: 100%;
      width: 60px;
      height: 50px;
      margin-top: .6vh;
      background-color: white;
    }

    input[type="radio"]:checked+label>img {
      border: 1px solid rgb(157, 255, 0);
      box-shadow: 0 0 3px 3px #9e00e2;
    }

    input[type="radio"]+label>img {
      border: 1px rgb(0, 0, 0);
      padding: 10px;
      transition: 500ms all;
    }
  </style>
</head>

<body>
  <div class="whole-cont">
    <div class="cont1">
      <form class="form" method="post">
        <!-- <div class="logo"><i class="fa fa-heart"></i> Logo</div> -->
        <div class="logo-content" style="display:flex; align-items:center;">
          <img src="./logo-removebg-preview.webp" style="background-color: white;" width="60px" height="50px"
            style="margin-top: .6vh;" alt="logo">
          <div>
            <h2 style="color:blue;text-align: center; margin:0px;">VIT</h2>
            <hr style="color:blue">
            <h4 style="color:blue; margin:0px;">Hospital Management System</h4>
          </div>
        </div>
        <div class="creta">Log in</div>
        <!-- <div class="radio-cont">
            <div class="div1">
              <input type="radio" id="stu" name="type" value="stu" />
              <label for="stu">STUDENT</label>
            </div>
            <div class="div1">
              <input type="radio" id="doc" name="type" value="doc" />
              <label for="doc">DOCTOR</label>
            </div>
          </div> -->
        <div textalign="center" class="radio-cont" style=" color:white;">
          <input type="radio" id="stu" name="type" class="Send_data  input-hidden" value="stu" checked required />
          <label for="stu">
            <img src="./college-student.jpg" style="width:10vw; height:19vh;border-radius:20px;" />
          </label>
          <input type="radio" id="doc" name="type" class="Send_data  input-hidden" value="doc" />
          <label for="doc">
            <img src="./female-doctor.jpg" style="width:10vw;height: 19vh; border-radius:20px;" />
            <br><br>
          </label>
        </div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required />
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />
        <button type="submit">Log In</button>
        <div class="close">
          Dont Have an Account?
          <span><a href="./signup.php">Sign up</a></span>
        </div>
      </form>
      <?php if (isset($login_err)) {
        echo "<p style='color:red'>$login_err</p>";
      } ?>
    </div>
    <div class="cont2">
      <div class="img-cont">
        <img id="rightimg" src="./img3.jpg" />
      </div>
    </div>
  </div>
</body>

</html>