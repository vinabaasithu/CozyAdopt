<?php
  session_start();
  if (isset($_POST["rehome"])) {
    if ($_POST["rehome"] === "Rehome Kucing") {
      include 'db.php';
      $target_file_arr = array();
      $k = 0;
      $username = $_SESSION["username"];
      // img_uploading
      for ($i=1; $i <= 3; $i++) {
        $target_dir = "../../userData/".$username."/kucing/img$i/";
        $pesanUpload = "";
        if (!(file_exists($target_dir))) {
          mkdir($target_dir, 0777, true);
        }
        $fileupl = "fileupl".$i;
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
        if (!$_FILES['fileupl1']['error'] && !$_FILES['fileupl2']['error'] && !$_FILES['fileupl3']['error']) {
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
            $target_file_arr[$k++] = $target_file;
            // move_uploaded_file($_FILES[$fileupl]["tmp_name"], $target_file);
              // if (move_uploaded_file($_FILES["fileupl"]["tmp_name"], $target_file)) {
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
        } else {
          $pesan = "Rehome Kucing Gagal, Harap Masukan 3 Foto Kucing Sebagai Data Untuk Profil Kucingmu";
          header("Location: ../../rehome_kucing.php?pesan=$pesan");
          die();
        }

      }

      if ($uploadOk) {
        include 'vali.php';
        $pesan = "";
        // init datetime
        date_default_timezone_set('Asia/Jakarta');
        $waktu = date("Y-m-d H:i:s");
        // init date from form
        substr(($nama_kucing = vali_nama($_POST["nama-kucing"], "Nama Kucing")), 0, 3) === "<h1" ? $pesan = $nama_kucing : $nama_kucing = $nama_kucing;
        $id_jenis_kucing = vali_input($_POST["jenis-kucing"]);
        substr(($umur_kucing = get_enum_data("umur_kucing", vali_input($_POST["umur-kucing"]))), 0, 3) === "<h1" ? $pesan = $umur_kucing : $umur_kucing = $umur_kucing;
        $id_warna_kucing = vali_input($_POST["warna-kucing"]);
        substr(($jk_kucing = get_enum_data("jk_kucing", vali_input($_POST["jk-kucing"]))), 0, 3) === "<h1" ? $pesan = $jk_kucing : $jk_kucing = $jk_kucing;
        substr(($bulu_kucing = get_enum_data("bulu_kucing", vali_input($_POST["bulu-kucing"]))), 0, 3) === "<h1" ? $pesan = $bulu_kucing : $bulu_kucing = $bulu_kucing;
        substr(($id_prov = vali_id_prov($_POST["id_prov"])), 0, 3) === "<h1" ? $pesan = $id_prov : $id_prov = $id_prov;
        substr(($id_kab = vali_id_kab($_POST["id_kab"])), 0, 3) === "<h1" ? $pesan = $id_kab : $id_kab = $id_kab;
        substr(($id_kec = vali_id_kec($_POST["id_kec"])), 0, 3) === "<h1" ? $pesan = $id_kec : $id_kec = $id_kec;
        substr(($id_kel = vali_id_kel($_POST["id_kel"])), 0, 3) === "<h1" ? $pesan = $id_kel : $id_kel = $id_kel;
        $alamat_lengkap = vali_input($_POST["alamat_lengkap"]);
        $info_kucing = vali_input($_POST["info-kucing"]);
        $info_khusus_kucing = vali_input($_POST["info-khusus-kucing"]);
        if (!$alamat_lengkap || !$info_kucing || !$info_khusus_kucing) {
          $pesan = "Rehome Kucing Gagal, Harap Lengkapi Isian Form";
          header($pesan);
          die();
        }
        // isi Sendiri Kucing
        function isiSendiriKucing($name_column, $val_isi_sendiri) {
          include 'db.php';
          $isExists = ""; $id_s = "";
          $stmt = $mysqli->prepare("SELECT id_$name_column, $name_column FROM $name_column WHERE $name_column = ?");
          $stmt->bind_param("s", $val_isi_sendiri);
          $stmt->execute();
          $stmt->bind_result($id_s, $isExists);
          $stmt->fetch();
          $stmt->close();
          if (!$isExists) {
            $stmt = $mysqli->prepare("INSERT INTO ".$name_column." (".$name_column.") VALUES (?)");
            $stmt->bind_param("s", $val_isi_sendiri);
            $stmt->execute();
            $stmt->close();

            $stmt = $mysqli->prepare("SELECT id_$name_column FROM $name_column WHERE $name_column = ?");
            $stmt->bind_param("s", $val_isi_sendiri);
            $stmt->execute();
            $stmt->bind_result($id_new);
            $stmt->fetch();
            $stmt->close();
            $latest_id = $id_new;
          } else {
            $latest_id = $id_s;
          }
          return $latest_id;
        }

        // Validasi jenis_kucing & warna_kucing
        if (isset($_POST["jenis_kucing_isi_sendiri"])) {
            substr(($id_jenis_kucing = vali_nama($id_jenis_kucing, "Jenis Kucing")), 0, 3) === "<h1" ? $pesan = $id_jenis_kucing : $id_jenis_kucing = $id_jenis_kucing;
            if (!$pesan) {
              $id_jenis_kucing = isiSendiriKucing("jenis_kucing", $id_jenis_kucing);
            } else {
              header("Location: ../../rehome_kucing.php?pesan=".substr($pesan, 4, -5));
              die();
            }
        } else {
          substr(($id_jenis_kucing = vali_id_jenis_kucing($id_jenis_kucing)), 0, 3) === "<h1" ? $pesan = $id_jenis_kucing : $id_jenis_kucing = $id_jenis_kucing;
        }
        if (isset($_POST["warna_kucing_isi_sendiri"])) {
            substr(($id_warna_kucing = vali_nama($id_warna_kucing, "Warna Kucing")), 0, 3) === "<h1" ? $pesan = $id_warna_kucing : $id_warna_kucing = $id_warna_kucing;
            if (!$pesan) {
              $id_warna_kucing = isiSendiriKucing("warna_kucing", $id_warna_kucing);
            } else {
              header("Location: ../../rehome_kucing.php?pesan=".substr($pesan, 4, -5));
              die();
            }
        } else {
          substr(($id_warna_kucing = vali_id_warna_kucing($id_warna_kucing)), 0, 3) === "<h1" ? $pesan = $id_warna_kucing : $id_warna_kucing = $id_warna_kucing;
        }
        // END Validasi jenis_kucing & warna_kucing



        //
        if (!$pesan) {
          $stmt = $mysqli->prepare("INSERT INTO kucing (nama_kucing, id_jenis_kucing, umur_kucing, id_warna_kucing,   jk_kucing, bulu_kucing, waktu, username, id_prov, id_kab, id_kec, id_kel, img_kucing1, img_kucing2, img_kucing3, alamat_lengkap, info_kucing, info_khusus_kucing) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssssssssssssssss", $nama_kucing, $id_jenis_kucing, $umur_kucing, $id_warna_kucing, $jk_kucing, $bulu_kucing, $waktu, $username, $id_prov, $id_kab, $id_kec, $id_kel, $targetfile1, $targetfile2, $targetfile3, $alamat_lengkap, $info_kucing, $info_khusus_kucing);
          $stmt->execute();
          $affected_rows = $mysqli->affected_rows;
          $stmt->close();
          header("Location: ../../index.php?pesan=Data $nama_kucing berhasil di upload, Semoga $nama_kucing Cepat mendapat rumah baru..");
          for ($ikuc=0; $ikuc < 3; $ikuc++) {
            move_uploaded_file($_FILES["fileupl".($ikuc+1)]["tmp_name"], $target_file_arr[$ikuc]);
          }
        } else {
          header("Location: ../../rehome_kucing.php?pesan=".substr($pesan, 4, -5));
        }
      }

    }
  }
  if (isset($pesanUpload)) {
    echo $pesanUpload;
  }
 ?>
