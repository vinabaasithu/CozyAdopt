<?php
  session_start();
  $mysqli = "";
  if(file_exists("source/etc/db.php")) {
    include 'source/etc/db.php';
  }
  $pesan = "";
  // Register
  if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];
    $dp = "userData/dp_dummy.png";
    $sampul = "userData/sampul_dummy.jpg";
    $lokasi = "0";
    if (!$username || !$nama_lengkap || !$email || !$no_hp || !$password) {
      $pesan = "<h1>Register gagal, harap isi data dengan lengkap</h1>";
    } else {
      $options = [
        'cost' => 13
      ];
      $password = password_hash($password, PASSWORD_BCRYPT, $options);
      $stmt = $mysqli->prepare("INSERT INTO users (username, fullname, password, email, no_hp, dp, sampul, id_prov, id_kab, id_kec, id_kel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssssssss", $username, $nama_lengkap, $password, $email, $no_hp, $dp, $sampul, $lokasi, $lokasi, $lokasi, $lokasi);
      $stmt->execute();
      $affected_rows = $stmt->affected_rows;
      $stmt->close();
      if ($affected_rows == 1) {
        if (!file_exists("userData/$username")) {
          mkdir("userData/$username/kucing/", 0777, true);
          mkdir("userData/$username/dp/", 0777, true);
          mkdir("userData/$username/sampul/", 0777, true);
        }
        $pesan = "<h1 class='success'>Registrasi Berhasil, Silahkan Login :)</h1>";
      } else if($affected_rows == -1) {
        $pesan = "<h1>Registrasi Gagal, Username sudah ada yang punya</h1>";
      }
    }
  }
  // Login
  else if(isset($_POST['login'])) {

    if (isset($_GET["pesan"])) {
      $_GET["pesan"] = null;
    }
    
    $username = $_POST['username_log'];
    $password = $_POST['password_log'];
    $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->bind_result($pass_hash);
    $stmt->fetch();
    $stmt->close();
    if (!$num_rows) {
      $pesan = "<h1>Maaf Username Belum Terdaftar ..</h1>";
    } else {
      if (password_verify($password, $pass_hash)) {
        $pesan = "<h1 class='success'>Login Berhasil</h1>";
        $_SESSION['username'] = $username;
      } else {
        $pesan = "<h1>Login Gagal, Password Salah</h1>";
      }
    }
  }

 ?>
