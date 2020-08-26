<?php header("Content-Type: application/json") ?>
{<?php
  $stmt = $conn->prepare("SELECT bobux, username FROM users");
  $stmt->execute();
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()) { 
    echo "['" . $row['username'] . "', " . $row['bobux'] . "]," . PHP_EOL;
  }
?>}