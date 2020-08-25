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
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");

?>
<html>
	<head>
		<style>
		.left {
			float: left;
			width: calc(50% - 20px);
		}

		.right {
			float: right;
			width: calc(50% - 20px);
		}
		</style>
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?><br>
			<h1>front-page</h1>
			<a href="/new/video">Upload Video</a><br>
			<a href="/new/image">Upload Image</a><br>
			<a href="/new/news">New News</a><br>
			<a href="/new/game">Upload Game</a><br><hr>
			
			Welcome to <b>Arcader.</b><br><br>You can reply to people's uploaded files, or customize your profile with custom CSS. We hope you have a good time here. <small>Our Discord is at the Contact Us button at the footer.</small>
			<br><br>
			<div class="right">
				<?php 
				$stmt = $conn->prepare("SELECT * FROM files WHERE status = 'y' ORDER BY id DESC LIMIT 3");
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows === 0) return('Item doesnt exist.');
				while($row = $result->fetch_assoc()) { ?>
				<div class="section" style="padding-bottom: 5px;">
					<div class="topSection">
						<b><?php echo $row['type']; ?></b>
					</div><br>
					
					<img id="commentPFP" style="position: absolute; height: 50px;" src="/dynamic/pfp/<?php echo getPFP($row['author'], $conn)?>">
						<span id="sectionPadding"><a href="view/reply?id=<?php echo $row['id']; ?>"><b><?php echo $row['title']; ?></b></a><br></span>
						<span id="sectionPadding"><?php echo $row['author']; ?> — <?php echo $row['date']; ?><br></span><br><?php echo $row['extrainfo']; ?>
						<br>
						<center>
							<?php if($row['type'] == "game") {?>
							
							<?php } else if($row['type'] == "news") {} else if($row['type'] == "image") {?>
								<img style="width: 321px; height: 302px;" src="/dynamic/image/<?php echo $row['filename']; ?>">
							<?php } else {?>
								<video width="340" height="250" controls>
									<source src="/dynamic/video/<?php echo $row['filename']; ?>">
								</video> 
							<?php } ?>
						</center>
				</div><br>
				<?php } ?>
			</div>
			<div class="left">
				<div class="section" style="padding-bottom: 5px;">
					<div class="topSection">
						<b>users</b>
					</div><br>
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
			</div>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>