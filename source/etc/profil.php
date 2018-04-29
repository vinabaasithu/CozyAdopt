<?php
  session_start();
  if (isset($_POST["id"])) {
    include 'db.php';
    $id = $_POST["id"];
    $r = $_POST["r"];
    if ($id === "info") {
        $stmt = $mysqli->prepare("SELECT u.fullname, u.email, u.no_hp, prov.nama, kab.nama, kec.nama, kel.nama, u.alamat_lengkap FROM users u INNER JOIN provinsi_daerah prov ON u.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON u.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON u.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON u.id_kel = kel.id_kel WHERE username = ?");
        $stmt->bind_param("s", $r); $stmt->execute();
        $stmt->bind_result($fname, $email, $no_hp, $prov, $kab, $kec, $kel, $ualamat_lengkap);
        $stmt->fetch();
        $stmt->close();
        $kabn = ucfirst(strtolower($kab));
        $kab = substr($kab, 0, 6).substr($kabn, 6);
        ?>
        <?php $edit = "";
          if (isset($_SESSION["username"])) {
            if ($r === $_SESSION["username"]) {
              $edit = "<i class='fas fa-edit'></i></span>";
            }
          }
         ?>
        <form class="" action="" method="post">
          <p>
            <span val="fname"><span class="spanw">Nama </span> : <?php echo $fname. " <span class='isi-edit' vale='fname'>" .$edit. "</span>"; ?></span>
            <span class="isi-clicked" val="fname-clicked"><span class="spanw">Nama </span> :
              <input class="textinput-isi" type="text" name="isi" placeholder="<?php echo $fname ?>">
              <input type="hidden" name="col" value="fullname">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="fname" >
            </span>
          </p>
        </form>
        <form class="" action="" method="post">
          <p>
            <span val="email"><span class="spanw">Email</span> : <?php echo $email. " <span class='isi-edit' vale='email'>" .$edit. "</span>";  ?></span>
            <span class="isi-clicked" val="email-clicked"><span class="spanw">Email</span> :
              <input class="textinput-isi" type="email" name="isi" placeholder="<?php echo $email ?>">
              <input type="hidden" name="col" value="email">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="email" >
            </span>
          </p>
        </form>
        <form class="" action="" method="post">
          <p>
            <span val="no-hp"><span class="spanw">Nomor HP</span> : <?php echo $no_hp. " <span class='isi-edit' vale='no-hp'>" .$edit. "</span>";  ?></span>
            <span class="isi-clicked" val="no-hp-clicked"><span class="spanw">Nomor HP</span> :
              <input class="textinput-isi" type="text" name="isi" placeholder="<?php echo $no_hp ?>">
              <input type="hidden" name="col" value="no_hp">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="no-hp">
            </span>
          </p>
        </form>
        <form class="" action="" method="post">
          <p>
            <span val="alamat"><span class="spanw">Alamat</span> : <?php echo "$prov, $kab, $kec, $kel, $ualamat_lengkap". " <span class='isi-edit' vale='alamat'>" .$edit. "</span>"; ?>
            </span>
            <div class="isi-clicked" val="alamat-clicked">
              <br>
              <?php include 'select_input.php'; ?>
              <p class="text-center">
                <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
                <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="alamat">
              </p>
            </div>
          </p>
        </form>
      <?php
    } else if ($id === "kucing_saya") {
      $stmt = $mysqli->prepare("SELECT k.nama_kucing, k.img_kucing1, k.img_kucing2, k.img_kucing3, j_k.jenis_kucing, k.umur_kucing, k.jk_kucing, k.bulu_kucing, k.id_kucing FROM kucing k INNER JOIN jenis_kucing j_k ON k.id_jenis_kucing = j_k.id_jenis_kucing INNER JOIN warna_kucing w_k ON k.id_warna_kucing = w_k.id_warna_kucing WHERE username = ? ");
      $stmt->bind_param("s", $r);
      $stmt->execute();
      $stmt->bind_result($nama_kucing, $img_kucing1, $img_kucing2, $img_kucing3, $jenis_kucing, $umur_kucing, $jk_kucing, $bulu_kucing, $id_kucing);
      $ia = 0;
      $arrSel = array();
      while ($stmt->fetch()) {
        $arrSel[$ia]["nama_kucing"] = $nama_kucing;
        $arrSel[$ia]["img_kucing1"] = $img_kucing1;
        $arrSel[$ia]["img_kucing2"] = $img_kucing2;
        $arrSel[$ia]["img_kucing3"] = $img_kucing3;
        $arrSel[$ia]["jenis_kucing"] = $jenis_kucing;
        $arrSel[$ia]["umur_kucing"] = $umur_kucing;
        $arrSel[$ia]["jk_kucing"] = $jk_kucing;
        $arrSel[$ia]["bulu_kucing"] = $bulu_kucing;
        $arrSel[$ia]["id_kucing"] = $id_kucing;
        $ia++;
      }
      $stmt->close();
      for ($ia=0; $ia < count($arrSel); $ia++) {
          if (substr($arrSel[$ia]["img_kucing1"], 0, 6) === "../../") {
            $arrSel[$ia]["img_kucing1"] = substr($arrSel[$ia]["img_kucing1"], 6);
          } else if(!$arrSel[$ia]["img_kucing1"]) {
            $arrSel[$ia]["img_kucing1"] = "userData/image_not_available.png";
          }

          if (substr($arrSel[$ia]["img_kucing2"], 0, 6) === "../../") {
            $arrSel[$ia]["img_kucing2"] = substr($arrSel[$ia]["img_kucing2"], 6);
          } else if(!$arrSel[$ia]["img_kucing2"]) {
            $arrSel[$ia]["img_kucing2"] = "userData/image_not_available.png";
          }

          if (substr($arrSel[$ia]["img_kucing3"], 0, 6) === "../../") {
            $arrSel[$ia]["img_kucing3"] = substr($arrSel[$ia]["img_kucing3"], 6);
          } else if(!$arrSel[$ia]["img_kucing3"]) {
            $arrSel[$ia]["img_kucing3"] = "userData/image_not_available.png";
          }
          ?>
          <div class="kucing_saya_container">
          <?php
              $bookmarked = "";
              if (isset($_SESSION["username"])) {
                $stmt = $mysqli->prepare("SELECT username FROM bookmarks WHERE username = ? && id_kucing = ?");
                $stmt->bind_param("ss", $_SESSION["username"], $arrSel[$ia]["id_kucing"]);
                $stmt->execute();
                $stmt->bind_result($uname_bookmarks);
                $stmt->fetch();
                $stmt->close();
                if ($uname_bookmarks === $_SESSION["username"]) {
                  $bookmarked = "bookmarked";
                }
              }
           ?>
            <div class="bookmarks bookmarks-in-profil">
               <i class="fas fa-star <?php echo $bookmarked ?>" val="<?php echo $arrSel[$ia]["id_kucing"] ?>"></i>
            </div>
            <div class="edit-kucing">
              <i class="fas fa-edit" val="<?php echo $arrSel[$ia]["id_kucing"] ?>"></i>
            </div>

            <p class="h1"><?php echo $arrSel[$ia]["nama_kucing"] ?></p> <hr> <br><br>
            <div class="grid-3-true">
              <div>
                <img src="<?php echo $arrSel[$ia]["img_kucing1"] ?>" alt="">
              </div>
              <div>
                <img src="<?php echo $arrSel[$ia]["img_kucing2"] ?>" alt="">
              </div>
              <div>
                <img src="<?php echo $arrSel[$ia]["img_kucing3"] ?>" alt="">
              </div>
            </div>  <br> <br> <hr>
            <div class="background5f999b">
              <p class="h1 em12"><?php echo $arrSel[$ia]["nama_kucing"]. ", ". $arrSel[$ia]["jenis_kucing"]. ", ". $arrSel[$ia]["umur_kucing"] ?></p>
              <p class="h1 em12"><?php echo $arrSel[$ia]["nama_kucing"]. " adalah kucing ". strtolower($arrSel[$ia]["jk_kucing"]). " dan berbulu ". strtolower($arrSel[$ia]["bulu_kucing"])  ?></p>
            </div>
          </div>
          <?php
      }

    }
  }
 ?>
