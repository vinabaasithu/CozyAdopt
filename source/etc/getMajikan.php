<?php
  include "coz_domain.php";
  if (isset($_POST["val"])) {
    include "db.php";
    $val = $_POST["val"];
    $stmt = $mysqli->prepare("SELECT k.username, u.fullname, u.no_hp, u.email, u.dp, u.sampul, prov.nama, kab.nama, kec.nama, kel.nama, u.alamat_lengkap, k.nama_kucing FROM users u INNER JOIN kucing k ON u.username = k.username INNER JOIN provinsi_daerah prov ON u.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON u.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON u.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON u.id_kel = kel.id_kel WHERE id_kucing = ?");
    $stmt->bind_param("s", $val);
    $stmt->execute();
    $stmt->bind_result($username, $fullname, $no_hp, $email, $dp, $sampul, $nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap, $nama_kucing);
    $stmt->fetch();
    $stmt->close();
    if (substr($dp, 0, 6) === "../../") {
      $dp = substr($dp, 6);
    }
    if (substr($sampul, 0, 6) === "../../") {
      $sampul = substr($sampul, 6);
    }
    $nama_kab = substr($nama_kab, 0, 6). strtolower(substr($nama_kab, 6));
  }
 ?>
<div class="getMajikan">
  <div class="cont-get-majikan">
    <div class="rel">
      <a href="<?php echo $coz_domain; ?>profil.php?r=<?php echo $username ?>">
        <div class="sampul">
          <div class="dp">
            <img src="<?php echo $coz_domain; ?><?php echo $dp ?>" alt="">
            <p class="text-center nama"><?php echo $fullname ?></p>
          </div>
        </div>
      </a>

      <div class="isimjkn">

        <p class="text-center"><strong><em><small>Hubungi Saya Untuk Pelihara <?php echo $nama_kucing ?></small></em></strong></p>
        <div class="grid-mjkn">
          <span class="space">Hubungi</span>
          <span class="text-center">:</span>
          <span class="text-justify"><?php echo $no_hp ?></span>
        </div>
        <div class="grid-mjkn">
          <span class="space">Email</span>
          <span class="text-center">:</span>
          <span class="text-justify"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></span>
        </div>
        <div class="grid-mjkn">
          <span class="space">Alamat</span>
          <span class="text-center">:</span>
          <span class="text-justify"><?php echo "$nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap" ?></span>
        </div>

        <p class="text-center"><strong><em><small class="cat">Cat: Harap tetap hati-hati dalam proses bertransaksi, kenali penipuan dan laporkan jika mendapatinya</small></em></strong></p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var bg = '<?php echo $coz_domain.$sampul ?>';
  $(".getMajikan .sampul").css("background-image", "url('"+bg+"')");
</script>
