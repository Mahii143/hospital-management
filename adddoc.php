<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION["emailadmin"])) {
  // User is not logged in, redirect to login page
  header("location: login.php");
  exit;
}

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get data from form
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $speciality = $_POST["speciality"];
  $dob = $_POST["dob"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];

  // TODO: Validate form data
  if ($password !== $cpassword) {
    echo  '<script>alert("Password and confirmation password do not match")</script>';
  
  } else {
        // Connect to database
        $conn = mysqli_connect("localhost", "root", "", "vithealthcare");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email already exists in database
        $sql = "SELECT * FROM doctor_login WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Email already exists, show error message
            echo  '<script>alert("Email already taken")</script>';
        } else {
            // Email doesn't exist, insert new user into database
            $sql = "INSERT INTO doctor_login (email, password) VALUES ('$email', '$password')";
            if (mysqli_query($conn, $sql)) {
            // User created successfully, redirect to login page
            } else {
            // Error creating user, show error message
            echo  '<script>alert("Error creating user")</script>';
            }
        }
        
        // Close database connection
        mysqli_close($conn);
  }
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
    $sql = "INSERT INTO doctor (firstname, lastname,speciality, dob, gender, email, mobile, address) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Bind values to statement
    $stmt->bindParam(1, $fname);
    $stmt->bindParam(2, $lname);
    $stmt->bindParam(3, $speciality);
    $stmt->bindParam(4, $dob);
    $stmt->bindParam(5, $gender);
    $stmt->bindParam(6, $email);
    $stmt->bindParam(7, $phone);
    $stmt->bindParam(8, $address);

    // Execute the statement
    $result = $stmt->execute();

    if ($result && $stmt->rowCount() > 0) {
        // Insert query was successful
        // Redirect to some other page after insertion
        header("location: admindash.php");
        exit;
    } else {
        // Insert query was not successful  
        echo  '<script>alert("email already linked to an account")</script>';
  
        exit;
      }
  } catch (PDOException $e) {     
    echo  '<script>alert("Account creation failed'.$e->getMessage().'")</script>';
  }
}

// Display the form
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add-doc.css">
    <title>Document</title>
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
    <div class="main">        
        <button class="button-29" role="button"  onclick="window.location.href='admindash.php'"><- Return Back</button>
        <form class="form-container" method="post">
            <h1>Doctor Profile</h1>
            <div class="form-wrapper">
                <input type="text" name="fname" id="fname" placeholder="first name" required>

                <input type="text" name="lname" id="lname" placeholder="last name" required>

                <input type="text" name="speciality" id="speciality" placeholder="speciality" required>

                <input type="date" name="dob" id="dob" placeholder="dob" required>
                
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
                
                <input type="text" name="email" id="email" placeholder="email" required>
                
                <input type="text" name="phone" id="phone" placeholder="phone" required>

                <input type="text" name="password" id="password" placeholder="password" required>

                <input type="text" name="cpassword" id="cpassword" placeholder="confirm password" required>

                <textarea name="address" id="address" placeholder="Address"></textarea required>

            </div>

            <input type="submit" value="submit" class="button-29 btn" role="button" required>
        </form>
    </div>
</body>

</html>