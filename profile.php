<?php
require("settings.php");
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3] - profile</title>
		<link rel="stylesheet" href="style.css">

	</head>

	<body>
		<small>
		<?php require("header.php"); ?>
		<div class="content">
			<div class="topLeft">
				<?php
				$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
				$stmt->bind_param("s", $_GET['id']);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) die('theres no user with that id.');
				while($row = $result->fetch_assoc()) {
					echo '<center><h1>' . $row['username'] . '</h1>';
					echo "<img style='width: 15em;' src='pfp/" . $row['pfp'] . "'>";
					echo "<br><p>"
					. "Age: " . $row['age'] . "<br>Gender: " . $row['gender'] . "<br>Location: " . $row['location'] . "<br>";
				
					echo '<hr><small>"' . $row['song'] . '"</small><br>';
					echo '<audio style="width: 15em;"controls>
						<source src="music/' . $row['song'] . '">
					Your browser does not support the audio element.
					</audio> </p></center>';
				}
				$stmt->close();
				?>
			</div>
			<div class="topRight"><br>
				<?php
					$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
					$stmt->bind_param("s", $_GET['id']);
					$stmt->execute();
					$result = $stmt->get_result();
					if($result->num_rows === 0) die('there is no user with that id');
					while($row = $result->fetch_assoc()) {
						echo '"' . $row['bio'] . '"<hr>';
					}
					$stmt->close();
				?>
				<h3>Other MySpacers</h3>
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
		</div>
		</small>
	</body>
</html>