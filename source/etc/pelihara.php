<?php
  include 'coz_domain.php';
  if (isset($_POST['id_kucing'])) {
    if (file_exists('db.php')) {
      include 'db.php';
    }
    $id_kucing = $_POST['id_kucing'];
    $nama_kucing = $_POST['nama'];
    $img_kucing1 = $_POST['img'];
    $jenis_kucing = $_POST['jenis_kucing'];
    $umur_kucing = $_POST['umur_kucing'];
    $warna_kucing = $_POST['warna_kucing'];
    $bulu_kucing = $_POST['bulu_kucing'];
    $jk_kucing = $_POST['jk_kucing'];
    $stmt = $mysqli->prepare("SELECT k.info_kucing, k.info_khusus_kucing, prov.nama, kab.nama, kec.nama, kel.nama, k.alamat_lengkap, k.dilihat, k.disukai FROM kucing k INNER JOIN provinsi_daerah prov ON k.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON k.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON k.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON k.id_kel = kel.id_kel WHERE id_kucing = ?");
    $stmt->bind_param("s", $id_kucing);
    $stmt->execute();
    $stmt->bind_result($info_kucing, $info_khusus_kucing, $nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap, $dilihat, $disukai);
    $stmt->fetch();
    $stmt->close();
    $dilihat++;
    $stmt = $mysqli->prepare("UPDATE kucing SET dilihat = ? WHERE id_kucing = ?");
    $stmt->bind_param("ss", $dilihat, $id_kucing);
    $stmt->execute();
    $stmt->close();
    switch($umur_kucing) {
      case "Kitten": $umur_kucing = "Masih Anak Kucing"; break;
      case "Young": $umur_kucing = "Muda"; break;
      case "Adult": $umur_kucing = "Dewasa"; break;
      case "Senior": $umur_kucing = "Senior"; break;
    }
  } else {
    header("Location: index.php");
  }
 ?>
<div class="pelihara">
  <div class="exit">
    <div class="close-container">
    </div>
    <i class="fas fa-window-close"></i>
  </div>
  <div class="isi_pelihara">
    <div class="data-pelihara">
      <div class="gambar-pelihara">
        <img src="<?php echo $coz_domain; ?>source/img/kucing/<?php echo $img_kucing1 ?>" alt="">
      </div>
      <div class="data-kucing">
        <div class="head-data-kucing">
          <p class="text-center h1"><?php echo $nama_kucing ?></p>
          <p class="text-justify"><strong><?php echo "$nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap" ?></strong></p>
          <p class="text-justify"><strong><?php echo $jenis_kucing. " . ". $jk_kucing . " . ". $warna_kucing?></strong></p>
          <hr>
          <p class="text-center h1">Tentang <?php echo $nama_kucing ?></p>
          <p class="justify"> <strong><?php echo $nama_kucing . " Berbulu ". $bulu_kucing?></strong> </p>
          <p class="justify"> <strong><?php echo "Umur ".$nama_kucing. " " .$umur_kucing?></strong> </p>
          <br>
          <div class="bio-kucing">
            <p class="text-center">
              <button class="rawatpelihara" val="<?php echo $id_kucing ?>" type="button" name="button">Rawat dan Pelihara <?php echo $nama_kucing ?></button>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="bio-kucing">
      <p class="h1 text-justify">Info <?php echo $nama_kucing ?></p>
      <p> <strong><?php echo $info_kucing ?></strong> </p>

      <p class="h1 text-justify">Info Khusus Tentang <?php echo $nama_kucing ?></p>
      <p> <strong><?php echo $info_khusus_kucing ?></strong> </p>
    </div>
  </div>
</div>
