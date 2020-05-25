<div class="header">
	<div class="topHeader">
		&nbsp;<b><a href='index.php'><?php echo $name; ?></a></b>
		<?php
		if(isset($_SESSION['myspace'])) {
			echo '<span style="float:right;margin-right: 5px;margin-top: 3px;font-size: small;">&nbsp;logged in as <b>' . $_SESSION['myspace'] . '</b></span>';
		} else {
			echo '<span style="float:right;margin-right: 5px;margin-top: 3px;font-size: small;">&nbsp;<a href="signup.php">register</a> | <a href="login.php">login</a>';
		}
		?>
	</div>
	<div class="bottomHeader">
		<a href='index.php'>index</a> | <a href='jukebox.php'>music</a> | <a href='dashboard.php'>dashboard</a> | <a href='rules.php'>rules</a>
	</div>
</div>