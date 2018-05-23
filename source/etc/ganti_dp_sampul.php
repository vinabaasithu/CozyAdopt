<?php
  session_start();
  include 'db.php';
  include 'vali.php';
  if (isset($_POST["ganti"]) && isset($_SESSION["username"])) {
    $ganti = vali_input($_POST["ganti"]);
    $link = vali_input($_POST["link"]);
    $username = vali_input($_SESSION["username"]);

    //
    $target = "../../userData/".$username."/".$ganti."/".$ganti."_".$username.".png";
    copy($link, $target);

    $stmt = $mysqli->prepare("UPDATE users SET $ganti = ? WHERE username = ?");
    $stmt->bind_param("ss", $target, $username);
    $stmt->execute();
    $stmt->close();
    // clear cache
    // clearstatcache();
    // header("Cache-Control: no-cache, must-revalidate");
    // header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    // header("Content-Type: application/xml; charset=utf-8");
  }
 ?>
