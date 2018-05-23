<?php
  $password = "mr_autumn";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";

  $r = "";
  if (!isset($_GET['r'])) {
    $r = $_GET['r'];
  }
  echo $r;
?>
