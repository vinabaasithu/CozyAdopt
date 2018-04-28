<?php
  session_start();
  include 'source/etc/db.php';
  if (isset($_GET['nm']) && isset($_GET['jk']) && isset($_GET['uk']) && isset($_GET['wk']) && isset($_GET['bk']) && isset($_GET['kuc']) && isset($_GET['jkel']) && isset($_GET['img'])) {
    $nm = $_GET['nm']; $jk = $_GET['jk']; $uk = $_GET['uk']; $wk = $_GET['wk']; $bk = $_GET['bk']; $kuc = $_GET['kuc']; $jkel = $_GET['jkel']; $img = $_GET['img'];
    if (!$nm || !$jk || !$uk || !$wk || !$bk || !$kuc || !$jkel || !$img) {
      header("Location: index.php");
    } else {
      $img = "../../../".$img;
      $pos = '<div id="isi-con-cari-from-index" nm="'.$nm.'" img="'.$img.'" jk="'.$jk.'" uk="'.$uk.'" wk="'.$wk.'" bk="'.$bk.'" kuc="'.$kuc.'" jkel="'.$jkel.'" style="display:none;"></div> ';
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Temukan Kami</title>
    <link rel="stylesheet" href="source/css/styleUniversal.css">
    <link rel="stylesheet" href="source/css/styleHeader.css">
    <link rel="stylesheet" href="source/css/temukan_kami.css">
    <link rel="stylesheet" href="source/css/cari_kucing.css">
    <link rel="stylesheet" href="source/css/pelihara.css">
    <link rel="stylesheet" href="source/css/getMajikan.css">
  </head>
  <body>
    <?php
      include 'source/etc/header.php';
    ?>
    <div class="pelihara-container">
    </div>
    <div class="con-color">
      <br>
      <div class="form-cari-con">
        <div class="form-cari-kucing-con">
          <div class="img-con img-con1">
            <img src="source/img/cari_kucing_img.png" alt="">
          </div>
          <div class="img-con img-con2">
            <img src="source/img/cari_kucing_img.png" alt="">
          </div>
          <h1 class="text-center h1">Cari Kucing</h1>
          <div class="form-cari-kucing">
            <select class="jenis-kucing" name="jenis-kucing">
              <option value="">Jenis Kucing</option>
              <?php
              $stmt = $mysqli->prepare("SELECT id_jenis_kucing, jenis_kucing FROM jenis_kucing");
              $stmt->execute();
              $stmt->bind_result($id_jenis_kucing, $jenis_kucing);
              while ($stmt->fetch()) {
                ?>
                <option value="<?php echo $id_jenis_kucing ?>"><?php echo $jenis_kucing ?></option>
                <?php
              }
              $stmt->close();
              ?>
            </select>
            <select class="umur-kucing" name="umur-kucing">
              <option value="">Umur Kucing</option>
              <option value="Kitten">Kitten</option>
              <option value="Young">Young</option>
              <option value="Adult">Adult</option>
              <option value="Senior">Senior</option>
             </select>
            <select class="warna-kucing" name="warna-kucing">
              <option value="">Warna Kucing</option>
              <?php
              $stmt = $mysqli->prepare("SELECT id_warna_kucing, warna_kucing FROM warna_kucing");
              $stmt->execute();
              $stmt->bind_result($id_warna_kucing, $warna_kucing);
              while ($stmt->fetch()) {
                ?>
                <option value="<?php echo $id_warna_kucing; ?>"><?php echo $warna_kucing; ?></option>
                <?php
              }
               ?>
            </select>
            <select class="bulu-kucing" name="bulu-kucing">
              <option value="">Bulu Kucing</option>
              <option value="Pendek">Pendek</option>
              <option value="Sedang">Sedang</option>
              <option value="Lebat">Lebat</option>
            </select>
            <select class="jk-kucing" name="jk-kucing">
              <option value="">Jenis Kelamin</option>
              <option value="Perempuan">Perempuan</option>
              <option value="Laki-laki">Laki-laki</option>
            </select>
          </div>
          <div class="text-center">
            <button class="text-center" type="button" name="cari-kucing" id="cari-kucing">Cari</button>
          </div>
        </div>
        <div class="ground"></div>

      </div>

    </div>

    <div id="tampil">
      <?php if (isset($pos)): ?>
        <?php echo $pos ?>
      <?php endif; ?>
    </div>

    <div class="getmj">

    </div>

    <?php include 'source/etc/footer.php'; ?>
    <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="source/js/fontawesome-all.min.js" charset="utf-8"></script>
    <script src="source/js/header.js" charset="utf-8"></script>
    <script src="source/js/pelihara.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).on('click', '#cari-kucing', function(){
          var jenis_kucing = $(".jenis-kucing").val();
          var umur_kucing = $(".umur-kucing").val();
          var bulu_kucing = $(".bulu-kucing").val();
          var warna_kucing = $(".warna-kucing").val();
          var jk_kucing = $(".jk-kucing").val();
          var cari = "true";
          $.ajax({
          url: "source/etc/cari_kucing.php",
          method: "POST",
          data: {jenis_kucing:jenis_kucing, umur_kucing:umur_kucing, bulu_kucing:bulu_kucing, warna_kucing:warna_kucing, jk_kucing:jk_kucing, cari:cari},
          dataType: "html",
          success: function(response){
            $("#tampil").html(response);
            // footerChange();
          }
          });
        });
    </script>
    <script type="text/javascript">
      function footerChange() {
        var a = $(".isi-con-cari").length;
        if(!a) {
          $("footer").css("margin-top", "19.8vh");
        } else {
          $("footer").css("margin-top", "20px");
        }
      }
      footerChange();
    </script>
    <script type="text/javascript">
      // getmj
      $(document).on("click", ".rawatpelihara", function(){
        var val = $(this).attr("val");
        $.ajax({
          url: "source/etc/getMajikan.php",
          method: "POST",
          data: {val:val},
          dataType: "html",
          success: function(response){
            $(".getmj").html(response);
            $(".getMajikan").hide();
            $(".getMajikan").show(800);
          }
        });
      });
      $(document).on("click", ".getMajikan", function(e){
        if (this === e.target) {
          $(this).hide(800);
          setTimeout(function(){
            $(".getmj").empty();
          }, 900);
        }
      });
    </script>
  </body>
</html>
