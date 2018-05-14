<?php
  // include '../../source/etc/coz_domain.php';
  include '../../source/etc/db.php';
  // include '../../source/etc/header_uri.php';
  include '../../source/etc/vali.php';
if (isset($_POST["uname"]) && isset($_POST["col"]) && isset($_POST["val"])) {
  $uname = vali_input($_POST["uname"]);
  $col = vali_input($_POST["col"]);
  $val = vali_input($_POST["val"]);
  if($col !== "username" && $col !== "password") {
    $query = "UPDATE users SET $col = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $val, $uname);
    $stmt->execute();
    $stmt->close();
  } else if($col === "username") {
    $query = "UPDATE bookmarks SET username = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $val, $uname);
    $stmt->execute();
    $stmt->close();

    $img_kucing = array();
    $img_kucing_newest = array();
    $query = "SELECT img_kucing1, img_kucing2, img_kucing3 FROM kucing WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    if ($num) {
      $stmt->bind_result($img_kucing[0], $img_kucing[1], $img_kucing[2]);
      $stmt->fetch();
      $stmt->close();
      for ($i=0; $i < count($img_kucing); $i++) {
        $regex = "/^\.\.\/\.\.\/userData\/[^\/]+\/[^\/]+\/([^\/]+)\/(.+)$/";
        preg_match($regex, $img_kucing[$i], $img_kucing_new);
        $img_kucing_newest[$i] = "../../userData/".$val."/kucing/".$img_kucing_new[1]."/".$img_kucing_new[2];
      }
    } else {
      $stmt->close();
    }
    // print_r($img_kucing_newest);
    $query = "UPDATE kucing SET username = ?, img_kucing1 = ?, img_kucing2 = ?, img_kucing3 = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $val, $img_kucing_newest[0], $img_kucing_newest[1], $img_kucing_newest[2], $uname);
    $stmt->execute();
    $stmt->close();

    $dp = ""; $sampul = "";
    $query = "SELECT dp, sampul FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    if ($num) {
      $stmt->bind_result($dp, $sampul);
      $stmt->fetch();
      $stmt->close();
      $regex = "/^\.\.\/\.\.\/userData\/[^\/]+\/[^\/]+\/[^\.]+(.+)$/";
      preg_match($regex, $dp, $dparr);
      $dp = "../../userData/".$val."/dp/dp_".$val.$dparr[1];
      $regex = "/^\.\.\/\.\.\/userData\/[^\/]+\/[^\/]+\/[^\.]+(.+)$/";
      preg_match($regex, $sampul, $sampularr);
      $sampul = "../../userData/".$val."/sampul/sampul_".$val.$sampularr[1];
    } else {
      $stmt->close();
    }
    // echo "dp : $dp <br>sampul : $sampul";

    $query = "UPDATE users SET username = ?, dp = ?, sampul = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssss", $val, $dp, $sampul, $uname);
    $stmt->execute();
    $stmt->close();
    rename("../../userData/".$uname."/", "../../userData/".$val."/");
    rename("../../userData/".$val."/dp/dp_".$uname.$dparr[1], "../../userData/".$val."/dp/dp_".$val.$dparr[1]);
    rename("../../userData/".$val."/sampul/sampul_".$uname.$sampularr[1], "../../userData/".$val."/sampul/sampul_".$val.$sampularr[1]);

  } else if($col === "password") {
    $password = $val;
    $options = [
      'cost' => 13
    ];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);
    $query = "UPDATE users SET $col = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $password, $uname);
    $stmt->execute();
    $stmt->close();
  }
} else if(isset($_POST["id_prov"]) && isset($_POST["id_kab"]) && isset($_POST["id_kec"]) && isset($_POST["id_kel"]) && isset($_POST["alamat_lengkap"]) && isset($_POST["uname"])) {
  $pesan = "";
  substr(($id_prov = vali_id_prov($_POST["id_prov"])), 0, 3) === "<h1" ? $pesan = $id_prov : $id_prov = $id_prov;
  substr(($id_kab = vali_id_kab($_POST["id_kab"])), 0, 3) === "<h1" ? $pesan = $id_kab : $id_kab = $id_kab;
  substr(($id_kec = vali_id_kec($_POST["id_kec"])), 0, 3) === "<h1" ? $pesan = $id_kec : $id_kec = $id_kec;
  substr(($id_kel = vali_id_kel($_POST["id_kel"])), 0, 3) === "<h1" ? $pesan = $id_kel : $id_kel = $id_kel;
  $uname = vali_input($_POST["uname"]);
  $alamat_lengkap = vali_input($_POST["alamat_lengkap"]);
  if (!$pesan) {
    $query = "UPDATE users SET id_prov = ?, id_kab = ?, id_kec = ?, id_kel = ?, alamat_lengkap = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $id_prov, $id_kab, $id_kec, $id_kel, $alamat_lengkap, $uname);
    $stmt->execute();
    $stmt->close();
  } else {
    echo "Ganti Data ".substr($pesan, 12, -5);
  }
} else if(isset($_POST["trash"]) && isset($_POST["uname"])) {
  $uname = vali_input($_POST["uname"]);
  $arrCol = array("bookmarks", "kucing", "users");
  for ($i=0; $i < 3; $i++) {
    $stmt = $mysqli->prepare("DELETE FROM $arrCol[$i] WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->close();
  }
  function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
      is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    return;
  }
  removeDirectory("../../userData/".$uname."/");
}

 ?>
