<?php
  session_start();
  if (isset($_POST["rehome"])) {
    if ($_POST["rehome"] === "Rehome Kucing") {
      include 'db.php';
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
      }

      if ($uploadOk) {
        // init datetime
        date_default_timezone_set('Asia/Jakarta');
        $waktu = date("Y-m-d H:i:s");
        // init date from form
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

        $stmt = $mysqli->prepare("INSERT INTO kucing (nama_kucing, id_jenis_kucing, umur_kucing, id_warna_kucing,   jk_kucing, bulu_kucing, waktu, username, id_prov, id_kab, id_kec, id_kel, img_kucing1, img_kucing2, img_kucing3, alamat_lengkap, info_kucing, info_khusus_kucing) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssss", $nama_kucing, $id_jenis_kucing, $umur_kucing, $id_warna_kucing, $jk_kucing, $bulu_kucing, $waktu, $username, $id_prov, $id_kab, $id_kec, $id_kel, $targetfile1, $targetfile2, $targetfile3, $alamat_lengkap, $info_kucing, $info_khusus_kucing);
        $stmt->execute();
        $affected_rows = $mysqli->affected_rows;
        $stmt->close();
        header("Location: index.php?pesan=Data $nama_kucing berhasil di upload, Semoga $nama_kucing Cepat mendapat rumah baru..");
      }

    }
  }
  if (isset($pesanUpload)) {
    echo $pesanUpload;
  }
 ?>
