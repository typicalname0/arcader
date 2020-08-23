<?php
function create($type, $title, $extrainfo, $author, $filename, $thumbnail, $conn) {
	$stmt = $conn->prepare("INSERT INTO files (type, title, extrainfo, author, filename, thumbnail) VALUES ('news', ?, ?, ?, '', '')");
	$stmt->bind_param("sss", $title, $extrainfo, $_SESSION['user']);

	$stmt->execute();
	$stmt->close();
}
?>