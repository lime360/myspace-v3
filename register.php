<?php
require("conn.php");
require("dependencies.php");
?>
<!doctype html>
<html lang="en">
	<head>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap.min.css">
		<title>crapblox!</title>
	</head>
	<body>
		<?php
		require("header.php");
		?>
		<br><br>
		<div class="container" style="margin-top:30px">
			<?php
			if(@$_POST) {
				$sql = "SELECT `username` FROM `users` WHERE `username`='". htmlspecialchars($_POST['username']) ."'";
				$result = $conn->query($sql);
				if($result->num_rows >= 1) {
					echo '
					<div class="alert-message error">
						<p><strong>error!</strong> user with the same name already exists.</p>
					</div>';
				} else {
					$stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `date`) VALUES (?, ?, now())");
					$stmt->bind_param("ss", $username, $password);
				
					$username = htmlspecialchars($_POST['username']);
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$stmt->execute();
				
					$stmt->close();
					$conn->close();
					$_SESSION['loggedinusername'] = htmlspecialchars($username);
					$_SESSION['style'] = "css/themes/default.css";
					echo '
					<div class="alert-message success">
						<p><strong>success!</strong> you registered.</p>
					</div>
					';
				}
			}
			?>
			<form action="" method="post">
				<fieldset>
					<legend>register!</legend>
					<div class="clearfix">
						<label for="xlInput">username</label>
						<div class="input">
							<input required class="xlarge" id="xlInput" name="username" size="30" type="text">
						</div>
						<label for="xlInput2">password</label>
						<div class="input">
							<input required class="xlarge" id="xlInput" name="password" size="30" type="password">
						</div>
					</div><!-- /clearfix -->
					<div class="actions">
						<button name="button" type="submit" class="btn primary">Register</button>
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>

	</body>
</html>