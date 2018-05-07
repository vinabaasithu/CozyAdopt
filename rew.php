<?php
  $password = "dendi";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";
  $pesan = "";
  include 'source/etc/vali.php';
  include 'source/etc/db.php';
  echo get_enum_data("bulu_kucing", "Senio");
  $p = "<h1>Register Gagal, Nama Tidak Boleh Menggunakan Angka Atau Simbol Lainnya</h1>";
  echo substr($p, 4, 21). "Kucing". substr($p, 24, -5);
?>
