<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$filter = array("@everyone", "@here");
$name = str_replace($filter, "", $_SESSION['user']);

require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
require($_SERVER['DOCUMENT_ROOT'] . "/lib/stocks.php");

if(isset($_SESSION['user']) && isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM stocks WHERE id = ?");
	$stmt->bind_param("s", $_GET['id']);
	$stmt->execute();
	$result = $stmt->get_result();
	while($row = $result->fetch_assoc()) {
        $stockName = $row['stockname'];
        $amount = $row['amount'];
	} 
	$stmt->close();

    $currentBobux = floatval(getBobux($_SESSION['user'], $conn));
    $stockAmount = (int)htmlspecialchars($amount);
    $stockPrice = getStockPrice($stockName, $conn);

    if($stockPrice < 0) {
        die("THIS STOCK HAS CRASHED!");
    }

    $stockPrice = $stockPrice * ((rand(1, 5) / 85) + 1);

    if(checkIfOwnsStock($_SESSION['user'], $_GET['id'], $conn) != true) {
        die("You do not own this stock!");
    } 
    
    $final = $currentBobux + ($stockAmount * $stockPrice);

    $stmt = $conn->prepare("UPDATE users SET bobux = ? WHERE username = ?");
    $stmt->bind_param("ds", $final, $_SESSION['user']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM stocks WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $stmt->close();

    webhookSend($config['discord_webhook'], $name . " has sold " . $stockAmount . " of " . $stockName, "Stock Sold");

    header("Location: index.php");
} else {
    die("you aren't logged in or didnt provide enough arguments");
}
?>