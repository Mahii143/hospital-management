<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get email and password from form
  $email = $_POST["email"];
  $password = $_POST["password"];
  // Connect to database
  $conn = mysqli_connect("localhost", "root", "", "vithealthcare");

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
$sql = "SELECT * FROM admin_login WHERE email = '$email'";

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
    $_SESSION["emailadmin"] = $row["email"];

    // Redirect to welcome page
    header("location: admindash.php");
    exit;
    } else {
    // Invalid password, show error message
    $login_err = "Invalid email or password";
    }
} else {
    // Email not found, show error message
    $login_err = "Invalid email or password";
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <title>HOSPITAL MANAGEMENT</title>
  </head>
  <body>
    <div class="whole-cont">
      <div class="cont1">
        <form class="form" method="post">
          <div class="logo"><i class="fa fa-heart"></i> Logo</div>
          <div class="creta">Admin Log in</div>
          <label for="email">Email</label>
          <input type="text" name="email" id="email" required/>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required/>
          <button type="submit">Log In</button>
        </form>
        <?php if (isset($login_err)) { echo "<p style='color:red'>$login_err</p>"; } ?>
      </div>
      <div class="cont2">
        <div class="img-cont">
          <img src="./img3.jpg" />
        </div>
      </div>
    </div>
  </body>
</html>
