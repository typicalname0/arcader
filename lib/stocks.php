<?php
function doesStockExist($name, $connection) {
	$stmt = $connection->prepare("SELECT * FROM stocknames WHERE coname = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) { return false; } else { return true;}
	$stmt->close();
}

function getStockPrice($name, $connection) {
	$stmt = $connection->prepare("SELECT * FROM stocknames WHERE coname = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 0) return('error');
	while($row = $result->fetch_assoc()) {
		$price = $row['price'];
	} 
	$stmt->close();
	return $price;
}

function checkIfOwnsStock($name, $id, $connection) {
	$stmt = $connection->prepare("SELECT * FROM stocks WHERE owner = ? AND id = ?");
	$stmt->bind_param("ss", $name, $id);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows === 1) { return true; } else { return false; }
	$stmt->close();
}
?>