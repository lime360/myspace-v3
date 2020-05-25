<?php
require("settings.php");
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>myspace [v3] - login</title>
		<link rel="stylesheet" href="style.css">

	</head>

	<body>
		<?php
			
		?>
		<small>
		<?php require("header.php"); 
		
		if(@$_POST) {
				$stmt = $conn->prepare("SELECT password FROM `users` WHERE username=?");
				$stmt->bind_param("s", $_POST['username']);
				$stmt->execute();
				$result = $stmt->get_result();
				
				while($row = $result->fetch_assoc()) {
					$hash = $row['password'];
					if(password_verify($_POST['password'], $hash)){
						$_SESSION['myspace'] = htmlspecialchars($_POST['username']);
						$_SESSION['style'] = "css/themes/default.css";
						echo 'successfully logged in<hr>';
					} else {
						echo 'login information dosent exist.<hr>';
					}
				}
			} 
		?>
		<div class="content">
			<form action="" method="post">
				<fieldset>
					<legend>login</legend>
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
						<button name="button" type="submit" class="btn primary">Login</button>
					</div>
				</fieldset>
			</form>
		</small>
	</body>
</html>