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
			<h1>terms of service</h1>
			<p>
				You must follow our Content Guidelines and can't use our site to post pornographic material, harass people, send spam, etc. Be reasonable and responsible, don't do anything stupid, and you'll be fine.<br>
				<br>
				Don't try to abuse loopholes.<br><br>Do not enocurage/support harrassment on the site.
				<br><br>tl;dr just don't be stupid :)
			</p>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>
