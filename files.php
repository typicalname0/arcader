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
		<title><?php echo $config['project_name']; ?> - index</title>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?><br>
			This is where all of the newest 5 files are located. If you want to look at a specific user's files, go to their profile and click <b>View More.</b><br><br>
			
			<?php 
			$stmt = $conn->prepare("SELECT * FROM files WHERE status = 'y' ORDER BY id DESC LIMIT 5");
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
					<br><br>
					<center>
						<?php if($row['type'] == "game") {?>
						<object width="450" height="400">
							<param name="movie" value="/dynamic/game/<?php echo $row['filename']; ?>">
							<embed src="/dynamic/game/<?php echo $row['filename']; ?>" width="640" height="480">
							</embed>
						</object>
						<?php } else if($row['type'] == "news") {} else if($row['type'] == "image") {?>
							<img style="width: 321px; height: 302px;" src="/dynamic/image/<?php echo $row['filename']; ?>">
						<?php } else {?>
							<video width="440" height="300" controls>
								<source src="/dynamic/video/<?php echo $row['filename']; ?>">
							</video> 
						<?php } ?>
					</center>
			</div><br>
			<?php } ?>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>