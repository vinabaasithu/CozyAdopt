<?php
  $password = "dendi";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";
  $pesan = "";
  include 'source/etc/vali.php';
  $url = "/CozyAdopt/profil.php?r=dendi&pesan=d";
  if (preg_match("/profil.php\?r=(.+)&pesan=(.*)/", $url)) {
    echo "URL ADA";
  } else {
    echo "URL TIDAK ADA";
  }
  // $keywords = $pass;
  // $keywords = preg_quote($keywords, '/');
  // echo "<br>".$keywords; // returns \$40 for a g3\/400
?>
