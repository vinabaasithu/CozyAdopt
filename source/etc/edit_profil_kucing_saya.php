<?php
  session_start();
  include 'db.php';
  if (isset($_POST["val"])) {
    $img_kucing1 = "";
    $img_kucing2 = "";
    $img_kucing3 = "";
    $val = $_POST["val"];
    $stmt = $mysqli->prepare("SELECT nama_kucing, id_jenis_kucing, umur_kucing, img_kucing1, img_kucing2, img_kucing3, id_warna_kucing, jk_kucing, bulu_kucing, waktu, username, id_prov, id_kab, id_kec, id_kel, alamat_lengkap, info_kucing, info_khusus_kucing FROM kucing WHERE id_kucing = ?");
    $stmt->bind_param("s", $val);
    $stmt->execute();
    $stmt->bind_result($nama_kucing, $id_jenis_kucing_s, $umur_kucing, $img_kucing1, $img_kucing2, $img_kucing3, $id_warna_kucing_s, $jk_kucing, $bulu_kucing, $waktu, $username, $id_prov, $id_kab, $id_kec, $id_kel, $alamat_lengkap, $info_kucing, $info_khusus_kucing);
    $stmt->fetch();
    $stmt->close();
    $img_kucing[0] = $img_kucing1;
    $img_kucing[1] = $img_kucing2;
    $img_kucing[2] = $img_kucing3;
    $stmt = $mysqli->prepare("SELECT prov.nama, kab.nama, kec.nama, kel.nama FROM kucing k INNER JOIN provinsi_daerah prov ON prov.id_prov = k.id_prov INNER JOIN kecamatan_daerah kec ON k.id_kec = kec.id_kec INNER JOIN kabupaten_daerah kab ON kab.id_kab = k.id_kab INNER JOIN kelurahan_daerah kel ON kel.id_kel = k.id_kel WHERE id_kucing = ?");
    $stmt->bind_param("s", $val);
    $stmt->execute();
    $stmt->bind_result($nama_prov, $nama_kab, $nama_kec, $nama_kel);
    $stmt->fetch();
    $stmt->close();
  } else if (isset($_POST["rehome"])) {
    $username = "";
    if (isset($_SESSION["username"])) {
      $username = $_SESSION["username"];
    } else {
      header("Location: ../../index.php");
    }

    // init datetime
    date_default_timezone_set('Asia/Jakarta');
    $waktu = date("Y-m-d H:i:s");

    $nama_kucing = htmlentities($_POST["nama-kucing"], ENT_QUOTES);
    // out id_jenis_kucing
    $id_jenis_kucing = htmlentities($_POST["jenis-kucing"], ENT_QUOTES);
    $umur_kucing = htmlentities($_POST["umur-kucing"], ENT_QUOTES);
    // out id_warna_kucing
    $id_warna_kucing = htmlentities($_POST["warna-kucing"], ENT_QUOTES);
    $jk_kucing = htmlentities($_POST["jk-kucing"], ENT_QUOTES);
    $bulu_kucing = htmlentities($_POST["bulu-kucing"], ENT_QUOTES);
    $id_prov = htmlentities($_POST["id_prov"], ENT_QUOTES);
    $id_kab = htmlentities($_POST["id_kab"], ENT_QUOTES);
    $id_kec = htmlentities($_POST["id_kec"], ENT_QUOTES);
    $id_kel = htmlentities($_POST["id_kel"], ENT_QUOTES);
    $alamat_lengkap = htmlentities($_POST["alamat_lengkap"], ENT_QUOTES);
    $info_kucing = htmlentities($_POST["info-kucing"], ENT_QUOTES);
    $info_khusus_kucing = htmlentities($_POST["info-khusus-kucing"], ENT_QUOTES);
    $id_kucing = htmlentities($_POST["id_kucing"], ENT_QUOTES);
    $img1 = htmlentities($_POST["img1"], ENT_QUOTES);
    $img2 = htmlentities($_POST["img2"], ENT_QUOTES);
    $img3 = htmlentities($_POST["img3"], ENT_QUOTES);


    // img_uploading
    for ($i=1; $i <= 3; $i++) {
      $target_dir = "../../userData/".$username."/kucing/img$i/";
      $pesanUpload = "";
      if (!(file_exists($target_dir))) {
        mkdir($target_dir, 0777, true);
      }
      $fileupl = "fileupl".$i;
      if (!$_FILES[$fileupl]["name"]) {
        switch ($i) {
          case 1:  $targetfile1 = $img1; break;
          case 2:  $targetfile2 = $img2; break;
          case 3:  $targetfile3 = $img3; break;
        }
        continue;
      }
      $target_file = $target_dir . basename($_FILES[$fileupl]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $nama_file_baru = basename($_FILES[$fileupl]["name"]);
      $j = 0;
      while (file_exists($target_file)) {
        $nama_file_baru = basename($_FILES[$fileupl]["name"], ".".$imageFileType). $j.".".$imageFileType;
        $target_file = $target_dir.$nama_file_baru;
        $j++;
      }
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES[$fileupl]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          $pesanUpload .= "<p>File is not an image.</p>";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES[$fileupl]["size"] > 15000000) {
          $pesanUpload .= "<p>Sorry, your file is too large.</p>";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $pesanUpload .= "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        $pesanUpload .= "<p>Sorry, your file was not uploaded.</p>";
      // if everything is ok, try to upload file
      } else {
        move_uploaded_file($_FILES[$fileupl]["tmp_name"], $target_file);
          // if (move_uploaded_file($_FILES[$fileupl]["tmp_name"], $target_file)) {
          //     $pesanUpload .= "<p>The file ". $nama_file_baru. " has been uploaded.</p>";
          // } else {
          //     $pesanUpload .= "<p>Sorry, there was an error uploading your file.</p>";
          // }
      }

      switch ($i) {
        case 1:  $targetfile1 = $target_file; break;
        case 2:  $targetfile2 = $target_file; break;
        case 3:  $targetfile3 = $target_file; break;
      }
    }

    $stmt = $mysqli->prepare("UPDATE kucing SET nama_kucing = ?, id_jenis_kucing = ?, umur_kucing = ?, id_warna_kucing = ?, jk_kucing = ?, bulu_kucing = ?, waktu = ?, id_prov = ?, id_kab = ?, id_kec = ?, id_kel = ?, img_kucing1 = ?, img_kucing2 = ?, img_kucing3 = ?, alamat_lengkap = ?, info_kucing = ?, info_khusus_kucing = ? WHERE username = ? && id_kucing = ?");
    $stmt->bind_param("sssssssssssssssssss", $nama_kucing, $id_jenis_kucing, $umur_kucing, $id_warna_kucing, $jk_kucing, $bulu_kucing, $waktu, $id_prov, $id_kab, $id_kec, $id_kel, $targetfile1, $targetfile2, $targetfile3, $alamat_lengkap, $info_kucing, $info_khusus_kucing, $username, $id_kucing);
    $stmt->execute();
    $stmt->close();
    header("Location: ../../profil.php?r=$username");
  }
  else {
    header("Location: index.php?pesan=Terjadi Kesalahan");
  }
?>
<script type="text/javascript">
var id_prov = '<?php if(isset($id_prov)) echo $id_prov ?>';
var id_kab = '<?php if(isset($id_kab)) echo $id_kab ?>';
var id_kec = '<?php if(isset($id_kec)) echo $id_kec ?>';
var id_kel = '<?php if(isset($id_kel)) echo $id_kel ?>';


var nama_prov = '<?php if(isset($nama_prov)) echo $nama_prov ?>';
var nama_kab = '<?php if(isset($nama_kab)) echo $nama_kab ?>';
var nama_kec = '<?php if(isset($nama_kec)) echo $nama_kec ?>';
var nama_kel = '<?php if(isset($nama_kel)) echo $nama_kel ?>';
var alamat_lengkap = '<?php if(isset($alamat_lengkap)) echo $alamat_lengkap ?>';

</script>
<div class="container">
  <p class="h1 text-center">Isi Data Kucing</>
  <form class="" id="edit_profil_kucing_saya_form" action="source/etc/edit_profil_kucing_saya.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_kucing" value="<?php echo $val ?>">
    <div class="form-group">
      <label for="nama-kucing">Nama Kucing :</label>
      <input id="nama-kucing" type="text" class="form-control" name="nama-kucing" value="<?php echo $nama_kucing ?>" placeholder="Nama Kucing">
    </div>
    <div class="form-group">
      <label for="jenis-kucing">Jenis Kucing :</label>
      <select class="select-control" name="jenis-kucing" id="jenis-kucing">
        <?php
          $stmt = $mysqli->prepare("SELECT id_jenis_kucing, jenis_kucing FROM jenis_kucing");
          $stmt->execute(); $stmt->bind_result($id_jenis_kucing, $jenis_kucing);
          while ($stmt->fetch()) {
            $selected = "";
            if ($id_jenis_kucing_s === $id_jenis_kucing) {
              $selected = "selected";
            }
            echo "<option valid='$id_jenis_kucing' value='$id_jenis_kucing' $selected>$jenis_kucing</option>";
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
        <option valid='Kitten' value="Kitten" <?php if ($umur_kucing === "Kitten") { echo "selected"; } ?>>Kitten</option>
        <option valid='Young' value="Young" <?php if ($umur_kucing === "Young") { echo "selected"; } ?>>Young</option>
        <option valid='Adult' value="Adult" <?php if ($umur_kucing === "Adult") { echo "selected"; } ?>>Adult</option>
        <option valid='Senior' value="Senior" <?php if ($umur_kucing === "Senior") { echo "selected"; } ?>>Senior</option>
      </select>
    </div>
    <div class="form-group">
      <label> <strong>Upload 3 Foto Kucing</strong> </label>
    </div>
    <input type="hidden" name="img1" value="<?php echo $img_kucing1 ?>">
    <input type="hidden" name="img2" value="<?php echo $img_kucing2 ?>">
    <input type="hidden" name="img3" value="<?php echo $img_kucing3 ?>">
    <?php
      for ($i=1; $i <= 3; $i++) {
        if (substr($img_kucing[$i-1], 0, 6) === "../../") {
          $img_kucing[$i-1] = substr($img_kucing[$i-1], 6);
        }
        ?>
        <div class="form-group img-upl-con">
          <div> <strong>Upload Foto Kucing Ke - <?php echo $i ?></strong> </div><br>
          <div class="img-upl-front">
            <div class="grid">
              <i class="fas fa-arrow-up"></i>
              <i class='border-upload'></i>
              <span>Upload</span>
            </div>
            <input id="upl<?php echo $i ?>" type="file" class="form-control" name="fileupl<?php echo $i ?>">
          </div>
          <div class="img-preview" id="img-preview<?php echo $i ?>">
            <img id="view-img<?php echo $i ?>" src="<?php echo $img_kucing[$i-1] ?>" alt="">
          </div>
          <div class="close-img" val="fileupl<?php echo $i ?>">
            <div class="close-img-con">
              <i class="fas fa-window-close"></i>
              <div class="backcol"></div>
            </div>
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
            $selected = "";
            if ($id_warna_kucing_s === $id_warna_kucing) {
              $selected = "selected";
            }
            echo "<option valid='$id_warna_kucing' value='$id_warna_kucing' $selected>$warna_kucing</option>";
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
        <option valid='Perempuan' value="Perempuan" <?php if($jk_kucing === "Perempuan") echo "selected"; ?>>Perempuan</option>
        <option valid='Laki-Laki' value="Laki-Laki" <?php if($jk_kucing === "Laki-laki") echo "selected"; ?>>Laki-Laki</option>
      </select>
    </div>

    <div class="form-group">
      <label for="bulu-kucing">Panjang Bulu Kucing :</label>
      <select class="select-control" name="bulu-kucing" id="bulu-kucing">
        <option valid='Pendek' value="Pendek" <?php if($bulu_kucing === "Pendek") echo "selected"; ?>>Pendek</option>
        <option valid='Sedang' value="Sedang" <?php if($bulu_kucing === "Sedang") echo "selected"; ?>>Sedang</option>
        <option valid='Lebat' value="Lebat" <?php if($bulu_kucing === "Lebat") echo "selected"; ?>>Lebat</option>
      </select>
    </div>

    <?php include 'select_input.php'; ?>

    <div class="form-group">
      <label for="info-kucing">Detail Info Kucing</label>
      <textarea name="info-kucing" id="info-kucing" class="form-control" placeholder="Isi Detail Info Kucing seperti makanan favorit kucing, pasir yang digunakan Kucing, dll" rows="8" cols="80"><?php echo $info_kucing ?></textarea>
    </div>

    <div class="form-group">
      <label for="info-khusus-kucing">Kebutuhan Khusus Kucing</label>
      <textarea name="info-khusus-kucing" id="info-khusus-kucing" class="form-control" placeholder="Isi Kebutuhan Khusus Kucing atau Riwayat Penyakit" rows="8" cols="80"><?php echo $info_khusus_kucing ?></textarea>
    </div>
    <div class="form-group text-center">
      <input type="submit" class="form-control submitrehome" name="rehome" value="Rehome Kucing"> <br><br>
      <input type="reset" class="form-control" value="Batal" val="<?php echo $val ?>">
    </div>
  </form>
</div>
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
  $(".kucing_saya_container p.h1.text-center").text("Ganti Data Kucing");
  $(".kucing_saya_container .submitrehome").val("Ganti Data Kucing");

  $("input[name='id_prov']").attr("value", id_prov);
  $("input[name='id_kab']").attr("value", id_kab);
  $("input[name='id_kec']").attr("value", id_kec);
  $("input[name='id_kel']").attr("value", id_kel);
  $("input[type='text'][val='prov']").val(nama_prov);
  $("input[type='text'][val='kab']").val(nama_kab);
  $("input[type='text'][val='kec']").val(nama_kec);
  $("input[type='text'][val='kel']").val(nama_kel);
  $("textarea#alamat_lengkap").val(alamat_lengkap);
</script>
<script type="text/javascript">
// vali form

  $("#edit_profil_kucing_saya_form").submit(function(e){
    var fank = function(teks) {
      $("body").append("<div class='pesanE'><h1></h1></div>");
      $(".pesanE h1").text(teks);
      $(".pesanE").fadeIn(800);
      setTimeout(function(){
        $(".pesanE").fadeOut(800);
      }, 1000);
    }
    var err = 0;
    // SELECT
    // INPUT
    // TEXTAREA
    var inptext = $("#edit_profil_kucing_saya_form input[type='text']");
    for(var i = 0; i < inptext.length; i++) {
      if (i === 1 || i === 2) {
        continue;
      } else if(!inptext[i].value) {
        e.preventDefault();
        fank("Ganti Data Kucing Gagal, Harap Lengkapi Form");
        err = 1;
        break;
      }
    }
    if (!err) {
      var teksarea = $("#edit_profil_kucing_saya_form textarea");
      for(var i = 0; i < teksarea.length; i++) {
        if (!teksarea[i].value) {
          e.preventDefault();
          fank("Ganti Data Kucing Gagal, Harap Lengkapi Form");
          err = 1;
          break;
        }
      }
    }
    if (!err) {
      var inpfile = "view-img";
      for (var i = 1; i <= 3; i++) {
        if (!$("#view-img"+i).attr("src")) {
          e.preventDefault();
          fank("Ganti Data Kucing Gagal, Harap Lengkapi Form");
          err = 1;
          break;
        }
      }
    }
  });
</script>
