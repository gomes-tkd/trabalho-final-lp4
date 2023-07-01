<?php
  session_start();
  $host = "localhost";
  $db = "bicicletas";
  $user = "root";
  $password = "";

  try {
      $conn = new PDO("mysql:dbname=$db;host=$host", $user, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
      $error = $e->getMessage();
      echo $error;
  }
?>