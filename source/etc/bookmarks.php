<?php
  session_start();
  if (isset($_POST["bookmarks"]) && isset($_POST["id_kucing"]) && isset($_SESSION["username"])) {
    if ($_POST["bookmarks"] === "bookmarks") {
      include 'db.php';
      $uname = $_SESSION["username"];
      $id_kucing = $_POST["id_kucing"];
      // init datetime
      date_default_timezone_set('Asia/Jakarta');
      $waktu = date("Y-m-d H:i:s");

      $stmt = $mysqli->prepare("SELECT username, id_kucing, waktu FROM bookmarks WHERE username = ? && id_kucing = ?");
      $stmt->bind_param("ss", $uname, $id_kucing);
      $stmt->execute();
      $stmt->store_result();
      $num_rows = $stmt->num_rows;
      // $stmt->bind_result($uname, $id_kucing, $waktu);
      // $stmt->fetch();
      $stmt->close();
      if (!$num_rows) {
        $stmt = $mysqli->prepare("INSERT INTO bookmarks (username, id_kucing, waktu) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uname, $id_kucing, $waktu);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        if ($affected_rows) { echo "INSERT BERHASIL"; }
      } else {
        $stmt = $mysqli->prepare("DELETE FROM bookmarks WHERE username = ? && id_kucing = ?");
        $stmt->bind_param("ss", $uname, $id_kucing);
        $affected_rows = $stmt->affected_rows;
        $stmt->execute();
        $stmt->close();
        if ($affected_rows) { echo "HAPUS BERHASIL"; }
      }
    }
  }
 ?>
