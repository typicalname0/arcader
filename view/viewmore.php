<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(!isset($_GET['id'])) {
	die("ID is not set.");
} else {
	$user = getUserFromId($_GET['id'], $conn);
	$style = hash('sha256', $user['css']);
	$style = base64_encode($style);
}

$captchaRS = generateRandomString();
?>
<html>
	<head>
		<meta http-equiv="Content-Security-Policy" content="default-src 'self' *.google.com *.gstatic.com; img-src 'self' images.weserv.nl; style-src 'self' 'unsafe-inline';">
		<title><?php echo $config['project_name']; ?> - profile</title>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script src="/onLogin.js"></script>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php 
			require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");
			?>
			
			<?php
				if(isset($_GET['id'])) {
					$name = getName((int)$_GET['id'], $conn);
				} else {
					die("Please specify the user's ID.");
				}
			?>
			<h1><?php echo $name; ?>'s Files</h1><br>
			<?php
			$stmt = $conn->prepare("SELECT * FROM files WHERE author = ? AND status = 'y' ORDER BY id DESC");
			$stmt->bind_param("s", $name);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 0) echo('This user has no uploaded files.');
			while($row = $result->fetch_assoc()) { ?>
			<div class="section" style="padding-bottom: 5px;">
				<div class="topSection">
					<b><?php echo $row['type']; ?></b>
				</div><br>
				
				<img id="commentPFP" style="position: absolute; height: 50px;" src="/dynamic/pfp/<?php echo getPFP($row['author'], $conn)?>">
					<span id="sectionPadding"><a href="/view/reply?id=<?php echo $row['id']; ?>"><b><?php echo $row['title']; ?></b></a><br></span>
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
		<br>

		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>