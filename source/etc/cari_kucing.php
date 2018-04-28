<?php
  include 'db.php';
  $indexTercari = array();
  if (isset($_POST['cari'])) {
    $jenis_kucing = $_POST['jenis_kucing'];
    $umur_kucing = $_POST['umur_kucing'];
    $bulu_kucing = $_POST['bulu_kucing'];
    $warna_kucing = $_POST['warna_kucing'];
    $jk_kucing = $_POST['jk_kucing'];

    $jenis_kucing = !$jenis_kucing ? "%%" : $jenis_kucing;
    $umur_kucing = !$umur_kucing ? "%%" : $umur_kucing;
    $bulu_kucing = !$bulu_kucing ? "%%" : $bulu_kucing;
    $warna_kucing = !$warna_kucing ? "%%" : $warna_kucing;
    $jk_kucing = !$jk_kucing ? "%%" : $jk_kucing;

    $stmt = $mysqli->prepare("SELECT k.nama_kucing, k.img_kucing1, j_k.jenis_kucing, k.umur_kucing, w_k.warna_kucing, k.bulu_kucing, k.jk_kucing, k.id_kucing, k.username FROM kucing k INNER JOIN jenis_kucing j_k ON k.id_jenis_kucing = j_k.id_jenis_kucing INNER JOIN warna_kucing w_k ON k.id_warna_kucing = w_k.id_warna_kucing WHERE k.id_jenis_kucing LIKE ? && k.umur_kucing LIKE ? && k.id_warna_kucing LIKE ? && k.bulu_kucing LIKE ? && k.jk_kucing LIKE ?");
    $stmt->bind_param("sssss", $jenis_kucing, $umur_kucing, $warna_kucing, $bulu_kucing, $jk_kucing);
    $stmt->execute();
    $stmt->bind_result($nama_kucing, $img_kucing1, $jenis_kucing, $umur_kucing, $warna_kucing, $bulu_kucing, $jk_kucing, $id_kucing, $username);
    echo "<div class='container-cari'>";
    while ($stmt->fetch()) {
      if (substr($img_kucing1, 0, 6) === "../../") {
        // $img_kucing1 = "../../../".substr($img_kucing1, 6);
        $img_kucing1 = "../".$img_kucing1;
      }
      ?>
      <div class="isi-con-cari" nm="<?php echo $nama_kucing ?>" img="<?php echo $img_kucing1 ?>" jk="<?php echo $jenis_kucing ?>" uk="<?php echo $umur_kucing ?>" wk="<?php echo $warna_kucing ?>" bk="<?php echo $bulu_kucing ?>" kuc="<?php echo $id_kucing ?>" jkel="<?php echo $jk_kucing ?>" >
        <img src="source/img/kucing/<?php echo $img_kucing1 ?>" alt="<?php echo $img_kucing1 ?>">
        <div class="text-kucing">
          <p><strong><?php echo $nama_kucing. ", ".  $jenis_kucing.", ". $umur_kucing ?></strong></p>
          <p><?php echo "Uploaded by ".$username ?></p>
        </div>
      </div>
      <?php
    }
    echo "</div>";
    $stmt->close();
  }


 ?>
