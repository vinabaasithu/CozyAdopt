<?php
  session_start();
  if (!isset($_SESSION["username"])) {
    header("Location: sign.php?pesan='Maaf Anda harus Login dulu untuk mengakses fitur ini'");
  } else {
    include 'source/etc/db.php';
    $username = $_SESSION["username"];
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rehome Kucing</title>
    <link rel="stylesheet" href="source/css/styleUniversal.css">
    <link rel="stylesheet" href="source/css/styleHeader.css">
    <link rel="stylesheet" href="source/css/styleRehomeKucing.css">
    <link rel="stylesheet" href="source/css/select_input.css">
  </head>
  <body>
    <?php include 'source/etc/header.php'; ?>
    <br>
    <div class="container">
      <p class="h1 text-center">Isi Data Kucing</>
      <form class="" action="source/etc/rehome_kucing.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nama-kucing">Nama Kucing :</label>
          <input id="nama-kucing" type="text" class="form-control" name="nama-kucing" value="" placeholder="Nama Kucing">
        </div>
        <div class="form-group">
          <label for="jenis-kucing">Jenis Kucing :</label>
          <select class="select-control" name="jenis-kucing" id="jenis-kucing">
            <?php
              $stmt = $mysqli->prepare("SELECT id_jenis_kucing, jenis_kucing FROM jenis_kucing");
              $stmt->execute(); $stmt->bind_result($id_jenis_kucing, $jenis_kucing);
              while ($stmt->fetch()) {
                echo "<option valid='$id_jenis_kucing' value='$id_jenis_kucing'>$jenis_kucing</option>";
              }
              $stmt->close();
             ?>
          </select>
          <input id="jenis-kucing-text" type="text" class="form-control" name="jenis-kucing" value="" placeholder="Tulis Jenis Kucing" disabled>
          <p> <input type="checkbox" class="clickjeniskucing klikkucing" val="jenis" id="clickjeniskucing"> <label for="clickjeniskucing"><small class="clickJenisKucing"> <strong> <em> Klik Disini Untuk Memasukan Jenis Kucing Sendiri</em></strong></small></label>  </p>
        </div>
        <div class="form-group">
          <label for="umur-kucing">Umur Kucing :</label>
          <select class="select-control" name="umur-kucing" id="umur-kucing">
            <option valid='Kitten' value="Kitten">Kitten</option>
            <option valid='Young' value="Young">Young</option>
            <option valid='Adult' value="Adult">Adult</option>
            <option valid='Senior' value="Senior">Senior</option>
          </select>
        </div>
        <div class="form-group">
          <label> <strong>Upload 3 Foto Kucing</strong> </label>
        </div>
        <?php
          for ($i=1; $i <= 3; $i++) {
            ?>
            <div class="form-group img-upl-con">
              <div> <strong>Upload Foto Kucing Ke - <?php echo $i ?></strong> </div><br>
              <div class="img-upl-front">
                <div class="grid">
                  <i class="fas fa-arrow-up"></i>
                  <i class='border-upload'></i>
                  <span>Upload</span>
                </div>
                <input id="upl<?php echo $i ?>" type="file" class="form-control" name="fileupl<?php echo $i ?>" value="">
              </div>
              <div class="img-preview" id="img-preview<?php echo $i ?>">
                <img id="view-img<?php echo $i ?>" src="" alt="">
              </div>
            </div>
            <?php
          }
         ?>
         <br><br>
        <div class="form-group">
          <label for="warna-kucing">Pilih Warna Kucing :</label>
          <select class="select-control" name="warna-kucing" id="warna-kucing">
            <?php
              $stmt = $mysqli->prepare("SELECT id_warna_kucing, warna_kucing FROM warna_kucing");
              $stmt->execute(); $stmt->bind_result($id_warna_kucing, $warna_kucing);
              while ($stmt->fetch()) {
                echo "<option valid='$id_warna_kucing' value='$id_warna_kucing'>$warna_kucing</option>";
              }
              $stmt->close();
             ?>
          </select>
          <input id="warna-kucing-text" type="text" class="form-control" name="warna-kucing" value="" placeholder="Tulis Jenis Kucing" disabled>
          <p> <input type="checkbox" class="clickwarnakucing klikkucing" val="warna" id="clickwarnakucing"> <label for="clickwarnakucing"><small class="clickWarnaKucing"> <strong> <em> Klik Disini Untuk Memasukan Warna Kucing Sendiri</em></strong></small></label>  </p>
        </div>

        <div class="form-group">
          <label for="jk-kucing">Jenis Kelamin Kucing :</label>
          <select class="select-control" name="jk-kucing" id="jk-kucing">
            <option valid='Perempuan' value="Perempuan">Perempuan</option>
            <option valid='Laki-Laki' value="Laki-Laki">Laki-Laki</option>
          </select>
        </div>

        <div class="form-group">
          <label for="bulu-kucing">Panjang Bulu Kucing :</label>
          <select class="select-control" name="bulu-kucing" id="bulu-kucing">
            <option valid='Pendek' value="Pendek">Pendek</option>
            <option valid='Sedang' value="Sedang">Sedang</option>
            <option valid='Lebat' value="Lebat">Lebat</option>
          </select>
        </div>
        <?php include 'source/etc/select_input.php'; ?>
        <div class="auto-input-post">

        </div>
        <div class="form-group">
          <label for="info-kucing">Detail Info Kucing</label>
          <textarea name="info-kucing" id="info-kucing" class="form-control" placeholder="Isi Detail Info Kucing seperti makanan favorit kucing, pasir yang digunakan Kucing, dll" rows="8" cols="80"></textarea>
        </div>

        <div class="form-group">
          <label for="info-khusus-kucing">Kebutuhan Khusus Kucing</label>
          <textarea name="info-khusus-kucing" id="info-khusus-kucing" class="form-control" placeholder="Isi Kebutuhan Khusus Kucing atau Riwayat Penyakit" rows="8" cols="80"></textarea>
        </div>
        <div class="form-group text-center">
          <input type="submit" class="form-control" name="rehome" value="Rehome Kucing">
        </div>
      </form>
    </div>
    <?php include 'source/etc/footer.php'; ?>
    <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="source/js/fontawesome-all.min.js" charset="utf-8"></script>
    <script src="source/js/header.js" charset="utf-8"></script>
    <script src="source/js/select_input.js" charset="utf-8"></script>
    <script src="source/js/img_preview.js" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".klikkucing").click(function(){
          var val = $(this).attr("val");
          var a = $("#"+val+"-kucing-text");
          var b = a.attr("disabled");
          var c = $("#"+val+"-kucing")
          var d = c.attr("disabled");
          if (b) {
            c.attr("disabled", "");
            a.removeAttr("disabled");
          } else {
            a.attr("disabled", "");
          c.removeAttr("disabled");
          }
        })
      });
    </script>
    <script type="text/javascript">
      var uname = '<?php echo $username ?>';
      $(document).on("click", "#isiAlamatAuto", function(){
        var check = $(this).attr("isc");
        if (check === "unchecked") {
          $.post("source/etc/isiAlamatAuto.php", {uname:uname}, function(result){
            $(".auto-input-post").html(result);
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
          });
          $(this).attr("isc", "checked");
        } else if(check === "checked") {
          $(".auto-input-post").empty();
          $(".container-select-input #hidden_id_prov").val("");
          $(".container-select-input input[type='text'][val='prov']").val("");

          $(".container-select-input #hidden_id_kab").val("");
          $(".container-select-input input[type='text'][val='kab']").val("");

          $(".container-select-input #hidden_id_kec").val("");
          $(".container-select-input input[type='text'][val='kec']").val("");

          $(".container-select-input #hidden_id_kel").val("");
          $(".container-select-input input[type='text'][val='kel']").val("");

          $("#alamat_lengkap").val("");
          $(this).attr("isc", "unchecked");
        }

      });
    </script>
  </body>
</html>
