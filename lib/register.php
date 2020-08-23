<?php

function register($username, $email, $hashedpassword, $conn) {
	$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $username, $email, $hashedpassword);
	$stmt->execute();
	$stmt->close();
	return true;
}

?>