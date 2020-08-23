<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - new game</title>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
				
				if(!isset($_SESSION['user'])) {
					die("You aren't logged in.");
				}
				
				if(@$_POST['submit']) {
					$register = require($_SERVER['DOCUMENT_ROOT'] . "/lib/upload.php");
					$register("image", ["gif", "png", "jpg", "jpeg"], $conn);
				}
			?><br>
			<h1>new image</h1><br>
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<small>Select a image file:</small>
					<input type="file" name="fileToUpload" id="fileToUpload"><br>
					<input required type="checkbox" name="remember"><small>This image will not infringe any copyright laws AND is not NSFW</small><br>
					<input required type="checkbox" name="remember"><small>This image will <b>NOT</b> break the Terms Of Service.</small>
					<hr>
					<input size="69" type="text" placeholder="Image Title" name="title"><br><br>
					<textarea required cols="81" placeholder="Information about your image" name="description"></textarea><br><br>
					<input type="submit" value="Upload Image" name="submit">  <small>Note: Images are manually approved.</small>
				</fieldset>
            </form>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>