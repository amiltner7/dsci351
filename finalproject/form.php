<?php 
	$host = "303.itpwebdev.com";
	$user = "amiltner_db_user";
	$pass = "Cubs-2022!";
	$db = "amiltner_351_final_project";

	// 1. Establish MySQL Connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for MySQL Connection Errors
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	// 2. Perform SQL Queries - get everything from the genres table, ratings table, labels table, formats table, and sounds table and query them. We will grab each value from the tables further down in the code so we can add everything to our dropdown menus
	$sql_all = "SELECT DISTINCT Country FROM combined;";

	// Equivalent of lightning bolt in workbench - actually does operation
	$results_all = $mysqli->query($sql_all);

	if ($results_all == false) {
		echo $mysqli->error;
		// Need to close it because the connection is already established when the query fails. In earlier if statement don't need to close because we never established a connection
		$mysqli->close();
		exit();
	}

	// 3. Close the DB
	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Life Expectancy</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">Search</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Life Expectancy Form</h1>
		</div> <!-- .row -->
		<div class="row">
			<p class="col-12 mb-4">Hello! This form will allow you to see different statistics about countries and analyze how they correlate with that country's life expectancy. You have 3 options:</p>
			<ol>
				<li>Choose a country from the first dropdown menu and see life expectancy and other statistics for that specific country</li>
				<li>Choose a status (developed or developing) from the second dropdown menu and see life expectancy and other statistics for that group of countries</li>
				<li>Leave both options blank and just click 'Search' and we will do the analytics for you! You will see life expectancy and statistics for devloped countries compared with developing countries</li>
			</ol>
			<p class="col-12 mb-4">Note: please do not select both a country and a status!</p>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<form action="results.php" method="GET">
			<div class="form-group row">
				<label for="country" class="col-form-label text-sm-right">Country:</label>
				<div class="col-sm-9">
					<select name="country" id="country" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- As long as there is a new row in the table, grab it and display the actual value (same for genre, rating, label, format, and sound) -->
						<?php while ($row = $results_all->fetch_assoc()) : ?>


							<option value='<?php echo $row['Country']; ?>'>
								<?php echo $row['Country']; ?>
							</option>
							

						<?php endwhile; ?>


					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="status" class="col-form-label text-sm-right">Status:</label>
				<div class="col-sm-9">
					<select name="status" id="status" class="form-control">
						<option value="" selected>-- All --</option>


							<option value='Developed'>
								Developed
							</option>
							<option value='Developing'>
								Developing
							</option>


					</select>
				</div>
			</div> <!-- .form-group -->
		
			<div class="form-group row">
				<!-- <div class="col-sm-3"></div> -->
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>