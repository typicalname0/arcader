<!DOCTYPE html>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); ?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?>
			<h1>privacy</h1>
			<p>
				We hash your passwords with BCRYPT.<br>
				We use MySQLI.<br>
				We do not store your IP anywhere on the site.<br>
				Our source code is on <a href="https://github.com/typicalname0/arcader">GitHub.</a>
			</p>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>
