<?php

  $r = ""; $title = ""; $pesan = "";
  if (isset($_GET['r'])) {
    $r = $_GET['r'];
  }
  if ($r === "reg") {
    $title = "Register";
  } else {
    $title = "Login";
  }
  include 'source/etc/coz_domain.php';
  require 'source/etc/sign.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleUniversal.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleHeader.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleSign.css">
  </head>
  <body>
    <?php if ($pesan): ?>
      <div class="pesan">
        <?php echo $pesan ?>
      </div>
    <?php endif; ?>
    <div class="container">
      <?php
      include 'source/etc/header.php';
        if ($r != "reg") {
          ?>
          <div class="cont">
            <p class="text-center h1">Login</p>
            <form class="" action="" method="post">
              <p>
                <input type="text" name="username_log" id="username_log" placeholder="Username" required>
              </p>
              <p>
                <input type="password" name="password_log" class="password" id="password_log" placeholder="Password" required>
              </p>
              <small class="show-pass"><input type="checkbox" id="show-password" check="false" class="show-pass-check"> <label for="show-password">Show Password</label> </small>
              <p>
                <input type="submit" id="login" name="login" value="Login">
              </p>
              <p class="grid">
                <small>
                  Belum punya akun ? <a href="<?php echo $coz_domain; ?>sign.php?r=reg">Register di sini</a>
                </small>
                <small class="text-right"><a href="<?php echo $coz_domain; ?>#">Lupa password atau username ?</a> </small>
              </p>
            </form>
          </div>
          <?php
        } else {
          ?>
          <div class="cont">
            <p class="text-center h1">Register</p>
            <form class="formc" action="" method="post">
              <p class="relative UnameCheck">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <i class="fas fa-check"></i>
                <i class="fas fa-times"></i>
              </p>
              <p class="relative FullNameCheck">
                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" required>
                <i class="fas fa-check"></i>
                <i class="fas fa-times"></i>
              </p>
              <p class="relative EmailCheck">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <i class="fas fa-check"></i>
                <i class="fas fa-times"></i>
              </p>
              <p class="relative NoHPCheck">
                <input type="number" name="no_hp" id="no_hp" placeholder="No.HP" required>
                <i class="fas fa-check"></i>
                <i class="fas fa-times"></i>
              </p>
              <p class="relative PasswordCheck">
                <input type="password" name="password" id="password" placeholder="Password" class="password" required>
                <i class="fas fa-check"></i>
                <i class="fas fa-times"></i>
                <small class="show-pass"><input type="checkbox" id="show-password" check="false" class="show-pass-check"> <label for="show-password">Show Password</label> </small>
              </p>
              <p>
                <input type="submit" id="regis" name="register" value="Register">
              </p>
              <p>
                <small>Sudah Punya Akun ? <a href='<?php echo $coz_domain; ?>sign.php'>Login di sini</a></small>
              </p>
            </form>
          </div>
          <?php
        }
       ?>
    </div>
    <?php include 'source/etc/footer.php'; ?>
     <script src="<?php echo $coz_domain; ?>source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
     <script src="<?php echo $coz_domain; ?>source/js/fontawesome-all.min.js" charset="utf-8"></script>
     <script src="<?php echo $coz_domain; ?>source/js/header.js" charset="utf-8"></script>
     <script src="<?php echo $coz_domain; ?>source/js/vali.js" charset="utf-8"></script>
     <script type="text/javascript">
       $(document).ready(function(){
         $(".show-pass-check").click(function(){
           var check = $(this).attr("check");
           if (check === "false") {
             $(this).attr("check", "true");
             $(".password").attr("type", "text");
           } else {
             $(this).attr("check", "false");
             $(".password").attr("type", "password");
           }
         });
       });
     </script>
     <script type="text/javascript">
       $(document).ready(function(){
         var o = $(".pesan");
         var p = $(".pesan h1");
         var a = p.text();
         if (a.substr(11, 8) == "Berhasil") {
           setTimeout(function(){
             window.location = "/CozyAdopt/sign.php";
           }, 3000);
         }
         if(p.length) {
           setTimeout(function(){
             o.fadeOut("slow");
           }, 3000);
         }
         o.click(function(){
           o.fadeOut("slow");
         });
         if (a === "Login Berhasil") {
           setTimeout(function(){
             window.location = "/CozyAdopt/profil.php?r="+userses;
           }, 2000);
         }
       });
     </script>
  </body>
</html>
