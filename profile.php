<?php
require("settings.php");
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3] - profile</title>
		<link rel="stylesheet" href="style.css">
		<?php
			$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
			$stmt->bind_param("s", $_GET['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows === 0) echo('');
			while($row = $result->fetch_assoc()) {
				echo '<style>' . $row['css'] . "</style>";
			}
			$stmt->close();
		?>
	</head>

	<body>
		<small>
		<?php require("header.php"); 
		
		if(@$_POST['comment']) {
			$stmt = $conn->prepare("INSERT INTO comments (toid, author, contents, date) VALUES (?, ?, ?, now())");
			$stmt->bind_param("sss", $_GET['id'], $_SESSION['myspace'], $contents);
			$contents = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['comment']));
			$stmt->execute();
			$stmt->close();
		}
		
		?>
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
					//song
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
						//comment
						echo '"' . $row['bio'] . '"<hr>
						
						<form action="" method="post" enctype="multipart/form-data">
							<textarea class="xxlarge" id="textarea2" cols="39" name="comment"></textarea>
							<input type="submit" value="Comment" name="commentbutton">
						</form><br>';
					}
					$stmt->close();
					?>
				<div class="messageFeed">
					<?php
					//comments feed
					$stmt = $conn->prepare("SELECT * FROM comments WHERE toid = ?");
					$stmt->bind_param("s", $_GET['id']);
					$stmt->execute();
					$result = $stmt->get_result();
					if($result->num_rows === 0) echo('<hr>theres no comments on this profile');
					while($row = $result->fetch_assoc()) {
						//comment
						echo '
						<div class="message" style="padding:3px 0;">
							<div class="clearfix">
								<span class="commentpfp"><a href="?id=' . getID($row['author'], $conn) . '">' . $row['author'] . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
								<img class="commentpfp" src="pfp/' . getPFP($row['author'], $conn) . '" width="120" height="120">
								<b>' . $row['date'] . '</b><br>' . $row['contents'] . '
							</div>
						</div>';
					}
					$stmt->close();
					?>
				</div>
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