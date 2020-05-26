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
			$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->bind_param("s", $_SESSION['myspace']);
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
		<?php require("header.php"); ?>
		<div class="content">
			<div class="topLeft">
				<?php
					if(@$_POST['age']) {
						$stmt = $conn->prepare("UPDATE users SET age = ? WHERE username = ?");
						$stmt->bind_param("ss", $_POST['age'], $_SESSION['myspace']);
						$stmt->execute();
						$stmt->close();
						
						$stmt = $conn->prepare("UPDATE users SET gender = ? WHERE username = ?");
						$stmt->bind_param("ss", $_POST['gender'], $_SESSION['myspace']);
						$stmt->execute();
						$stmt->close();
						
						$stmt = $conn->prepare("UPDATE users SET location = ? WHERE username = ?");
						$stmt->bind_param("ss", $_POST['location'], $_SESSION['myspace']);
						$stmt->execute();
						$stmt->close();
					} else if(@$_POST['desc']) {
						$stmt = $conn->prepare("UPDATE users SET bio = ? WHERE username = ?");
						$stmt->bind_param("ss", $description, $_SESSION['myspace']);
						$description = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['desc']));
						$stmt->execute();
						$stmt->close();
						
						$stmt = $conn->prepare("UPDATE users SET css = ? WHERE username = ?");
						$stmt->bind_param("ss", $css, $_SESSION['myspace']);
						$css = validateCSS($_POST['css']);
						$stmt->execute();
						$stmt->close();
					} else if(@$_POST['submit']) {
						$target_dir = "pfp/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if(isset($_POST["submit"])) {
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
							if($check !== false) {
								$uploadOk = 1;
							} else {
								$uploadOk = 0;
							}
						}
						if (file_exists($target_file)) {
							echo 'file with the same name already exists<hr>';
							$uploadOk = 0;
						}
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
						&& $imageFileType != "gif" ) {
							echo 'unsupported file type. must be jpg, png, jpeg, or gif<hr>';
							$uploadOk = 0;
						}
						if ($uploadOk == 0) { } else {
							if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
								$stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE `users`.`username` = ?;");
								$stmt->bind_param("ss", $filename, $_SESSION['myspace']);
								$filename = basename($_FILES["fileToUpload"]["name"]);
								$stmt->execute(); 
								$stmt->close();
							} else {
								echo 'fatal error<hr>';
							}
						}
					} else if(@$_POST['submitsong']) {
						$target_dir = "music/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if (file_exists($target_file)) {
							echo 'file with the same name already exists<hr>';
							$uploadOk = 0;
						}
						if($imageFileType != "mp3" && $imageFileType != "ogg") {
							echo 'unsupported file type. must be mp3 or ogg<hr>';
							$uploadOk = 0;
						}
						if ($uploadOk == 0) { } else {
							if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
								$stmt = $conn->prepare("UPDATE users SET song = ? WHERE `users`.`username` = ?;");
								$stmt->bind_param("ss", $filename, $_SESSION['myspace']);
								$filename = basename($_FILES["fileToUpload"]["name"]);
								$stmt->execute(); 
								$stmt->close();
							} else {
								echo 'fatal error<hr>';
							}
						}
					}
					$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
					$stmt->bind_param("s", $_SESSION['myspace']);
					$stmt->execute();
					$result = $stmt->get_result();
					if($result->num_rows === 0) die('u have to login if  u want to go to dashboard dumb dumb');
					while($row = $result->fetch_assoc()) {
						echo '<center><h1>' . $row['username'] . '</h1>';
						echo "<img style='width: 15em;' src='pfp/" . $row['pfp'] . "'></center>";
						echo ""
						. "<form action='' method='post'>Age: <input required placeholder='" . $row['age'] . "' name='age' size='25' type='text'><br>Gender: <input required placeholder='" . $row['gender'] . "' name='gender' size='21' type='text'><br>Location: <input required placeholder='" . $row['location'] . "' name='location' size=20' type='text'>";
					
						echo '<br><button formmethod="post" name="button" type="submit" class="btn primary">Set</button></form><hr>';
						echo '
						<form method="post" enctype="multipart/form-data">
							Select file:
							<input type="file" name="fileToUpload" id="fileToUpload">
							<input type="submit" value="Upload Image" name="submit">
						</form>
						<hr>
						<form method="post" enctype="multipart/form-data">
							Select song:
							<input type="file" name="fileToUpload" id="fileToUpload">
							<input type="submit" value="Upload Song" name="submitsong">
						</form>
						<hr>
						<small>"' . $row['song'] . '"</small>
						<audio style="width: 15em;"controls>
							<source src="music/' . $row['song'] . '">
						Your browser does not support the audio element.
						</audio> </p>';
					}
					$stmt->close();
				?>
			</div>
			<div class="topRight"><br>
				<?php
					$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
					$stmt->bind_param("s", $_SESSION['myspace']);
					$stmt->execute();
					$result = $stmt->get_result();
					if($result->num_rows === 0) die('u have to login if  u want to go to dashboard dumb dumb');
					while($row = $result->fetch_assoc()) {
						echo '<form action="" method="post"><b>bio</b><br><textarea class="xxlarge" id="textarea2" cols="39" name="desc">' . $row['bio'] . '</textarea><br><b>css</b><textarea class="xxlarge" id="textarea2" cols="39" name="css">' . $row['css'] . '</textarea><button formmethod="post" name="setbio" type="submit" class="btn primary">Set</button></form><hr>';
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