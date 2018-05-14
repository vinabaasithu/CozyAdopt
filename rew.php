<?php
  $password = "mr_autumn";
  $options = [
    'cost' => 13
  ];
  $password = password_hash($password, PASSWORD_BCRYPT, $options);
  echo $password. "<br>";
  $pesan = "";
  include 'source/etc/vali.php';
  include 'source/etc/db.php';

  function removeDirectory($path) {
  	$files = glob($path . '/*');
  	foreach ($files as $file) {
  		is_dir($file) ? removeDirectory($file) : unlink($file);
  	}
  	rmdir($path);
  	return;
  }
  removeDirectory("userData/sasa/dp/");
  removeDirectory("userData/sasa/kucing/img1/");
  removeDirectory("userData/sasa/kucing/img2/");
  removeDirectory("userData/sasa/kucing/img3/");
  removeDirectory("userData/sasa/kucing/");
  removeDirectory("userData/sasa/sampul/");
?>
