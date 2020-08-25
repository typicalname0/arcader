<!DOCTYPE html>
<?php
require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/register.php");
?>
<html>
	<head>
		<title><?php echo $config['project_name']; ?> - index</title>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
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
					
			        if($_POST['password'] !== $_POST['confirm']){ $error = "password and confirmation password do not match"; goto skip; }

                    if(strlen($username) > 21) { $error = "your username must be shorter than 21 characters"; goto skip; }
                    if(strlen($password) < 8) { $error = "your password must be at least 8 characters long"; goto skip; }
                    if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) { $error = "please include both letters and numbers in your password"; goto skip; }
					if(!isset($_POST['g-recaptcha-response'])){ $error = "captcha validation failed"; goto skip; }
					if(!validateCaptcha($config['recaptcha_secret'], $_POST['g-recaptcha-response'])) { $error = "captcha validation failed"; goto skip; }

					$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows) { $error = "there's already a user with that same name!"; goto skip; }
					
					if(register($username, $email, $passwordhash, $conn)) {
						$_SESSION['user'] = htmlspecialchars($username);
					} else {
						$error = "There was an unknown error making your account.";
					}	
				}
				skip:
				
			?>
			<h1>register</h1>
			fill in the form below to become a member of <?php echo $config['project_name']; ?>.<br><br>
			<form method="post" id="submitform">
				<fieldset>
					<?php if(isset($error)) { echo "<small style='color:red'>" . $error . "</small>"; } ?><br>
					<input required placeholder="Username" type="text" name="username"> <small>(Must be shorter than 21 characters)</small><br>
					<input required placeholder="E-Mail" type="email" name="email"><br><br>
					<input required placeholder="Password" type="password" name="password"> <small>(Must be longer than 8 characters & must include letters and numbers)</small><br>
					<input required placeholder="Confirm Password" type="password" name="confirm"><br><br>
					<input type="submit" value="Register" class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_sitekey']; ?>" data-callback="onLogin"><br><br>
					Please view our <a href="privacy">Privacy Policy</a> and <a href="tos">our Terms & Conditions</a>. 
				</fieldset>
            </form>
		</div>
		<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/lib/misc/footer.php");
		?>
	</body>
</html>