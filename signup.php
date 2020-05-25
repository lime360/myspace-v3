<?php
require("settings.php");
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3] - sign up</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<small>
		<?php require("header.php"); ?>
		<div class="content">
			<?php
			if(@$_POST['username'] && @$_POST['password'] && !empty($_POST['username'])) {
				$stmt = $conn->prepare("SELECT `username` FROM `users` WHERE `username`=?");
				$stmt->bind_param("s", $_POST['username']);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows === 1) {
					echo 'user with the same name exists.<hr>';
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
					echo 'success!<hr>';
				}
			}
			?>
			<form action="" method="post">
				<fieldset>
					<legend>register!</legend>
					<div class="clearfix">
						<label for="xlInput">username</label>
						<div class="input">
							<input required name="username" size="30" type="text">
						</div>
						<label for="xlInput2">password</label>
						<div class="input">
							<input required name="password" size="30" type="password">
						</div>
					</div>
					<div class="actions">
						<button name="button" type="submit" class="btn primary">Register</button>
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
	</small>
	</body>
</html>