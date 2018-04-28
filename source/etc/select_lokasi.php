<?php
  include 'db.php';
  if (isset($_POST['id_prov'])) {
    $id_prov = $_POST['id_prov'];
    $stmt = $mysqli->prepare("SELECT id_kab, nama FROM kabupaten_daerah WHERE id_prov = ?");
    $stmt->bind_param("s", $id_prov);
    $stmt->execute();
    $stmt->bind_result($id_kab, $nama_kab);
    while ($stmt->fetch()) {
      echo "<li val='$id_kab' da='kab'>$nama_kab</li>";
    }
    $stmt->close();
  } else if (isset($_POST['id_kab'])) {
    $id_kab = $_POST['id_kab'];
    $stmt = $mysqli->prepare("SELECT id_kec, nama FROM kecamatan_daerah WHERE id_kab = ?");
    $stmt->bind_param("s", $id_kab);
    $stmt->execute();
    $stmt->bind_result($id_kec, $nama_kec);
    while ($stmt->fetch()) {
      echo "<li val='$id_kec' da='kec'>$nama_kec</li>";
    }
    $stmt->close();
  } else if (isset($_POST['id_kec'])) {
    $id_kec = $_POST['id_kec'];
    $stmt = $mysqli->prepare("SELECT id_kel, nama FROM kelurahan_daerah WHERE id_kec = ?");
    $stmt->bind_param("s", $id_kec);
    $stmt->execute();
    $stmt->bind_result($id_kel, $nama_kel);
    while ($stmt->fetch()) {
      echo "<li val='$id_kel' da='kel'>$nama_kel</li>";
    }
    $stmt->close();
  }
 ?>
