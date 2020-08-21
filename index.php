<!DOCTYPE html>
<!--
Riiise and shiiine Mr. Freeman... Rise and shine...

m4gicity
- config.inc.php [config]
- /static/ [static images]
- /dynamic/ [dynamic images]
- /css/ [css]
- /lib/ [functions]

-->
<?php
require(__DIR__ . "/config.inc.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
				require(__DIR__ . "/lib/misc/header.php");
			?><br>
			PLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDERPLACEHOLDER
		</div>
		<?php
		require(__DIR__ . "/lib/misc/footer.php");
		?>
	</body>
</html>