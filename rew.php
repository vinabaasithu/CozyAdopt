<?php
  $password = "dendi";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";
  $pesan = "";
  include 'source/etc/vali.php';
  $id = "asdlasd$^";
  $id = vali_pass($id);
  echo $id;
?>
