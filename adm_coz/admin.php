<?php
  session_start();
  include '../source/etc/coz_domain.php';
  include '../source/etc/db.php';
  include '../source/etc/header_uri.php';
  include '../source/etc/vali.php';
  if (isset($_SESSION['admin'])) {
    header("Location: ".$ttkttk."admin_panel.php");
    die();
  }
  if (isset($_POST['login']) && isset($_POST['uname']) && isset($_POST['pass'])) {
    $pesan = "";
    substr(($uname = vali_uname($_POST['uname'])), 0, 3) === "<h1" ? $pesan = $uname : $uname = $uname;
    substr(($pass = vali_pass($_POST['pass'])), 0, 3) === "<h1" ? $pesan = $pass : $pass = $pass;
    if ($pesan) {
      $pesan = "Login ".substr($pesan, 13, -5);
    } else {
      $stmt = $mysqli->prepare("SELECT password FROM admin WHERE username = ?");
      $stmt->bind_param("s", $uname);
      $stmt->execute();
      $stmt->bind_result($passHash);
      if (!$stmt->fetch()) {
        $pesan = "Login Gagal, Username Salah";
      }
      $stmt->close();
      if (!$pesan) {
        if (!password_verify($pass, $passHash)) {
          $pesan = "Login Gagal, Password Salah";
        } else {
          $pesan = "Login Sukses";
          $_SESSION['admin'] = $uname;
          header("Location: ".$ttkttk."admin_panel.php");
          die();
        }
      }
    }
  }
?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Coz Admin</title>
     <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/styleUniversal.css">
     <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/styleAdminLogin.css">
   </head>
   <body>
     <div class="pesanE">
       <h1></h1>
     </div>
     <div class="container">
       <form class="loginform" action="" method="post">
         <fieldset>
           <legend class="label">Admin Login</legend>
           <div class="form-group-adm form-group">
             <div class="label">Username</div>
             <div class="label">:</div>
             <div><input id="uname" class="form-control-adm" type="text" name="uname" value="" required> </div>
           </div>
           <div class="form-group-adm form-group">
             <div class="label">Password</div>
             <div class="label">:</div>
             <div><input id="pass" class="form-control-adm" type="password" name="pass" value="" required> </div>
           </div>
           <div class="form-group-adm form-group">
             <div class="label"></div>
             <div class="label"></div>
             <div><input class="form-control-adm btn-primary-adm" type="submit" name="login" value="Login"> </div>
           </div>
         </fieldset>
       </form>
     </div>
     <script src="<?php echo $coz_domain; ?>source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
     <script type="text/javascript">
       var submitted = '<?php if (isset($pesan)) { echo $pesan; } ?>';
       var submittedFunc = function(submitted) {
          if (submitted) {
            $(".pesanE h1").text(submitted);
            $(".pesanE").fadeIn(800);
            setTimeout(function(){
              $(".pesanE").fadeOut(800);
            }, 1800);
          }
       }
       submittedFunc(submitted);
       $(document).ready(function(){
         $(".loginform").submit(function(e){
           var uname = $("#uname").val();
           var pass = $("#pass").val();
           var unameReg = /^[a-zA-Z0-9-_]{1,50}$/;
           var passReg = /^[a-zA-Z0-9!@#\$\^\*\-\=_\+\.,]{1,150}$/;
           var text = "";
           if (!unameReg.test(uname) || !passReg.test(pass)) {
             e.preventDefault();
             if (!unameReg.test(uname) && !passReg.test(pass)) {
               text = "Login Gagal, Format Username dan Password Salah";
             } else if(!unameReg.test(uname)) {
               text = "Login Gagal, Format Username Salah";
             } else if(!passReg.test(pass)) {
               text = "Login Gagal, Format Password Salah";
             }
             $(".pesanE h1").text(text);
             $(".pesanE").fadeIn(800);
             setTimeout(function(){
               $(".pesanE").fadeOut(800);
             }, 1800);
           }
         });
       });

     </script>
   </body>
 </html>
