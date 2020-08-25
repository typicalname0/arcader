<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
?>
<html>
	<head>
	<title><?php echo $config['project_name']; ?> - following</title>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php 
			require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?>
			<h1>fans that you followed</h1>
			<?php
			$stmt = $conn->prepare("SELECT * FROM fan WHERE follower = ? ORDER BY id DESC");
			$stmt->bind_param("s", $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 0) echo('You are not following anyone.');
			while($row = $result->fetch_assoc()) { ?>
				<a href="/view/profile?id=<?php echo getID($row['following'], $conn); ?>"><?php echo $row['following']; ?></a>
			<?php } ?>
			<br><br>
			<h1>fans</h1>
			<?php
			$stmt = $conn->prepare("SELECT * FROM fan WHERE following = ? ORDER BY id DESC");
			$stmt->bind_param("s", $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 0) echo('You do not have any fans.');
			while($row = $result->fetch_assoc()) { ?>
				<a href="/view/profile?id=<?php echo getID($row['follower'], $conn); ?>"><?php echo $row['follower']; ?></a>
			<?php } ?>
		</div>
		<br>

		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>