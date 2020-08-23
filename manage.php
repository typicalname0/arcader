<!DOCTYPE html>
<?php
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
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
				
				if(!isset($_SESSION['user'])) {
					die("You are not logged in.");
				} else {
					$user = getUserFromUsername($_SESSION['user'], $conn);
				}
				
				if(@$_POST['bioset']) {
					$stmt = $conn->prepare("UPDATE users SET bio = ? WHERE `users`.`username` = ?;");
					$stmt->bind_param("ss", $text, $_SESSION['user']);
					$text = $_POST['bio'];
					$stmt->execute(); 
					$stmt->close();
					header("Location: manage.php");
				} else if(@$_POST['age']) {
					$stmt = $conn->prepare("UPDATE users SET age = ? WHERE `users`.`username` = ?;");
					$stmt->bind_param("ss", $age, $_SESSION['user']);
					$age = htmlspecialchars($_POST['age']);
					$stmt->execute(); 
					$stmt->close();
					header("Location: manage.php");
				} else if(@$_POST['location']) {
					$stmt = $conn->prepare("UPDATE users SET location = ? WHERE `users`.`username` = ?;");
					$stmt->bind_param("ss", $location, $_SESSION['user']);
					$location = htmlspecialchars($_POST['location']);
					$stmt->execute(); 
					$stmt->close();
					header("Location: manage.php");
				} else if(@$_POST['gender']) {
					$stmt = $conn->prepare("UPDATE users SET gender = ? WHERE `users`.`username` = ?;");
					$stmt->bind_param("ss", $gender, $_SESSION['user']);
					$gender = htmlspecialchars($_POST['gender']);
					$stmt->execute(); 
					$stmt->close();
					header("Location: manage.php");
				} else if(@$_POST['cssset']) {
					$stmt = $conn->prepare("UPDATE users SET css = ? WHERE `users`.`username` = ?;");
					$stmt->bind_param("ss", $validatedcss, $_SESSION['user']);
					$validatedcss = validateCSS($_POST['css']);
					$stmt->execute(); 
					$stmt->close();
					header("Location: manage.php");
				} else if(@$_POST['pfpset']) {
					
					//This is terribly awful and i will probably put this in a function soon
					$target_dir = "dynamic/pfp/";
					$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
					$target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;

					$target_file = $target_dir . $target_name;
					
					$uploadOk = true;
					$movedFile = false;

					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
						$fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
						$uploadOk = false;
					}

					if (file_exists($target_file)) {
						$movedFile = true;
					} else {
						$movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
					}

					if ($uploadOk) {
						if ($movedFile) {
							$stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE `users`.`username` = ?;");
							$stmt->bind_param("ss", $target_name, $_SESSION['user']);
							$stmt->execute(); 
							$stmt->close();
						} else {
							$fileerror = 'fatal error';
						}
					}
				} else if(@$_POST['songset']) {
					$uploadOk = true;
					$movedFile = false;

					$target_dir = "dynamic/song/";
					$songFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
					$target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $songFileType;
				   

					$target_file = $target_dir . $target_name;

					if($songFileType != "ogg" && $songFileType != "mp3") {
						echo 'unsupported file type. must be mp3 or ogg<hr>';
						$uploadOk = false;
					}

					if (file_exists($target_file)) {
						$movedFile = true;
					} else {
						$movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
					}

					if ($uploadOk) {
						if ($movedFile) {
							$stmt = $conn->prepare("UPDATE users SET music = ? WHERE `users`.`username` = ?;");
							$stmt->bind_param("ss", $target_name, $_SESSION['user']);
							$stmt->execute(); 
							$stmt->close();
						} else {
							echo 'fatal error' . $_FILES["fileToUpload"]["error"] . '<hr>';
						}
					}
				}
			?>
			<br>
			<h1>Music & Profile Picture</h1>
			the below form is for your profile picture and music.<br>
			<?php if(isset($fileerror)) { echo "<small style='color:red'>" . $fileerror . "</small>"; } ?><br>
			<img style="height: 60px;" src="/dynamic/pfp/<?php echo $user['pfp']; ?>"><br>
			
			
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<b>Profile Picture</b><br>
					<input type="file" name="fileToUpload" id="fileToUpload">
					<input type="submit" value="Upload Image" name="pfpset">
				</fieldset>
			</form><br><br>
			
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<b>Song</b><br>
					<input type="file" name="fileToUpload" id="fileToUpload">
					<input type="submit" value="Upload Song" name="songset">
				</fieldset>
			</form>
			<br><hr>
			<h1>Misc.</h1>
			the below form is for CSS, bios, and other stuff.<br>
			<?php if(isset($error)) { echo "<small style='color:red'>" . $error . "</small>"; } ?><br>
			
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<b>Bio</b><br>
					<textarea required cols="58" placeholder="Bio" name="bio"><?php echo $user['bio'];?></textarea><br>
					<input name="bioset" type="submit" value="Set">
				</fieldset>
			</form><br>
			
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<b>CSS</b><br>
					<textarea required rows="15" cols="58" placeholder="Your CSS" name="css" id="css_code"><?php echo $user['css']?></textarea><br>
					<input name="cssset" type="submit" value="Set">
				</fieldset>
			</form><br>
			
			
			<form method="post">
				<fieldset>
					<b>Age</b> <br><input type="text" name="age" required="required" row="4"></b><br>
					<input type="submit" value="Set" name="set">
				</fieldset>
			</form><br>
			
			<form method="post">
				<fieldset>
					<b>Location</b> <br><input type="text" name="location" required="required" row="4"></b><br>
					<input type="submit" value="Set" name="set">
				</fieldset>
			</form><br>
			
			<form method="post">
				<fieldset>
					<b>Gender</b> <br><input type="text" name="gender" required="required" row="4"></b><br>
					<input type="submit" value="Set" name="set">
				</fieldset>
			</form><br>

		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>