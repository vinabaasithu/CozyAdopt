<?php
  session_start();
  $index = true;
  include 'source/etc/db.php';
  if (isset($_POST["send-email"])) {
    $_GET["pesan"] = "Terimakasih.. Pesan Anda Sudah Terkirim :)";
    $to      = 'jabbarujang@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: webmaster@example.com' . "\r\n" .
          'Reply-To: webmaster@example.com' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CozyAdopt</title>
    <link rel="stylesheet" href="source/css/styleUniversal.css">
    <link rel="stylesheet" href="source/css/styleIndex.css">
    <link rel="stylesheet" href="source/css/styleHeader.css">
    <link rel="stylesheet" href="source/css/bookmarks.css">
  </head>
  <body>
    <?php include 'source/etc/header.php'; ?>
    <div class="sampul" id="home">
      <div class="grid-container">
        <div class="grid-col sampul-background"><br><br>
          <p class="h1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CozyAdopt Site</p>
          <p class="h1 text-center"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Temukan Kucing Peliharaanmu Di Sini</p>
          <br><br><br><br><br><br><br><br><br>
          <p class="h1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meow...</p>
        </div>
        <div class="grid-col text-sampul text-center">
          <h1><i class="fas fa-paw"></i></h1>
          <p>Cari, temukan, dan adopsi Kucing peliharaanmu di sini. Dengan semua fitur yang ada di <a href="index.php"><strong>CozyAdopt</strong></a>, pastinya akan memudahkan kamu menemukan Kucing idamanmu atau menemukan rumah baru untuk Kucing Peliharaanmu di sini</p>
          <p>
            <a href="adopt_kucing.php">
              <button class="btn-text-sampul" type="button" name="button">Adopt Kucing</button>
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="look-at-me" id="find">
      <p class="text-center h1">Adopt Kucing atau Rehome Kucing Peliharaanmu Di sini</p>
      <div class="look-at-me-grid">
        <div class="text-look-at-me">
          <p><strong>Cara Penggunaan Untuk Pengadopt</strong></p>
          <p>Bagi pengadopt akan terasa mudah untuk mencari peliharaanmu di sini. Kamu bisa menggunakan fitur <a href="adopt_kucing.php"><strong>Adopt Kucing</strong></a>. Setelah sampai di laman Adopt Kucing silahkan pilih filter pencarian yang sesuai untuk mencari Kucing peliharaanmu. Lalu tekan tombol cari. Setelah foto-foto kucing tampil, pilih kucing yang anda inginkan. Klik pada foto tersebut, lalu klik <strong>Rawat dan Pelihara</strong>. Maka akan muncul popup yang berisi profil pemilik kucing, dan Kamu bisa menghubungi pemilik tersebut untuk bernegosiasi lebih lanjut.</p>
          <p><strong>Cara Penggunaan Untuk Perehome</strong></p>
          <p>Untuk Kamu yang ingin mencari pemilik atau rumah baru untuk kucing peliharaanmu (rehome). Kamu bisa mengikuti langkah berikut untuk merehome kucing kesayanganmu di sini. Silahkan lakukan <a href="sign.php?r=reg"><strong>Register</strong></a> jika Kamu belum memiliki akun CozyAdopt. Setelah Kamu sudah memiliki akun CozyAdopt Silahkan <a href="sign.php"><strong>login</strong></a> lalu masuk ke laman <a href="rehome_kucing"><strong>Rehome Kucing</strong></a> dan daftarkan kucing kamu di CozyAdopt, tunggu permintaan dari Pengadopt dan kucingmu akan mendapatkan rumah barunya</p>
        </div>
        <div class="look-container">
          <?php
          $i = 1;
          $stmt = $mysqli->prepare("SELECT k.nama_kucing, k.img_kucing1, j_k.jenis_kucing, k.umur_kucing, w_k.warna_kucing, k.bulu_kucing, k.jk_kucing, k.id_kucing, k.username FROM kucing k INNER JOIN jenis_kucing j_k ON k.id_jenis_kucing = j_k.id_jenis_kucing INNER JOIN warna_kucing w_k ON k.id_warna_kucing = w_k.id_warna_kucing LIMIT 5");
          $stmt->execute();
          $stmt->bind_result($nama_kucing, $img_kucing1, $jenis_kucing, $umur_kucing, $warna_kucing, $bulu_kucing, $jk_kucing, $id_kucing, $k_username);
          $ia = 0;
          $arrSel = array();
          while ($stmt->fetch()) {
            $arrSel[$ia]["nama_kucing"] = $nama_kucing;
            $arrSel[$ia]["img_kucing1"] = $img_kucing1;
            $arrSel[$ia]["jenis_kucing"] = $jenis_kucing;
            $arrSel[$ia]["umur_kucing"] = $umur_kucing;
            $arrSel[$ia]["warna_kucing"] = $warna_kucing;
            $arrSel[$ia]["bulu_kucing"] = $bulu_kucing;
            $arrSel[$ia]["jk_kucing"] = $jk_kucing;
            $arrSel[$ia]["id_kucing"] = $id_kucing;
            $arrSel[$ia]["k_username"] = $k_username;
            $ia++;
          }
          $stmt->close();

          for ($ia=0; $ia < count($arrSel); $ia++) {
              if (substr($arrSel[$ia]["img_kucing1"], 0, 6) === "../../") {
                $arrSel[$ia]["img_kucing1"] = substr($arrSel[$ia]["img_kucing1"], 6);
              }
              ?>
              <a class="klik-to-temukan" nm="<?php echo $arrSel[$ia]["nama_kucing"]  ?>" href="adopt_kucing.php?nm=<?php echo $arrSel[$ia]["nama_kucing"] ?>&jk=<?php echo $arrSel[$ia]["jenis_kucing"] ?>&uk=<?php echo $arrSel[$ia]["umur_kucing"] ?>&wk=<?php echo $arrSel[$ia]["warna_kucing"] ?>&bk=<?php echo $arrSel[$ia]["bulu_kucing"] ?>&kuc=<?php echo $arrSel[$ia]["id_kucing"] ?>&jkel=<?php echo $arrSel[$ia]["jk_kucing"] ?>&img=<?php echo $arrSel[$ia]["img_kucing1"] ?>">
                <div class="sampul<?php echo $i; ?> sampul-isi">
                  <div class="sampul-isi-relative">
                    <div class="bio-kucing">
                      <p><strong><?php echo $arrSel[$ia]["nama_kucing"]. ", " .$arrSel[$ia]["jenis_kucing"]. ", ". $arrSel[$ia]["umur_kucing"]; ?> </strong></p>
                      <p><?php echo "Uploaded By ".$arrSel[$ia]["k_username"] ?></p>
                      <?php
                          $bookmarked = "";
                          if (isset($_SESSION["username"])) {
                            $stmt = $mysqli->prepare("SELECT username FROM bookmarks WHERE username = ? && id_kucing = ?");
                            $stmt->bind_param("ss", $_SESSION["username"], $arrSel[$ia]["id_kucing"]);
                            $stmt->execute();
                            $stmt->bind_result($uname_bookmarks);
                            $stmt->fetch();
                            $stmt->close();
                            if ($uname_bookmarks === $_SESSION["username"]) {
                              $bookmarked = "bookmarked";
                            }
                          }
                       ?>
                      <div class="bookmarks">
                        <i class="fas fa-star <?php echo $bookmarked ?>" val="<?php echo $arrSel[$ia]["id_kucing"] ?>"></i>
                      </div>
                    </div>
                    <img src="<?php echo $arrSel[$ia]["img_kucing1"]; ?>" alt="<?php echo $arrSel[$ia]["nama_kucing"] ?>">
                  </div>
                  </div>
              </a>
              <?php
              $i++;
          }
           ?>
        </div>
      </div>
    </div>
    <div class="tentang-kami" id="tentang">
      <div class="tentang-kami-rel">
        <div class="helloCat">
          <!-- <img src="source/img/helloCat.png" alt="Hello Meow.."> -->
        </div>
      </div>
      <div class="tentang-kami-text">
        <h1>Tentang CozyAdopt</h1>
        <p>CozyAdopt adalah website yang yang memiliki fitur pencarian kucing bagi kamu-kamu yang ingin mengadopsi kucing-kucing yang lucu. Di sini kamu bisa dengan mudah mencari kucing yang ingin kamu pelihara sesuai dengan keinginanmu. Untuk mencari kucing peliharaan yang sesuai dengan keinginanmu, Kamu bisa menggunakan fitur <a href="adopt_kucing.php"><strong>Adopt Kucing</strong></a>. Di CozyAdopt, baik fitur pencarian Kucing berdasarkan lokasi, jenis kucing, karakteristik kucing, serta detail kebutuhan-nya sudah tersedia disini. Jadi semoga cepat bertemu dengan peliharaan barumu :)</p>
        <p>Atau bagi kamu yang ingin mendapatkan rumah baru untuk Kucing peliharaan-mu di rumah, CozyAdopt juga menyediakan fitur <a href="rehome_kucing.php"><strong>Rehome Kucing</strong></a>. Di sini kamu bisa menemukan majikan baru untuk kucingmu yang tentunya akan dengan senang hati merawat peliharaan kesayanganmu. Untuk <a href="rehome_kucing.php"><strong>Rehome Kucing</strong></a> peliharaanmu. Kamu bisa <a href="sign.php"><strong>login</strong></a> dan klik <a href="rehome_kucing.php"><strong>Rehome Kucing</strong></a> untuk mendaftarkan peliharaanmu disini. </p>
      </div>
    </div>
    <div class="kontak" id="kontak">
      <p class="h1 text-center">Kontak</p>
      <form class="form-kontak" action="" method="post">
        <h2 class="text-center">Anda dapat menghubungi kami via Email di bawah ini.</h2>
        <div class="form-group">
          <label for="nama_lengkap">Nama :</label>
          <input type="text" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Silahkan isi nama Anda di sini" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" class="form-control" name="email" placeholder="Masukan email agar kami dapat membalas email Anda" required>
        </div>
        <div class="form-group">
          <label for="isi_pesan">Isi Pesan :</label>
          <textarea name="isi_pesan" class="form-control" id="isi_pesan" rows="8" cols="80" placeholder="Tulis Pesan Anda di sini"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="send-email" value="Kirim Email">
        </div><br>
        <div class="text-center more-kontak">
          <p>atau ikuti dan hubungi kami melalui :</p>
          <span><img src="source/img/sosmed/fb.png" class="folUs" val="fb"></span>
          <span><img src="source/img/sosmed/gm.png" class="folUs" val="gm"></span>
          <span><img src="source/img/sosmed/tg.png" class="folUs" val="tg"></span>
          <span><img src="source/img/sosmed/ig.png" class="folUs" val="ig"></span>
          <p class="hoverFollow-container"><strong class="hoverFollow"></strong></p>
        </div>
      </form>
    </div>
    <?php include 'source/etc/footer.php'; ?>
    <a href="#home">
      <span class="keatas">
          <i class="fas fa-arrow-up"></i>
      </span>
    </a>
    <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="source/js/fontawesome-all.min.js" charset="utf-8"></script>
    <script src="source/js/header.js" charset="utf-8"></script>
    <script src="source/js/bookmarks.js" charset="utf-8"></script>
    <script type="text/javascript">
      // detect scroll
      $(window).scroll(function() {
          var height = $(window).scrollTop();
          var docHeight = $(document).height();
          if (docHeight >= 2810 && docHeight < 3235) {
            if(height  >= 1540) {
              $(".helloCat").css("background-attachment", "fixed");
            } else {
              $(".helloCat").css("background-attachment", "");
            }
          }
          if (height >= 270) {
            $(".keatas").fadeIn("slow");
          } else {
            $(".keatas").fadeOut("slow");
          }
      });

      // SmoothScroll
      $('a[href^="#"]').click(function(){
      var the_id = $(this).attr("href");
          $('html, body').animate({
              scrollTop:$(the_id).offset().top
          }, 'slow');
      return false;
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".folUs").hover(function(){
          var val = $(this).attr("val");
          var fol = "";
          switch (val) {
            case "fb": fol = "<a href='https://www.facebook.com/CozyAdopt'>www.facebook.com/CozyAdopt</a>"; break;
            case "gm": fol = "<a href='mailto:cozyadopt@gmail.com'>cozyadopt@gmail.com</a>"; break;
            case "tg": fol = "<a href='https://t.me/CozyAdopt'>Cozy Adopt</a>"; break;
            case "ig": fol = "<a href='https://www.instagram.com/CozyAdopt'>Cozy Adopt</a>"; break;
            default: break;
          }
          $(".hoverFollow").fadeIn(800).html(fol);
        });
        $(".more-kontak").hover(0,function(){
          $(".hoverFollow").fadeOut(800).html("");
        });

      })
    </script>
    <script type="text/javascript">
      // bookmarks
      $(document).ready(function(){
        $(".klik-to-temukan").click(function(e){
          if (e.target.attributes["fill"].nodeValue === "currentColor") {
            var cbookmarks = $(this).find(".bookmarks");
            bookmarks(cbookmarks);
            return false;
          }
        });
      });
    </script>
  </body>
</html>
