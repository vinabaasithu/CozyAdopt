<?php
  $password = "dendi";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password;
 ?>
