<?php
  include 'source/etc/coz_domain.php';
  include 'source/etc/header_uri.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleUniversal.css">
    <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/styleErr404.css">
  </head>
  <body>
    <div class="container">
      <div class="cat-gif-con">
        <img class="cat404" src="<?php echo $coz_domain ?>source/img/cat404.gif" alt="">
        <!-- <?php
          for ($i=1; $i <= 6; $i++) {
            ?>
            <div class="abso404 abso404<?php echo $i; ?>">
             <img src="<?php echo $coz_domain ?>source/img/404.gif" alt="">
            </div>
            <?php
          }
         ?> -->
      </div>
      <div class="cont-err-mess">
        <div class="mess">
          <p class="h1 text-center">Error 404</p>
          <p class="text-center lh"><strong>Upsss... Halaman yang kamu cari sudah dipindahkan, dihapus, atau tidak tersedia. Kamu dapat kembali kehalaman <a href="<?php echo $coz_domain ?>index.php">awal</a> jika kamu mau..</strong></p>
        </div>
      </div>
    </div>
  </body>
</html>
