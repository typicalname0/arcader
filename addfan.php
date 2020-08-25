<?php 
session_start();

require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");

if(isset($_GET['id'])) {
	$following = getName((int)$_GET['id'], $conn);
	$sender = htmlspecialchars($_SESSION['user']);
	
	$stmt = $conn->prepare("SELECT * FROM fan WHERE following = ? AND follower = ?");
	$stmt->bind_param("ss", $following, $sender);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if($result->num_rows == 1) die('You already followed this person!');
	
	$stmt = $conn->prepare("INSERT INTO fan (following, follower) VALUES (?, ?)");
	$stmt->bind_param("ss", $following, $sender);
	$stmt->execute();
	$stmt->close();
	
	header("Location: following");
}
?>
