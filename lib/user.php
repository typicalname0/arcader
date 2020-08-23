<?php
function getUserFromId($id, $connection) {
	$userResult = array();
	$stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) die('That user does not exist.');
	while($row = $result->fetch_assoc()) {
		$userResult['username'] = $row['username'];
		$userResult['id'] = $row['id'];
		$userResult['date'] = $row['date'];
		$userResult['bio'] = $row['bio'];
		$userResult['css'] = $row['css'];
		$userResult['pfp'] = $row['pfp'];
		$userResult['music'] = $row['music'];
	
		$userResult['location'] = $row['location'];
		$userResult['age'] = $row['age'];
		$userResult['gender'] = $row['gender'];
	}
	$stmt->close();

	return $userResult;
}

function getUserFromUsername($username, $connection) {
	$userResult = array();
	$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) die('That user does not exist.');
	while($row = $result->fetch_assoc()) {
		$userResult['username'] = $row['username'];
		$userResult['id'] = $row['id'];
		$userResult['date'] = $row['date'];
		$userResult['bio'] = $row['bio'];
		$userResult['css'] = $row['css'];
		$userResult['pfp'] = $row['pfp'];
		$userResult['music'] = $row['music'];
		
		$userResult['location'] = $row['location'];
		$userResult['age'] = $row['age'];
		$userResult['gender'] = $row['gender'];
	}
	$stmt->close();

	return $userResult;
}

function getPFP($user, $connection) {
	$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) return('error');
	while($row = $result->fetch_assoc()) {
		$pfp = htmlspecialchars($row['pfp']);
	} 
	$stmt->close();
	return $pfp;
}

function getLatestItem($itemType, $type, $username, $connection) {
	$itemResult = array();
	if($type == "id") {
		$stmt = $connection->prepare("SELECT * FROM files WHERE id = ? AND type = ? AND status = 'y' ORDER BY id DESC LIMIT 1");
		$stmt->bind_param("is", $username, $itemType);
		$stmt->execute();
		$result = $stmt->get_result();	
	} else if($type == "username") {
		$stmt = $connection->prepare("SELECT * FROM files WHERE author = ? AND type = ? AND status = 'y' ORDER BY id DESC LIMIT 1");
		$stmt->bind_param("ss", $username, $itemType);
		$stmt->execute();
		$result = $stmt->get_result();
	}
	
	if($result->num_rows === 0) return('Item doesnt exist.');
	while($row = $result->fetch_assoc()) {
		$itemResult['id'] = $row['id'];
		$itemResult['type'] = $row['type'];
		$itemResult['title'] = $row['title'];
		$itemResult['extrainfo'] = $row['extrainfo'];
		$itemResult['author'] = $row['author'];
		$itemResult['filename'] = $row['filename'];
		$itemResult['date'] = $row['date'];
		$itemResult['status'] = $row['status'];
		$itemResult['agerating'] = $row['agerating'];
		$itemResult['thumbnail'] = $row['thumbnail'];
	}
	$stmt->close();

	return $itemResult;
}

function getID($user, $connection) {
	$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) return 'error';
	while($row = $result->fetch_assoc()) {
		$id = $row['id'];
	} 
	$stmt->close();
	return $id;
}

function getItem($id, $connection) {
	$itemResult = array();
	$stmt = $connection->prepare("SELECT * FROM files WHERE id = ? AND status = 'y'");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if($result->num_rows === 0) return('Item doesnt exist.');
	while($row = $result->fetch_assoc()) {
		$itemResult['id'] = $row['id'];
		$itemResult['type'] = $row['type'];
		$itemResult['title'] = $row['title'];
		$itemResult['extrainfo'] = $row['extrainfo'];
		$itemResult['author'] = $row['author'];
		$itemResult['filename'] = $row['filename'];
		$itemResult['date'] = $row['date'];
		$itemResult['status'] = $row['status'];
		$itemResult['agerating'] = $row['agerating'];
		$itemResult['thumbnail'] = $row['thumbnail'];
	}
	$stmt->close();

	return $itemResult;
}

function validateCSS($validate) {
	$DISALLOWED = array("<?php", "?>", "behavior: url", ".php", "@import", "@\import", "@/import"); 

	$validated = str_replace($DISALLOWED, "", $validate);
    return $validated;
}
?>