<?php
	session_start();

	// Check if the user is authenticated
	if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
		header('Location: login.php');
		exit;
	}

	// Check if a file was uploaded
	if (isset($_FILES['fileToUpload'])) {
		$file = $_FILES['fileToUpload'];

		// Check for errors
		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo 'Error uploading file: '.$file['error'];
			exit;
		}

		// Check file size
		if ($file['size'] > 200000000) { // 200 MB
			echo 'File size must be less than 200 MB.';
			exit;
		}

		// Move the file to the current directory
		if (move_uploaded_file($file['tmp_name'], $file['name'])) {
			// Set the file's last modified time to now
			touch($file['name']);
			echo 'File uploaded successfully. Redirecting to index page in 2 seconds...';
			header("Refresh: 2; URL=index.php");
		} else {
			echo 'Error uploading file.';
		}
	}
?>
