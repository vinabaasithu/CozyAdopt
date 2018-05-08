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
      </div>
      <div class="cont-err-desktop cont-err-mess">
        <div class="mess">
          <p class="h1 text-center">Error 404</p>
          <p class="text-center lh" id="text-desktop"><strong>Upsss... Halaman yang kamu cari sudah dipindahkan, dihapus, atau tidak tersedia. Ayo.. kita kembali kehalaman awal <a class="h1" href="<?php echo $coz_domain ?>index.php">CozyAdopt</a></strong></p>
        </div>
      </div>
      <div class='cont-err-mess-mobile cont-err-mess'><p></p></div>
    </div>
    <script src="<?php echo $coz_domain; ?>source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      var p = $(".mess #text-desktop");
      var cemp = $(".cont-err-desktop.cont-err-mess p.lh");
      var cem2 = $(".cont-err-mess-mobile.cont-err-mess");
      var cem2p = $(".cont-err-mess-mobile.cont-err-mess p");
      var cgc = $(".cat-gif-con");
      var a = p.html();
      cem2p.html(a);
      // function

      // if window size
      if ($(window).width() <= 901) {
        $("body").hide();
        setTimeout(function() {
          cemp.hide();
          cem2.show();
          $("body").fadeIn(1600);
          var cont_err_height = $(".cont-err-mess").height()*1.5;
          cgc.css("top",cont_err_height);
        }, 250);
      } else {
        setTimeout(function() {
          $("body").fadeIn(1600);
        }, 250);
      }

      // resize function
      $(window).resize(function(){
        if (window.matchMedia('(max-width: 901px)').matches) {
          cemp.hide();
          cem2.show();
          var cont_err_height = $(".cont-err-mess").height()*1.5;
          cgc.css("top",cont_err_height);
        } else {
          cgc.css("top", "0");
          cem2.hide();
          cemp.show();
        }
      });
    </script>
  </body>
</html>
