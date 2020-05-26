<?php
require("settings.php");
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3]</title>
		<link rel="stylesheet" href="style.css">

	</head>

	<body>
		<small>
		<?php require("header.php"); ?>
		<div class="content">
			<div class="hero">
				<h1>welcome to myspace v3.</h1>
				<a href="register.php"><button>join now</button></a>
				<br>
			</div>
			<?php
			$stmt = $conn->prepare("SELECT * FROM users ORDER BY rand() LIMIT 1");
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows === 0) echo('there are no registered users.');
			while($row = $result->fetch_assoc()) {
				echo '<h3>meet new people, like ' . $row['username'] . '</h3>';
			}
			$stmt->close();
			?>
			<p>...and other people:</p>
			<?php
			$stmt = $conn->prepare("SELECT * FROM users");
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows === 0) echo('there are no registered users.');
			while($row = $result->fetch_assoc()) {
				echo '<a href="profile.php?id=' . $row['id'] . '">>' . $row['username'] . '</a><br>';
			}
			$stmt->close();
			?>
		</div>
		</small>
	</body>
</html>