<?php
  if (isset($_POST["uname"])) {
    include 'db.php';
    include 'vali.php';
    $username = vali_input($_POST["uname"]);
    $stmt = $mysqli->prepare("SELECT prov.id_prov, prov.nama, kab.id_kab, kab.nama, kec.id_kec, kec.nama, kel.id_kel, kel.nama, u.alamat_lengkap FROM users u INNER JOIN provinsi_daerah prov ON u.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON u.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON u.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON u.id_kel = kel.id_kel WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id_prov, $nama_prov, $id_kab, $nama_kab, $id_kec, $nama_kec, $id_kel, $nama_kel, $alamat_lengkap);
    $stmt->fetch();
    $stmt->close();
    ?>
    <input type="hidden" class="select_p" id="id_prov_p" val="<?php echo $id_prov ?>">
    <input type="hidden" class="select_p" id="nama_prov_p" val="<?php echo $nama_prov ?>">

    <input type="hidden" class="select_p" id="id_kab_p" val="<?php echo $id_kab ?>">
    <input type="hidden" class="select_p" id="nama_kab_p" val="<?php echo $nama_kab ?>">

    <input type="hidden" class="select_p" id="id_kec_p" val="<?php echo $id_kec ?>">
    <input type="hidden" class="select_p" id="nama_kec_p" val="<?php echo $nama_kec ?>">

    <input type="hidden" class="select_p" id="id_kel_p" val="<?php echo $id_kel ?>">
    <input type="hidden" class="select_p" id="nama_kel_p" val="<?php echo $nama_kel ?>">

    <input type="hidden" class="select_p" id="alamat_lengkap_p" val="<?php echo $alamat_lengkap ?>">

    <?php
  }
 ?>
