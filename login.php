<?php
	session_start();

	// Check if the user is already authenticated
	if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
		header('Location: index.php');
		exit;
	}

	// Check if the login form was submitted
	if (isset($_POST['username']) && isset($_POST['password'])) {
		// Check if the username and password are correct
		if ($_POST['username'] === 'demo' && $_POST['password'] === 'demo') {
			// Authentication successful
			$_SESSION['authenticated'] = true;
			header('Location: index.php');
			exit;
		} else {
			// Authentication failed
			$error = 'Invalid username or password.';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<?php if (isset($error)) { echo '<p>'.$error.'</p>'; } ?>
	<form method="post">
		<label>Username:</label>
		<input type="text" name="username"><br>
		<label>Password:</label>
		<input type="password" name="password"><br>
		<input type="submit" value="Login">
	</form>
</body>
</html>
