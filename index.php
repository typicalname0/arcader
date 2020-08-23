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
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?><br>
			Welcome to <b>Arcader.</b><br><br>You can reply to people's uploaded files, or customize your profile with custom CSS. We hope you have a good time here. <small>Our Discord is at the Contact Us button at the footer.</small>
			<br><br>
			<a href="https://spacemy.xyz/new/video">Upload Video</a><br>
			<a href="https://spacemy.xyz/new/image">Upload Image</a><br>
			<a href="https://spacemy.xyz/new/news">New News</a><br>
			<a href="https://spacemy.xyz/new/game">Upload Game</a><br><hr>
			
			<?php 
			$stmt = $conn->prepare("SELECT * FROM users");
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 0) return('Item doesnt exist.');
			while($row = $result->fetch_assoc()) { 
				echo "<a href='/view/profile?id=" . $row['id'] . "'>" . $row['username'] . "</a><br>";
			}
			?>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>