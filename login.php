<!DOCTYPE html>
<?php
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/login.php");
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
			    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username']) {
                    $email = htmlspecialchars(@$_POST['email']);
                    $username = htmlspecialchars(@$_POST['username']);
                    $password = @$_POST['password'];
                    $passwordhash = password_hash(@$password, PASSWORD_DEFAULT);
					
					$stmt = $conn->prepare("SELECT password FROM `users` WHERE username=?");
					$stmt->bind_param("s", $username);
					$stmt->execute();
					$result = $stmt->get_result();
					if(!mysqli_num_rows($result)){ { $error = "incorrect username or password"; goto skip; } }
					
					$row = $result->fetch_assoc();
					$hash = $row['password'];
					
					if(!password_verify($password, $hash)){ $error = "incorrect username or password"; goto skip; }
					
					$_SESSION['user'] = $username;
					
					header("Location: /manage");
				}
				skip:

			?>
			<h1>login</h1>
			fill in the form below to login to your existing account.<br><br>
			<form method="post">
				<fieldset>
					<?php if(isset($error)) { echo "<small style='color:red'>" . $error . "</small>"; } ?><br>
					<input required placeholder="Username" type="text" name="username"><br>
					<input required placeholder="Password" type="password" name="password"><br><br>
					<input type="submit" value="Login"><br>
				</fieldset>
            </form>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>