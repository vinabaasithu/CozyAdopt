<?php
  $password = "dendi";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";
  $pesan = "";
  include 'source/etc/vali.php';
  $pass = "";
  substr(($pass = vali_pass($pass)), 0, 3) === "<h1" ? $pesan = $pass : $pass = $pass;
  if ($pesan) {
    echo $pesan."<br>";
  } else {
    echo $pass."<br>";
  }
  // $keywords = $pass;
  // $keywords = preg_quote($keywords, '/');
  // echo "<br>".$keywords; // returns \$40 for a g3\/400
?>
