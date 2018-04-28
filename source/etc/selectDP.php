<?php
  if(session_id() == '') {
    session_start();
  } else if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION["username"])) {
    $uname_f_dp = $_SESSION["username"];
  } else {
    header("Location: index.php");
  }
  if (file_exists("source/etc/db.php")) {
    include "source/etc/db.php";
  }

  $stmt = $mysqli->prepare("SELECT dp FROM users WHERE username = ?");
  $stmt->bind_param("s", $uname_f_dp);
  $stmt->execute();
  $stmt->bind_result($dpUniv);
  $stmt->fetch();
  $stmt->close();
  if (substr($dpUniv, 0, 6) === "../../") {
    $dpUniv = substr($dpUniv, 6);
  }
?>
