<?php
	session_start();

	// Check if the user is authenticated
	if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
		header('Location: login.php');
		exit;
	}

	// Check if a file was specified for deletion
	if (isset($_GET['file'])) {
		$file = $_GET['file'];

		// Get the absolute path of the file
		$path = realpath($file);

		// Check if the file exists
		if (!$path || !file_exists($path)) {
			echo 'File not found.';
			exit;
		}

		// Check that the file is within the current directory
		if (strpos($path, realpath('.')) !== 0) {
			echo 'Invalid file path.';
			exit;
		}

		// Check if the file is less than one hour old
		if (time() - filemtime($path) >= 3600) {
			echo 'File cannot be deleted because it is more than one hour old.';
			exit;
		}

		// Attempt to delete the file
		if (unlink($path)) {
			echo 'File deleted successfully. Redirecting to index page in 2 seconds...';
			header("Refresh: 2; URL=index.php");
		} else {
			echo 'Error deleting file.';
		}
	}
?>
