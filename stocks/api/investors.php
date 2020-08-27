<?php
  require($_SERVER['DOCUMENT_ROOT'] . "/config.inc.php"); 
  require($_SERVER['DOCUMENT_ROOT'] . "/lib/conn.php");
  require($_SERVER['DOCUMENT_ROOT'] . "/lib/user.php");
?>
{"User":"Money",<?php
  $stmt = $conn->prepare("SELECT bobux, username FROM users");
  $stmt->execute();
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()) { 
    echo "\"" . $row['username'] . "\": " . $row['bobux'] . ",";
  }
?>"_":0}