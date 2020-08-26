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
if(isset($_SESSION['user']) && isset($_GET['name']) && isset($_GET['amount'])) {
    $currentBobux = floatval(getBobux($_SESSION['user'], $conn));
    $stockName = htmlspecialchars($_GET['name']);
    $stockAmount = (int)htmlspecialchars($_GET['amount']);
    $stockPrice = getStockPrice($stockName, $conn);
    $tax = (rand(0, 5) / 100);
    $newAmount = $stockPrice * $tax;
    $newStockPrice = $stockPrice * ((rand(-30, 40) / 100) + 1);

    if($stockAmount <= 0) {
        die("no");
    }
    //check if bankrupt
    if($currentBobux <= 0) {
        die("you're bankrupt. ask tydentlor to reset your money.");
    } 

    if($stockPrice < 0) {
        die("THIS STOCK HAS CRASHED!");
    }

    //check if stock dont exist
    if(doesStockExist($stockName, $conn) != true) {
        die("stock doesn't exist");
    } 

    $final = ($currentBobux - ($stockPrice * $stockAmount)) - $newAmount;

    //check if will in be debt after buying
    if($final <= 0) {
        die("you cant buy this much stocks or you will go into debt");
    }

    $stmt = $conn->prepare("UPDATE stocknames SET price = ? WHERE coname = ?");
    $stmt->bind_param("ds", $newStockPrice, $stockName);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE users SET bobux = ? WHERE username = ?");
    $stmt->bind_param("ds", $final, $_SESSION['user']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO stocks (stockname, amount, owner) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $stockName, $stockAmount, $_SESSION['user']);
    $stmt->execute();
    $stmt->close();

    webhookSend("", $name . " has bought " . $stockAmount . " of " . $stockName, "Stock Bought");

    header("Location: index.php");
} else {
    die("you aren't logged in or didnt provide enough arguments");
}
?>