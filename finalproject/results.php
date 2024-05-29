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

	// Set encoding so we don't have weird characters
	$mysqli->set_charset('utf8');

	// 2. Perform SQL query - get id, title, release_date, genre, and rating by joining tables accordingly - set where statement as 1=1 for now and then we will add to it in our if statements below depending on if the movie actually as values for the attributes
	$sql = "SELECT avg(Population) as pop, avg(LifeExpectancy) as le, avg(Alcohol) as alc, avg(TotalExpenditure) as te, avg(Polio) as polio, avg(HIVAIDS) as hiv, avg(HepatitisB) as hep, avg(Measles) as measles, avg(GDP) as gdp FROM combined WHERE 1=1";

	// Check if title, genre, and rating id are set in the search form and add to the sql query if so 
	if (isset($_GET['country']) && !empty($_GET['country'])) {
		// Grab the value from the search_form and assign it to a variable
		$country = $_GET['country'];
		// can inject it with double quotes
		$sql = $sql . " AND Country = '$country';";
	}

	elseif (isset($_GET['status']) && !empty($_GET['status'])) {
		$status = $_GET['status'];
		// can inject it with double quotes
		$sql = $sql . " AND Status = '$status';";
	}

	else {
		$sql = "SELECT Status, avg(Population) as pop, avg(LifeExpectancy) as le, avg(Alcohol) as alc, avg(TotalExpenditure) as te, avg(Polio) as polio, avg(HIVAIDS) as hiv, avg(HepatitisB) as hep, avg(Measles) as measles, avg(GDP) as gdp FROM combined GROUP BY Status;";
	}

	// Query the statement
	$results = $mysqli->query($sql);

	// Check for errors - note: equivalent to $results == false
	if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// 3. Close MySQL Connection
	$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Life Expectancy Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Life Expectancy Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row">
			<div class="col-12">
				Per the data source, this is how each of the queried indicators were defined:
				<ul>
					<li>GDP: Gross Domestic Product per capita (in USD)</li>
					<li>Total Expenditure: General government expenditure on health as a percentage of total government expenditure (%)</li>
					<li>Alcohol: Alcohol, recorded per capita (15+) consumption (in litres of pure alcohol)</li>
					<li>Polio: Polio (Pol3) immunization coverage among 1-year-olds (%)</li>
					<li>HIV/AIDS: Deaths per 1000 live births HIV/AIDS (0-4 years)</li>
					<li>Hepatitis B: Hepatitis B (HepB) immunization coverage among 1-year-olds (%)</li>
					<li>Measles: Measles - number of reported cases per 1000 population</li>
				</ul>

				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Country/Status</th>
							<th>Population</th>
							<th>Life Expectancy</th>
							<th>GDP</th>
							<th>Total Expenditure</th>
							<th>Alcohol Consumption</th>
							<th>Polio</th>
							<th>HIV/AIDS</th>
							<th>Hepatitis B</th>
							<th>Measles</th>
						</tr>
					</thead>
					<tbody>

						<!-- While there is another row in our query, grab the title, release date, genre, and rating to display on the page (using echo) -->
						<?php while ($row = $results->fetch_assoc()) : ?>
							<tr>
								<td>
									<?php if (isset($country)) {
										echo $country;
									}
									elseif (isset($status)) {
										echo $status;
									}
									else {
										echo $row['Status'];
									}?>

								</td>
								<td>
									<?php echo round($row['pop']); ?>
								</td>
								<td>
									<?php echo round($row['le']); ?>
								</td>
								<td>
									<?php echo round($row['gdp'], 3); ?>
								</td>
								<td>
									<?php echo round($row['te'], 3); ?>
								</td>
								<td>
									<?php echo round($row['alc'], 3); ?>
								</td>
								<td>
									<?php echo round($row['polio'], 3); ?>
								</td>
								<td>
									<?php echo round($row['hiv'], 3); ?>
								</td>
								<td>
									<?php echo round($row['hep'], 3); ?>
								</td>
								<td>
									<?php echo round($row['measles'], 3); ?>
								</td>
							</tr>

						<?php endwhile; ?>

					</tbody>
				</table>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="form.php" role="button" class="btn btn-primary">Back to Form</a>
				<a href="explanation.html" role="button" class="btn btn-primary">Explain</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>