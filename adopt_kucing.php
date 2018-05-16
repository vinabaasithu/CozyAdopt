<?php
  session_start();
  include 'source/etc/db.php';
  include 'source/etc/coz_domain.php';
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
    <title>Adopt Kucing</title>
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleUniversal.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/styleHeader.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/adopt_kucing.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/cari_kucing.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/pelihara.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/getMajikan.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/select_input.css">
    <link rel="stylesheet" href="<?php echo $coz_domain; ?>source/css/bookmarks.css">
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
            <img src="<?php echo $coz_domain; ?>source/img/cari_kucing_img.png" alt="">
          </div>
          <div class="img-con img-con2">
            <img src="<?php echo $coz_domain; ?>source/img/cari_kucing_img.png" alt="">
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

            <select class="urut-berdasarkan" name="urut-berdasarkan">
              <option value="">Urut Berdasarkan</option>
              <option value="Disukai">Paling Banyak Disukai</option>
              <option value="Dilihat">Paling Banyak Dilihat</option>
              <option value="Waktu">Terbaru Di Upload</option>
            </select>
          </div>

          <!--  -->

          <div class="form-group searchloc">
            <div>
              <p><strong class="searchloc_strong" val="down"><em>Atau Cari Berdasarkan Lokasi</em> <i class="fas fa-chevron-down chev"></i> </strong> </p>
            </div>
          </div>
          <div class="f-sel-in">
            <?php include 'source/etc/select_input.php'; ?>
            <div class="form-group use_profil_loc_con">
              <div>
                <p><strong class="use_profil_loc"><em><label for="use-profil-loc">Gunakan Lokasi Profil Saya</label></em> <input type="checkbox" name="" value="" id="use-profil-loc"> </strong> </p>
              </div>
              <div class="in-hid">

              </div>
            </div>
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
    <script src="<?php echo $coz_domain; ?>source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/fontawesome-all.min.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/header.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/pelihara.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/select_input.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/bookmarks.js" charset="utf-8"></script>
    <script src="<?php echo $coz_domain; ?>source/js/getMajikan.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).on('click', '#cari-kucing', function(){
          var jenis_kucing = $(".jenis-kucing").val();
          var umur_kucing = $(".umur-kucing").val();
          var bulu_kucing = $(".bulu-kucing").val();
          var warna_kucing = $(".warna-kucing").val();
          var jk_kucing = $(".jk-kucing").val();
          var id_prov = $("#hidden_id_prov").val();
          var id_kab = $("#hidden_id_kab").val();
          var id_kec = $("#hidden_id_kec").val();
          var id_kel = $("#hidden_id_kel").val();
          var urut = $(".urut-berdasarkan").val();

          var cari = "true";
          $.ajax({
          url: "/CozyAdopt/source/etc/cari_kucing.php",
          method: "POST",
          data: {jenis_kucing:jenis_kucing, umur_kucing:umur_kucing, bulu_kucing:bulu_kucing, warna_kucing:warna_kucing, jk_kucing:jk_kucing, cari:cari, id_prov:id_prov, id_kab:id_kab, id_kec:id_kec, id_kel:id_kel, urut:urut},
          dataType: "html",
          success: function(response){
            $("#tampil").html(response);
            if ($(".isi-con-cari .bookmarks").length === 1) {
              $(".isi-con-cari .bookmarks").css("font-size", "4em");
            }
            $('html, body').animate({scrollTop: 570}, 'slow');
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
      // Select By Location
      $(document).ready(function(){
        $(".form-cari-kucing-con label[for='tempat-kucing']").hide();
        // SmoothScroll
        $('a[href^="#"]').click(function(){
        var the_id = $(this).attr("href");
            $('html, body').animate({
                scrollTop:$(the_id).offset().top
            }, 'slow');
        return false;
        });
      });
      $(document).ready(function(){
        if(!userses) {
          $(".f-sel-in").remove();
          return false;
        }
      });
      $(document).on("click", ".searchloc_strong", function() {
        var val = $(this).attr("val");
        if(!userses) {
          $(".f-sel-in").remove();
          return false;
        }
        if (val === "down") {
          $(this).attr("val", "up");
          // $(this).find(".chev").attr("class", "fas fa-chevron-up chev");
          $(this).find(".chev").css("transform", "rotate(180deg)");
          $(".f-sel-in").show(800);
          setTimeout(function(){
            $('html, body').animate({scrollTop:115}, 'slow');
          }, 350)
        } else if (val === "up"){
          $(this).attr("val", "down");
          // $(this).find(".chev").attr("class", "fas fa-chevron-down chev");
          $(this).find(".chev").css("transform", "rotate(360deg)");
          $(".f-sel-in").hide(800);
          $('html, body').animate({scrollTop:0}, 'slow');
        }
      });
      // checked use profil location
      $(document).on("click", "#use-profil-loc", function(){
        var uname = '<?php if (isset($_SESSION["username"])) { echo $_SESSION["username"]; }  ?>';
        var checked = $(this).attr("checked");
        if(checked === "checked") {
          $(this).removeAttr("checked");
          // alert("unchecked");
          $(".container-select-input #hidden_id_prov").val("");
          $(".container-select-input input[type='text'][val='prov']").val("");
          $(".container-select-input #hidden_id_kab").val("");
          $(".container-select-input input[type='text'][val='kab']").val("");
          $(".container-select-input #hidden_id_kec").val("");
          $(".container-select-input input[type='text'][val='kec']").val("");
          $(".container-select-input #hidden_id_kel").val("");
          $(".container-select-input input[type='text'][val='kel']").val("");
          $("#alamat_lengkap").val("");
        } else {
          $(this).attr("checked", "checked");
          // alert("checked");
          $.ajax({
            url: "/CozyAdopt/source/etc/isiAlamatAuto.php",
            method: "POST",
            data: {uname:uname},
            dataType: "html",
            success: function(response){
              $(".in-hid").html(response);

              var id_prov = $("#id_prov_p").attr("val");
              var nama_prov = $("#nama_prov_p").attr("val");
              var id_kab = $("#id_kab_p").attr("val");
              var nama_kab = $("#nama_kab_p").attr("val");
              var id_kec = $("#id_kec_p").attr("val");
              var nama_kec = $("#nama_kec_p").attr("val");
              var id_kel = $("#id_kel_p").attr("val");
              var nama_kel = $("#nama_kel_p").attr("val");
              var alamat_lengkap = $("#alamat_lengkap_p").attr("val");

              $(".container-select-input #hidden_id_prov").val(id_prov);
              $(".container-select-input input[type='text'][val='prov']").val(nama_prov);
              $(".container-select-input #hidden_id_kab").val(id_kab);
              $(".container-select-input input[type='text'][val='kab']").val(nama_kab);
              $(".container-select-input #hidden_id_kec").val(id_kec);
              $(".container-select-input input[type='text'][val='kec']").val(nama_kec);
              $(".container-select-input #hidden_id_kel").val(id_kel);
              $(".container-select-input input[type='text'][val='kel']").val(nama_kel);
              $("#alamat_lengkap").val(alamat_lengkap);
            }
          });
        }
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".searchloc_strong").click(function(){
          var fank = function(teks) {
            $("body").append("<div class='pesanE'><h1></h1></div>");
            $(".pesanE h1").text(teks);
            $(".pesanE").fadeIn(800);
            setTimeout(function(){
              $(".pesanE").fadeOut(800);
            }, 1000);
          }
          if(!userses) {
            // fank("Maaf, Anda harus login untuk menggunakan fitur ini");
            alert("Maaf, Anda harus login untuk menggunakan fitur ini");
          }
        });
      });
    </script>
  </body>
</html>
