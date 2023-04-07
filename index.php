<?php
	session_start();

	// Check if the user is authenticated
	if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
		header('Location: login.php');
		exit;
	}

	// Delete files that are more than one hour old
	foreach (glob('*.*') as $file) {
		if (time() - filemtime($file) >= 3600) {
			unlink($file);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Simple File Repo</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
		<h1 class="title">Simple File Repo</h1>
		<p class="subtitle">Files will be automatically deleted if more than one hour old.</p>
		<!-- Show the upload form only to authenticated users -->
		<?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']): ?>
			<h2>Upload File:</h2>
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload File" name="submit">
			</form>
		<?php endif; ?>
		<ul>
			<?php
				// Set the directory you want to read from
				$dir = ".";
				// Open the directory
				if ($dh = opendir($dir)) {
					// Loop through all the files in the directory
					while (($file = readdir($dh)) !== false) {
						// Ignore hidden files, PHP files and CSS files
						if ($file[0] == '.' || pathinfo($file, PATHINFO_EXTENSION) == 'php' || pathinfo($file, PATHINFO_EXTENSION) == 'css') {
							continue;
						}
						// Output the filename as a link to download the file and a delete link
						echo '<li><a href="'.$file.'">'.$file.'</a>';
						// Show the delete link only to authenticated users
						if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
							echo ' <a href="delete.php?file='.$file.'" class="delete-button">(delete)</a>';
						}
						echo '</li>';
					}
					// Close the directory
					closedir($dh);
				}
			?>
		</ul>
		<?php
			if (count(glob("*")) == 1) {
				echo '<p>No files to display.</p>';
			}
		?>
	</div>
</body>
</html>
