<?php
  session_start();
  if (isset($_GET["r"]) && isset($_SESSION["username"])) {
    if ($_GET["r"] == "logout") {
      session_destroy();
      header("Location: ../../index.php");
    }
  } else {
    header("Location: ../../index.php");
  }
 ?>
