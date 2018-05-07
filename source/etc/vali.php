<?php
// substr(($no_hp = vali_no_hp($no_hp)), 0, 3) === "<h1" ? $pesan = $no_hp : $no_hp = $no_hp;
if (isset($_POST["vali_uname"])) {
  $vali_uname = $_POST["vali_uname"];
  $vali_uname = vali_uname($vali_uname);
  echo $vali_uname;
}
function vali_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES);
  $data = preg_replace('/\s+/', ' ', $data);
  return $data;
}
function vali_uname($uname) {
  $uname = vali_input($uname);
  include 'db.php';
  $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
  $stmt->bind_param("s", $uname);
  $stmt->execute();
  $stmt->bind_result($adauname);
  $stmt->fetch();
  $stmt->close();
  if ($adauname) {
    $pesan = "<h1>Register Gagal, Username Sudah Ada Yang Punya</h1>";
    return $pesan;
  } else if ( !preg_match("/^[a-zA-Z0-9_-]+$/", $uname) ) {
    $pesan = "<h1>Register Gagal, Format Username Hanya Boleh Menggunakan Huruf, Angka, dan Simbol (_) atau (-)</h1>";
    return $pesan;
  } else {
    return $uname;
  }
}
function vali_nama($nama, $textn="Nama") {
  $nama = vali_input($nama);
  if ( !preg_match("/^([a-zA-Z]+)([a-zA-Z ]*)$/", $nama) ) {
    $pesan = "<h1>Register Gagal, $textn Tidak Boleh Menggunakan Angka Atau Simbol Lainnya</h1>";
    return $pesan;
  } else {
    return $nama;
  }
}
function vali_no_hp($no_hp) {
  $pesan = "";
  $no_hp = vali_input($no_hp);
  if ( !preg_match("/^(0|62|\+62)([0-9]{9,12})$/", $no_hp) ) {
      $pesan .= "<h1>Register Gagal, Harap Input Nomor HP Yang Sesuai ";
    if ( !preg_match("/^(0|62|\+62)/", $no_hp) )  {
      $pesan .= "<br>Awali Digit Nomor HP Dengan 0, 62, atau +62";
    }
    if ( preg_match("/^(0|62|\+62)([0-9]+)$/", $no_hp, $match) ) {
      if (strlen($match[2]) > 12) {
        $pesan .= "<br>Digit Angka Terlalu Banyak";
      } else if (strlen($match[2]) < 9) {
        $pesan .= "<br>Digit Angka Terlalu Sedikit";
      }
    }
    $pesan .= "</h1>";
    return $pesan;
  } else {
    return $no_hp;
  }
  // check with
}
function vali_email($email) {
  $email = vali_input($email);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "<h1>Register Gagal, Format Email Salah</h1>";
    return $emailErr;
  } else {
    return $email;
  }
}
function vali_pass($pass) {
  $pass = vali_input($pass);
  if ( !preg_match("/^[a-zA-Z0-9!@#\$\^\*\-\=_\+\.,]+$/", $pass) ) {
    $pesan = "<h1>Register Gagal, Password Mengandung Karakter Yang Tidak Didukung</h1>";
    return $pesan;
  } else {
    return $pass;
  }
}
/* <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> //tambah pada action form <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>*/
function vali_id($id, $table) {
  include 'db.php';
  $id = vali_input($id);
  $vali = 0;
  $column = "";
  switch ($table) {
    case 'provinsi_daerah': $ptext = "Provinsi Daerah"; $column = "id_prov"; break;
    case 'kabupaten_daerah': $ptext = "Kabupaten Daerah"; $column = "id_kab"; break;
    case 'kecamatan_daerah': $ptext = "Kecamatan Daerah"; $column = "id_kec"; break;
    case 'kelurahan_daerah': $ptext = "Kelurahan Daerah"; $column = "id_kel"; break;
    case 'jenis_kucing': $ptext = "Jenis Kucing"; $column = "id_jenis_kucing"; break;
    case 'warna_kucing': $ptext = "Warna Kucing"; $column = "id_warna_kucing"; break;
    case 'kucing': $ptext = "Id Kucing"; $column = "id_kucing"; break;
  }
  $stmt = $mysqli->prepare("SELECT $column FROM $table ORDER BY $column ASC");
  $stmt->execute();
  $stmt->bind_result($id_s);
  while ($stmt->fetch()) {
    if ($id == $id_s) {
      $vali = 1;
      break;
    }
  }
  $stmt->close();
  if (!$vali) {
    $pesan = "<h1>Register Gagal, $ptext Tidak Terdaftar</h1>";
    return $pesan;
  } else {
    return $id;
  }
}
function vali_id_prov($id_prov) {
  return vali_id($id_prov, "provinsi_daerah");
}
function vali_id_kab($id_kab) {
  return vali_id($id_kab, "kabupaten_daerah");
}

function vali_id_kec($id_kec) {
  return vali_id($id_kec, "kecamatan_daerah");
}
function vali_id_kel($id_kel) {
  return vali_id($id_kel, "kelurahan_daerah");
}
function vali_id_jenis_kucing($id_jenis_kucing) {
  return vali_id($id_jenis_kucing, "jenis_kucing");
}
function vali_id_warna_kucing($id_warna_kucing) {
  return vali_id($id_warna_kucing, "warna_kucing");
}
function vali_id_kucing($id_kucing) {
  return vali_id($id_kucing, "kucing");
}
// FUNCTION GET ENUM VALUES
function get_enum_data($fields, $input) {
  include 'db.php';
  $data = "";
  switch ($fields) {
    case 'umur_kucing': $data = "Umur Kucing"; break;
    case 'jk_kucing': $data = "Jenis Kelamin Kucing"; break;
    case 'bulu_kucing': $data = "Bulu Kucing"; break;
  }
  $stmt = $mysqli->prepare("SHOW COLUMNS FROM kucing WHERE FIELD = ?");
  $stmt->bind_param("s", $fields);
  $stmt->execute();
  $stmt->bind_result($field, $type, $null, $key, $default, $extra);
  while ($stmt->fetch()) {
    if(preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches)) {
      $enum = explode("','", $matches[1]);
      $enum = array_filter($enum);
    }
  }
  $stmt->close();
  for ($ig=0; $ig < count($enum); $ig++) {
      if ($enum[$ig] === $input) {
        return $input;
        break;
      }
  }
  if ($ig === count($enum)) {
    $pesan = "<h1>Register Gagal, $data Tidak Terdaftar</h1>";
    return $pesan;
  }
}
?>
