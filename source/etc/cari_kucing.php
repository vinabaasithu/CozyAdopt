<?php
  session_start();
  include 'db.php';
  $indexTercari = array();
  if (isset($_POST['cari'])) {
    $jenis_kucing = $_POST['jenis_kucing'];
    $umur_kucing = $_POST['umur_kucing'];
    $bulu_kucing = $_POST['bulu_kucing'];
    $warna_kucing = $_POST['warna_kucing'];
    $jk_kucing = $_POST['jk_kucing'];
    $id_prov = $_POST['id_prov'];
    $id_kab = $_POST['id_kab'];
    $id_kec = $_POST['id_kec'];
    $id_kel = $_POST['id_kel'];
    $urut = $_POST['urut'];

    $jenis_kucing = !$jenis_kucing ? "%%" : $jenis_kucing;
    $umur_kucing = !$umur_kucing ? "%%" : $umur_kucing;
    $bulu_kucing = !$bulu_kucing ? "%%" : $bulu_kucing;
    $warna_kucing = !$warna_kucing ? "%%" : $warna_kucing;
    $jk_kucing = !$jk_kucing ? "%%" : $jk_kucing;
    $id_prov = !$id_prov ? "%%" : $id_prov;
    $id_kab = !$id_kab ? "%%" : $id_kab;
    $id_kec = !$id_kec ? "%%" : $id_kec;
    $id_kel = !$id_kel ? "%%" : $id_kel;
    $urut = !$urut ? "" : "ORDER BY $urut DESC";

    $uname_bookmarks = "asdawd2n1ldn12kdb32kbbacb2321";
    $stmt = $mysqli->prepare("SELECT k.nama_kucing, k.img_kucing1, j_k.jenis_kucing, k.umur_kucing, w_k.warna_kucing, k.bulu_kucing, k.jk_kucing, k.id_kucing, k.username FROM kucing k INNER JOIN jenis_kucing j_k ON k.id_jenis_kucing = j_k.id_jenis_kucing INNER JOIN warna_kucing w_k ON k.id_warna_kucing = w_k.id_warna_kucing WHERE k.id_jenis_kucing LIKE ? && k.umur_kucing LIKE ? && k.id_warna_kucing LIKE ? && k.bulu_kucing LIKE ? && k.jk_kucing LIKE ? && k.id_prov LIKE ? && k.id_kab LIKE ? && k.id_kec LIKE ? && k.id_kel LIKE ? $urut");
    $stmt->bind_param("sssssssss", $jenis_kucing, $umur_kucing, $warna_kucing, $bulu_kucing, $jk_kucing, $id_prov, $id_kab, $id_kec, $id_kel);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->bind_result($nama_kucing, $img_kucing1, $jenis_kucing, $umur_kucing, $warna_kucing, $bulu_kucing, $jk_kucing, $id_kucing, $username);
    $i = 0;
    $arrSel = array();
    while ($stmt->fetch()) {
      $arrSel[$i]["nama_kucing"] = $nama_kucing;
      $arrSel[$i]["img_kucing1"] = $img_kucing1;
      $arrSel[$i]["jenis_kucing"] = $jenis_kucing;
      $arrSel[$i]["umur_kucing"] = $umur_kucing;
      $arrSel[$i]["warna_kucing"] = $warna_kucing;
      $arrSel[$i]["bulu_kucing"] = $bulu_kucing;
      $arrSel[$i]["jk_kucing"] = $jk_kucing;
      $arrSel[$i]["id_kucing"] = $id_kucing;
      $arrSel[$i]["username"] = $username;
      $i++;
    }
    $stmt->close();
    echo "<div class='container-cari'>";
    for ($i=0; $i < count($arrSel); $i++) {

        if (substr($arrSel[$i]["img_kucing1"], 0, 6) === "../../") {
          // $img_kucing1 = "../../../".substr($img_kucing1, 6);
          $arrSel[$i]["img_kucing1"] = "../".$arrSel[$i]["img_kucing1"];
        }
        $bookmarked = "";
        if (isset($_SESSION["username"])) {
          $stmt = $mysqli->prepare("SELECT username FROM bookmarks WHERE username = ? && id_kucing = ?");
          $stmt->bind_param("ss", $_SESSION["username"], $arrSel[$i]["id_kucing"]);
          $stmt->execute();
          $stmt->bind_result($uname_bookmarks);
          $stmt->fetch();
          $stmt->close();
          if ($uname_bookmarks === $_SESSION["username"]) {
            $bookmarked = "bookmarked";
          }
        }
        ?>
        <div class="isi-con-cari" nm="<?php echo $arrSel[$i]["nama_kucing"] ?>" img="<?php echo $arrSel[$i]["img_kucing1"] ?>" jk="<?php echo $arrSel[$i]["jenis_kucing"] ?>" uk="<?php echo $arrSel[$i]["umur_kucing"] ?>" wk="<?php echo $arrSel[$i]["warna_kucing"] ?>" bk="<?php echo $arrSel[$i]["bulu_kucing"] ?>" kuc="<?php echo $arrSel[$i]["id_kucing"] ?>" jkel="<?php echo $arrSel[$i]["jk_kucing"] ?>" >
          <img src="source/img/kucing/<?php echo $arrSel[$i]["img_kucing1"] ?>" alt="<?php echo $arrSel[$i]["img_kucing1"] ?>">
          <div class="text-kucing">
            <p><strong><?php echo $arrSel[$i]["nama_kucing"]. ", ".  $arrSel[$i]["jenis_kucing"].", ". $arrSel[$i]["umur_kucing"] ?></strong></p>
            <p><?php echo "Uploaded by ".$arrSel[$i]["username"] ?></p>
            <div class="bookmarks">
              <i class="fas fa-star <?php echo $bookmarked ?>" val="<?php echo $arrSel[$i]["id_kucing"] ?>"></i>
            </div>
          </div>
        </div>
        <?php
    }
    echo "</div>";
  }


 ?>
