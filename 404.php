<!DOCTYPE html>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); ?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - 404</title>
		<link rel="stylesheet" href="/static/css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?><br>
			404, the page you requested was not found on the server. <a href="javascript:history.back()"><small>Go Back</small></a>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>