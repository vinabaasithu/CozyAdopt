<?php
  session_start();
  include 'db.php';
  if (isset($_POST["ganti"]) && isset($_SESSION["username"])) {
    $ganti = $_POST["ganti"];
    $link = $_POST["link"];
    $username = $_SESSION["username"];

    //
    $target = "/CozyAdopt/userData/".$username."/".$ganti."/".$ganti."_".$username.".png";
    copy($link, $target);

    $stmt = $mysqli->prepare("UPDATE users SET $ganti = ? WHERE username = ?");
    $stmt->bind_param("ss", $target, $username);
    $stmt->execute();
    $stmt->close();
    // clear cache
    clearstatcache();
  }
 ?>
