<?php
  if(session_id() == '') {
    session_start();
  } else if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if (file_exists("db.php")) {
    include "db.php";
  } else if(file_exists("source/etc/db.php")) {
    include "source/etc/db.php";
  }

  if (isset($_SESSION["username"])) {
    $uname_c = $_SESSION["username"];
// form-process-below
    if (isset($_POST["sub-l-a"])) {
      $id_prov = $_POST["id_prov"];
      $id_kab = $_POST["id_kab"];
      $id_kec = $_POST["id_kec"];
      $id_kel = $_POST["id_kel"];
      $alamat_lengkap = $_POST["alamat_lengkap"];
      $stmt = $mysqli->prepare("UPDATE users SET id_prov = ?, id_kab = ?, id_kec = ?, id_kel = ?, alamat_lengkap = ? WHERE username = ?");
      $stmt->bind_param("ssssss", $id_prov, $id_kab, $id_kec, $id_kel, $alamat_lengkap, $uname_c);
      $stmt->execute();
      $stmt->close();
      header("Location: ../../index.php");
    }


    $stmt = $mysqli->prepare("SELECT id_prov, id_kab, id_kec, id_kel FROM users WHERE username = ?");
    $stmt->bind_param("s", $uname_c);
    $stmt->execute();
    $stmt->bind_result($id_prov, $id_kab, $id_kec, $id_kel);
    $stmt->fetch();
    $stmt->close();
    if (!$id_prov || !$id_kab || !$id_kec || !$id_kel) {
      //
      ?>
      <form class="check_for_the_firsttime_f" action="source/etc/check_for_the_firsttime.php" method="post">
      <?php
        if (file_exists("source/etc/select_input.php")) {
          ?>
          <link rel="stylesheet" href="source/css/select_input.css">
          <div class="fixed-form-f-l" style="position: fixed; height: 100vh; width: 100vw; background-color: #0009; z-index: 99; ">
            <div class="fixed-form-f" style="position: fixed; height: 100vh; width: 90vw; background-color: #fff; z-index: 99; margin: auto; left:0; right:0;overflow-y: scroll;"><br><br><br>
              <div class="close-cftff">
                <a href="source/etc/logout.php?r=logout">
                  <i class="fas fa-window-close"></i>
                </a>
              </div>
              <?php include "source/etc/select_input.php"; ?>
            </div>
          </div>
          <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
          <script src="source/js/select_input.js" charset="utf-8"></script>

          <script type="text/javascript">
           $(document).ready(function(){
             $("label[for='tempat-kucing']").html("Satu Langkah Lagi, Mohon Lengkapi Alamat Anda <i class='fas fa-check' color='#0009'></i>");
             $(".isi-d-alamat-a").empty();
             $(".isi-d-alamat-a").after("<input type='submit' name='sub-l-a' value='Lengkapi Alamat' style='background: #2196f3;color:#fffe;padding: 0.8vw;font-size: 1.1em;width: 100%;border: 1px solid #ddd;'>");
           })
          </script>
          <?php
        }
        ?>
        </form>
        <?php
        //
    }
  }
 ?>
