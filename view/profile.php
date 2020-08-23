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
				
				if($_SERVER['REQUEST_METHOD'] == 'POST') {
					if(!isset($_SESSION['user'])){ $error = "you are not logged in"; goto skipcomment; }
					if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
					if(strlen($_POST['comment']) > 500){ $error = "your comment must be shorter than 500 characters"; goto skipcomment; }
					if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skipcomment; }
					if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skipcomment; }

					$stmt = $conn->prepare("INSERT INTO `profilecomments` (toid, author, text) VALUES (?, ?, ?)");
					$stmt->bind_param("sss", $_GET['id'], $_SESSION['user'], $text);
					$text = htmlspecialchars($_POST['comment']);
					$stmt->execute();
					$stmt->close();
					skipcomment:
				}
			?><br>
			
			<style><?php echo $user['css']; ?></style>
			
			<div class="leftHalf">
				<div id="userInfo">
					<h1><?php echo $user['username']; ?></h1><br>
					<img id="pfp" src="/dynamic/pfp/<?php echo $user['pfp']; ?>"><br>
					<audio autoplay controls>
						<source src="/dynamic/song/<?php echo $user['music']; ?>">
					</audio><br>
					<?php echo str_replace(PHP_EOL, "<br>", $user['bio']);?>
					<hr>
					<img src="/static/img/silk/house.png"> <b>Location: </b><?php echo $user['location']; ?><br>
					<img src="/static/img/silk/user.png"> <b>Age: </b><?php echo $user['age']; ?><br>
					<img src="/static/img/silk/brick.png"> <b>Gender: </b><?php echo $user['gender']; ?><br>
					<img src="/static/img/silk/calendar.png"> <b>Joined On: </b><?php echo $user['date']; ?><br>
				</div>
			</div>
			
			<div class="rightHalf">
				<div class="section">
					<div class="topSection">
						<img src="/static/img/silk/table.png"> <b>Latest News</b> — <a href="viewmore?id=<?php echo (int)$_GET['id']; ?>">View More</a>
					</div><br>
					<?php $news = getLatestItem('news', 'username', $user['username'], $conn); if($news == "Item doesnt exist.") { echo "This user has no news."; } else {?>
					<img id="commentPFP" src="/dynamic/pfp/<?php echo getPFP($news['author'], $conn)?>">
						<span id="sectionPadding"><a href="reply?id=<?php echo $news['id']; ?>"><b><?php echo $news['title']; ?></b></a><br></span>
						<span id="sectionPadding"><?php echo $news['author']; ?> — <?php echo $news['date']; ?><br></span><br><?php echo $news['extrainfo']; ?>
					<br><?php } ?>
				</div><br>
				<div class="section">
					<div class="topSection">
						<img src="/static/img/silk/controller.png"> <b>Latest Games</b> — <a href="viewmore?id=<?php echo (int)$_GET['id']; ?>">View More</a>
					</div><br>
					<?php $games = getLatestItem('game', 'username', $user['username'], $conn); if($games == "Item doesnt exist.") { echo "This user has no games."; } else {?>
					<img id="commentPFP" src="/dynamic/pfp/<?php echo getPFP($games['author'], $conn)?>">
						<span id="sectionPadding"><a href="reply?id=<?php echo $games['id']; ?>"><b><?php echo $games['title']; ?></b></a><br></span>
						<span id="sectionPadding"><?php echo $games['author']; ?> — <?php echo $games['date']; ?><br></span><br><?php echo $games['extrainfo']; ?>
						<br><br>
					    <object width="450" height="400">
							<param name="movie" value="/dynamic/game/<?php echo $games['filename']; ?>">
							<embed src="/dynamic/game/<?php echo $games['filename']; ?>" width="440" height="300">
							</embed>
						</object>
					<br><?php } ?>
				</div><br>
				<div class="section">
					<div class="topSection">
						<img src="/static/img/silk/television.png"> <b>Latest Videos</b> — <a href="viewmore?id=<?php echo (int)$_GET['id']; ?>">View More</a>
					</div><br>
					<?php $video = getLatestItem('video', 'username', $user['username'], $conn); if($video == "Item doesnt exist.") { echo "This user has no video."; } else {?>
					<img id="commentPFP" src="/dynamic/pfp/<?php echo getPFP($video['author'], $conn)?>">
						<span id="sectionPadding"><a href="reply?id=<?php echo $video['id']; ?>"><b><?php echo $video['title']; ?></b></a><br></span>
						<span id="sectionPadding"><?php echo $video['author']; ?> — <?php echo $video['date']; ?><br></span><br><?php echo $video['extrainfo']; ?>
						<br><br>
						<video width="440" height="300" controls>
							<source src="/dynamic/video/<?php echo $video['filename']; ?>">
						</video> 
					<br><?php } ?>
				</div><br>
				<div class="section">
					<div class="topSection">
						<img src="/static/img/silk/image.png"> <b>Latest Images</b> — <a href="viewmore?id=<?php echo (int)$_GET['id']; ?>">View More</a>
					</div><br>
					<?php $image = getLatestItem('image', 'username', $user['username'], $conn); if($image == "Item doesnt exist.") { echo "This user has no image."; } else {?>
					<img id="commentPFP" src="/dynamic/pfp/<?php echo getPFP($image['author'], $conn)?>">
						<span id="sectionPadding"><a href="reply?id=<?php echo $image['id']; ?>"><b><?php echo $image['title']; ?></b></a><br></span>
						<span id="sectionPadding"><?php echo $image['author']; ?> — <?php echo $image['date']; ?><br></span><br><?php echo $image['extrainfo']; ?>
						<br><br>
						<img id="containerImage" src="/dynamic/image/<?php echo $image['filename']; ?>"> 
					<br><?php } ?>
				</div><br>
				
				<div class="section">
					<div class="topSection">
						<b>reply</b>
					</div><br>
						<form method="post" id="submitform">
							<b>Comment</b><br>
							<textarea required cols="33" placeholder="Comment" name="comment"></textarea><br>
							<input type="submit" value="Post" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin">
						</form>
					<br>
				</div><br>
				
				<?php
				$stmt = $conn->prepare("SELECT * FROM profilecomments WHERE toid = ? ORDER BY id DESC");
				$stmt->bind_param("i", $_GET['id']);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows === 0) return('Item doesnt exist.');
				while($row = $result->fetch_assoc()) { ?>
				<div class="section">
					<div class="topSection">
						<b>comment</b>
					</div><br>
						<img id="commentPFP" src="/dynamic/pfp/<?php echo getPFP($row['author'], $conn)?>">
						<span id="sectionPadding"><b><a href="profile?id=<?php echo getID($row['author'], $conn); ?>"><?php echo $row['author']; ?></a></b> — <?php echo $row['date']; ?></span><br>
						<br><br>
						<?php echo $row['text']; ?>
					<br>
				</div><br>
				<?php } ?>
			</div>
		</div>
		<br>

		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>