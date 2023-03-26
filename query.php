<!DOCTYPE html>
<html>
<head>
	<title>Insert Data</title>
</head>
<body>

	<form method="post" action="">
		<h2>Insert Data</h2>
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" required><br><br>

		<label for="symptoms">Symptoms:</label>
		<input type="text" name="symptoms" id="symptoms" required><br><br>

		<label for="description">Description:</label>
		<input type="text" name="description" id="description" required><br><br>

		<label for="time">Time:</label>
		<input type="text" name="time" id="time" required><br><br>

		<input type="submit" name="submit" value="Submit">
	</form>

	<?php
	// Establish database connection
	$host = "localhost"; // hostname of database server
	$username = "root"; // username for database server
	$password = ""; // password for database server
	$dbname = "vithealthcare"; // name of the database to connect to

	// create database connection
	$mysqli = new mysqli($host, $username, $password, $dbname);

	// check connection
	if ($mysqli->connect_error) {
	    die("Connection failed: " . $mysqli->connect_error);
	}

	// Insert data into table on form submission
	if(isset($_POST['submit'])){
		$title = $_POST['title'];
		$symptoms = $_POST['symptoms'];
		$description = $_POST['description'];
		$time = $_POST['time'];

		$insert_query = "INSERT INTO your_table_name (title, symptoms, description, time) VALUES ('$title', '$symptoms', '$description', '$time')";

		if(mysqli_query($mysqli, $insert_query)){
			echo "Data inserted successfully.";
		} else{
			echo "ERROR: Could not able to execute $insert_query. " . mysqli_error($mysqli);
		}
	}

	// Close database connection
	mysqli_close($mysqli);
	?>

</body>
</html>
