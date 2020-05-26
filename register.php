<?php
require("settings.php");
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3] - register</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<small>
		<?php
		require("header.php");
		?>
		<div class="content">
			<?php
			if(@$_POST) {
				$sql = "SELECT `username` FROM `users` WHERE `username`='". htmlspecialchars($_POST['username']) ."'";
				$result = $conn->query($sql);
				if($result->num_rows >= 1) {
					echo 'user with the same name exists<hr>';
				} else {
					$stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `date`) VALUES (?, ?, now())");
					$stmt->bind_param("ss", $username, $password);
				
					$username = htmlspecialchars($_POST['username']);
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$stmt->execute();
				
					$stmt->close();
					$conn->close();
					$_SESSION['myspace'] = htmlspecialchars($username);
					$_SESSION['style'] = "css/themes/default.css";
					header("Location: dashboard.php");
				}
			}
			?>
			<form action="" method="post">
				<fieldset>
					<legend>register!</legend>
					<div class="clearfix">
						<label for="xlInput">username</label>
						<input required class="xlarge" id="xlInput" name="username" size="30" type="text"><br>
						<label for="xlInput2">password</label>
						<input required class="xlarge" id="xlInput" name="password" size="30" type="password"><br><br>
					</div><!-- /clearfix -->
					<div class="actions">
						<input type="submit" value="Register" name="button">
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
	</small>
	</body>
</html>