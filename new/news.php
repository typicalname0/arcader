<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/create.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - new news</title>
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
					$title = htmlspecialchars($_POST['title']);
					$description = htmlspecialchars($_POST['description']);
					
					create('news', $title, $description, $_SESSION['user'], '', '', $conn);
				}
			?><br>
			<h1>new news</h1><br>
			<form method="post">
				<fieldset>
					<input size="69" type="text" placeholder="News Title" name="title"><br><br>
					<textarea required cols="81" placeholder="Information about your news" name="description"></textarea><br><br>
					<input required type="checkbox" name="remember"><small>This news post will <b>NOT</b> break the Terms Of Service.</small><br>
					<input type="submit" value="Submit" name="submit">  <small>Note: News Posts are manually approved.</small>
				</fieldset>
            </form>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>