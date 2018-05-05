<?php
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
function vali_nama($nama) {
  $nama = vali_input($nama);
  if ( !preg_match("/^([a-zA-Z]+)([a-zA-Z ]*)$/", $nama) ) {
    $pesan = "<h1>Register Gagal, Nama Tidak Boleh Menggunakan Angka Atau Simbol Lainnya</h1>";
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
  // substr(($no_hp = vali_no_hp($no_hp)), 0, 3) === "<h1" ? $pesan = $no_hp : $no_hp = $no_hp;
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

?>
