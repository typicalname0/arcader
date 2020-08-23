<!DOCTYPE html>
<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - profile</title>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="stylesheet" href="/static/css/profile.css">
	</head>
	<body>
		<div class="container">
			<?php
				require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/header.php");

				if($_SERVER['REQUEST_METHOD'] == 'POST') {
					if(!isset($_SESSION['user'])){ $error = "you are not logged in"; goto skipcomment; }
					if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
					if(strlen($_POST['comment']) > 500){ $error = "your comment must be shorter than 500 characters"; goto skipcomment; }
					if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
					if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }

					$stmt = $conn->prepare("INSERT INTO `comments` (toid, author, text, rating) VALUES (?, ?, ?, ?)");
					$stmt->bind_param("ssss", $_GET['id'], $_SESSION['user'], $text, $rating);
					$rating = (int)$_POST['rating'];
					$text = htmlspecialchars($_POST['comment']);
					$stmt->execute();
					$stmt->close();
					skipcomment:
				}
			?><br>
			
			<style>
				<?php echo $user['css']; ?>
			</style>
			<div class="section" style="padding-bottom: 5px;">
				<?php $games = getItem($_GET['id'], $conn); if($games == "Item doesnt exist.") { echo "This user has no games."; } else {?>
				<div class="topSection">
					<b><?php echo $games['type']; ?></b>
				</div><br>
				<img id="commentPFP" style="position: absolute; height: 50px;" src="/dynamic/pfp/<?php echo getPFP($games['author'], $conn)?>">
					<span id="sectionPadding"><a href="reply?id=<?php echo $games['id']; ?>"><b><?php echo $games['title']; ?></b></a><br></span>
					<span id="sectionPadding"><?php echo $games['author']; ?> — <?php echo $games['date']; ?><br></span><br><?php echo $games['extrainfo']; ?>
					<br><br>
					<center>
						<?php if($games['type'] == "game") {?>
						<object width="450" height="400">
							<param name="movie" value="/dynamic/game/<?php echo $games['filename']; ?>">
							<embed src="/dynamic/game/<?php echo $games['filename']; ?>" width="640" height="480">
							</embed>
						</object>
						<?php } else if($games['type'] == "news") {} else if($games['type'] == "image") {?>
							<img style="width: 321px; height: 302px;" src="/dynamic/image/<?php echo $games['filename']; ?>">
						<?php } else {?>
							<video width="440" height="300" controls>
								<source src="/dynamic/video/<?php echo $games['filename']; ?>">
							</video> 
						<?php } ?>
					</center>
				<br><?php } ?>
			</div><br>
			
			<div class="section" style="padding-bottom: 5px;">
				<div class="topSection">
					<b>reply</b>
				</div><br>
					<form method="post" id="submitform">
						<b>Rating</b><br>
						<input required min="1" max="10" type="number" placeholder="Rating" name="rating"><br><br>
						<b>Comment</b><br>
                        <textarea required cols="33" placeholder="Comment" name="comment"></textarea><br>
                        <input type="submit" value="Post" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin">
                    </form>
				<br>
			</div><br>
			
			<?php
			$stmt = $conn->prepare("SELECT * FROM comments WHERE toid = ? ORDER BY id DESC");
			$stmt->bind_param("i", $_GET['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows === 0) return('Item doesnt exist.');
			while($row = $result->fetch_assoc()) { ?>
			<div class="section" style="padding-bottom: 5px;">
				<div class="topSection">
					<b>comment</b>
				</div><br>
					<img id="commentPFP" style="position: absolute; height: 50px;" src="/dynamic/pfp/<?php echo getPFP($row['author'], $conn)?>">
					<span id="sectionPadding"><b><a href="profile?id=<?php echo getID($row['author'], $conn); ?>"><?php echo $row['author']; ?></a></b> — <?php echo $row['date']; ?></span><br>
					<span id="sectionPadding"><?php echo $row['rating']; ?>/10<br></span><br>
					<?php echo $row['text']; ?>
				<br>
			</div><br>
			<?php } ?>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>