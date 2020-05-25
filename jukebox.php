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
				<h3>the jukebox</h3>
				currently playing: 
				<?php
					$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
					$stmt->bind_param("s", $_GET['id']);
					$stmt->execute();
					$result = $stmt->get_result();
					if($result->num_rows === 0) echo('no song selected<br>');
					while($row = $result->fetch_assoc()) {
						echo '<a href="music/' . $row['song'] . '">' . $row['username'] . "'s song</a><br>";
						echo ' <audio controls>
							<source src="music/' . $row['song'] . '">
						</audio> ';
					}
					$stmt->close();
				?>
			</div>
			<?php
				$stmt = $conn->prepare("SELECT * FROM users");
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 0) echo('no song selected');
				while($row = $result->fetch_assoc()) {
					echo '<a href="?id=' . $row['id'] . '">' . $row['username'] . "'s song</a><br>";
				}
				$stmt->close();
			?>
		</div>
		</small>
	</body>
</html>