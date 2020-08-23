<?php
function login($username, $hashedpassword, $conn) {
	$stmt = $conn->prepare("SELECT password FROM `users` WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!mysqli_num_rows($result)){ { return false; } }
	$row = $result->fetch_assoc();
	
	if(!password_verify($_POST['password'], $hashedpassword)){ $error = "incorrect username or password"; return false; }
	
	if(isset($error)) {
		return $error;
	} else {
		return true;
	}
}
?>