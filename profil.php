<?php
  session_start();
  if (!isset($_GET["r"])) {
    header("Location: index.php");
  } else {
    $r = $_GET["r"];
    include 'source/etc/db.php';
  }

  $username = "";
  if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
  }

  if (isset($_POST["edit_isi_submit"])) {
    $username = "";
    if (isset($_SESSION["username"])) {
      $username = $_SESSION["username"];
    }

    $isi = $_POST["isi"];
    if ($isi === "alamat") {
      $id_prov = $_POST["id_prov"];
      $id_kab = $_POST["id_kab"];
      $id_kec = $_POST["id_kec"];
      $id_kel = $_POST["id_kel"];
      $alamat_lengkap = $_POST["alamat_lengkap"];
      $stmt = $mysqli->prepare("UPDATE users SET id_prov = ?, id_kab = ?, id_kec = ?, id_kel = ?, alamat_lengkap = ? WHERE username = ?");
      $stmt->bind_param("ssssss", $id_prov, $id_kab, $id_kec, $id_kel, $alamat_lengkap,  $username);
      $stmt->execute();
      $stmt->close();
    } else {
      $col = $_POST["col"];
      if (isset($_GET["pesan"])) {
        $_GET["pesan"] = null;
      }
      if ($col === "password") {
        $isi = $_POST["isi"];
        $pass = $_POST["pass"];
        $repass = $_POST["repass"];
        if ($pass !== $repass) {
          header("Location: profil.php?r=$r&pesan=Gagal Ganti Password, Password Baru Tidak Sesuai");
        }
        // check old pass
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($passhash); $stmt->fetch();
        $stmt->close();
        if (!password_verify($isi, $passhash)) {
          header("Location: profil.php?r=$r&pesan=Gagal Ganti Password, Password Lama Salah");
        } else {
          $options = [
            'cost' => 13
          ];
          $passnew = password_hash($pass, PASSWORD_BCRYPT, $options);
          $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
          $stmt->bind_param("ss", $passnew, $username);
          $stmt->execute();
          $stmt->close();
          header("Location: profil.php?r=$r&pesan=Ganti Password Berhasil, Password Sudah Diubah");
        }
// lanjutkan
      } else {
        $stmt = $mysqli->prepare("UPDATE users SET $col = ? WHERE username = ?");
        $stmt->bind_param("ss", $isi, $username);
        $stmt->execute();
        $stmt->close();
      }
    }

  }

  // info
  $stmt = $mysqli->prepare("SELECT u.fullname, u.email, u.no_hp, prov.nama, kab.nama, kec.nama, kel.nama, u.alamat_lengkap FROM users u INNER JOIN provinsi_daerah prov ON u.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON u.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON u.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON u.id_kel = kel.id_kel WHERE username = ?");
  $stmt->bind_param("s", $r); $stmt->execute();
  $stmt->bind_result($fname, $email, $no_hp, $prov, $kab, $kec, $kel, $ualamat_lengkap);
  $stmt->fetch();
  $stmt->close();
  $kabn = ucfirst(strtolower($kab));
  $kab = substr($kab, 0, 6).substr($kabn, 6);

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="source/css/styleUniversal.css">
    <link rel="stylesheet" href="source/css/styleHeader.css">
    <link rel="stylesheet" href="source/css/styleProfil.css">
    <link rel="stylesheet" href="source/css/select_input.css">
    <link rel="stylesheet" href="source/css/bookmarks.css">
    <link rel="stylesheet" href="source/css/pelihara.css">
    <link rel="stylesheet" href="source/css/getMajikan.css">
  </head>
  <body>
  <?php include 'source/etc/header.php'; ?>
  <!-- pelihara-container -->
  <div class="pelihara-container">

  </div>
  <!-- Modal -->
  <div class="container-modal">
    <div class="modal">
      <div class="form-group img-upl-con">
        <p class="title text-center"> <strong>Ganti Sampul</strong>  </p>
        <hr>
        <div class="img-preview" id="img-preview">
          <img id="view-img" src="" alt="">
        </div><br><br>
        <div class="img-upl-front">
          <div class="grid">
            <i class="fas fa-arrow-up"></i>
            <i class='border-upload'></i>
            <span>Upload</span>
          </div>
          <input id="upl" type="file" class="form-control" name="fileupl" value="">
        </div>
      </div>
    </div>
  </div>

  <!-- End of Modal -->

  <?php
    $stmt = $mysqli->prepare("SELECT dp, sampul FROM users WHERE username = ? ");
    $stmt->bind_param("s", $r);
    $stmt->execute();
    $stmt->bind_result($dp, $sampul);
    $stmt->fetch();
    $stmt->close();
    if (substr($sampul, 0, 6) === "../../") {
      $sampul = substr($sampul, 6);
    }
    if (substr($dp, 0, 6) === "../../") {
      $dp = substr($dp, 6);
    }
   ?>
  <div class="container-profil">
    <div class="dp-dan-sampul">
      <div class="dp">
        <div class="dp-relative">
          <img src="<?php echo $dp ?>" alt="">
          <?php if($username === $r) {
            ?>
            <div class="ganti-dp text-center">
              Ganti DP
            </div>
            <?php
          }
          ?>
          <div class="full-name">
            <p class="h1"><?php echo $fname ?></p>
          </div>
        </div>
      </div>
      <?php if($username === $r) {
        ?>
        <div class="ganti-sampul">
          <i class="fas fa-edit"></i>
        </div>
        <?php
      } ?>
    </div>

    <div class="grid-3">
      <div class="menu">
        <ul>
          <li class="click-profile" id="info"> <i class="fas fa-info-circle"></i> Info</li>
          <!-- <li class="click-profile" id="update_profil"> <i class="fas fa-cog"></i> Update Profil</li> -->
          <li class="click-profile" id="kucing_saya"> <i class="fas fa-paw"></i> Kucing Saya</li>
          <li class="click-profile" id="favorit_saya"> <i class="fas fa-heart"></i> Kucing Favorit</li>
        </ul>
      </div>
      <?php $edit = "";
        if (isset($_SESSION["username"])) {
          if ($r === $_SESSION["username"]) {
            $edit = "<i class='fas fa-edit'></i></span>";
          }
        }
       ?>
      <div class="isi">
        <form class="" action="" method="post">
          <div class="isi-info">
            <span val="fname">
              <span class="spanw">Nama </span> <span> : </span> <span><?php echo $fname. " <span class='isi-edit' vale='fname'>" .$edit. "</span></span>"; ?>
            </span>
            <span class="isi-clicked isi-click-grid" val="fname-clicked">
              <span class="spanw">Nama </span> :
              <input class="textinput-isi" type="text" name="isi" placeholder="<?php echo $fname ?>" required>
              <input type="hidden" name="col" value="fullname">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="fname" >
            </span>
          </div>
        </form>
        <form class="" action="" method="post">
          <div class="isi-info">
            <span val="email">
              <span class="spanw">Email </span> <span> : </span> <span><?php echo $email. " <span class='isi-edit' vale='email'>" .$edit. "</span></span>";  ?>
            </span>
            <span class="isi-clicked isi-click-grid" val="email-clicked"><span class="spanw">Email</span> :
              <input class="textinput-isi" type="email" name="isi" placeholder="<?php echo $email ?>" required>
              <input type="hidden" name="col" value="email">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="email" >
            </span>
          </div>
        </form>
        <form class="" action="" method="post">
          <div class="isi-info">
            <span val="no-hp">
              <span class="spanw">Nomor HP </span><span> : </span><span><?php echo $no_hp. " <span class='isi-edit' vale='no-hp'>" .$edit. "</span></span>";  ?>
            </span>
            <span class="isi-clicked isi-click-grid" val="no-hp-clicked"><span class="spanw">Nomor HP</span> :
              <input class="textinput-isi" type="text" name="isi" placeholder="<?php echo $no_hp ?>" required>
              <input type="hidden" name="col" value="no_hp">
              <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
              <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="no-hp">
            </span>
          </div>
        </form>
        <form class="" action="" method="post">
          <div class="isi-info">
            <span val="alamat isi-click-grid">
              <span class="spanw">Alamat </span><span> : </span><span><?php echo "$prov, $kab, $kec, $kel, $ualamat_lengkap". "  <span class='isi-edit' vale='alamat'>" .$edit. "</span></span>"; ?>
            </span>
            <input type="hidden" name="isi" value="alamat">
            <div class="isi-clicked" val="alamat-clicked">
              <br>
              <?php include 'source/etc/select_input.php'; ?>
              <p class="text-center">
                <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
                <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="alamat">
              </p>
            </div>
          </div>
        </form>
        <?php if ($username === $r): ?>
          <!-- <form class="" action="" method="post">
            <div class="isi-info">
              <span val="username">
                <span class="spanw">Username </span> <span> : </span> <span><?php echo $username. " <span class='isi-edit' vale='username'>" .$edit. "</span></span>";  ?>
              </span>
              <span class="isi-clicked isi-click-grid" val="username-clicked">
                <span class="spanw">Username</span> :
                <input class="textinput-isi" type="text" name="isi" placeholder="<?php echo $username ?>">
                <input type="hidden" name="col" value="username">
                <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
                <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="username">
              </span>
            </div>
          </form> -->

          <form class="" id="password-form" action="" method="post">
            <div class="isi-info">
              <span val="password">
                <span class="spanw">Password</span> <span> : </span> <span><?php echo "***************". " <span class='isi-edit' vale='password'>" .$edit. "</span></span>";  ?>
              </span>
              <span class="isi-clicked" val="password-clicked">
                <div class="isi-click-grid">
                  <span class="spanw">Password </span> :
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <p>
                  <strong><u>Ganti Password</u></strong>
                </p>
                  <div class="form-group griddl">
                      <label for="passlama">Password Lama </label> <span>:</span>
                      <input class="textinput-isi" id="passlama" type="password" name="isi" placeholder="Password Lama">
                  </div>
                  <div class="form-group griddl">
                      <label for="passbaru">Password Baru </label><span>:</span>
                      <input class="textinput-isi" id="passbaru" type="password" name="pass" placeholder="Password Baru">
                  </div>
                  <div class="form-group griddl">
                      <label for="repasslama">Ketik Ulang Password Lama </label><span>:</span>
                      <input class="textinput-isi" id="repassbaru" type="password" name="repass" placeholder="Ketik Ulang Password Baru">
                  </div>
                  <div class="form-group griddl2">
                      <input type="hidden" name="col" value="password">
                      <span></span>
                      <input class="edit_isi_submit text-center" type="submit" name="edit_isi_submit" value="Edit">
                      <span></span>
                      <input class="edit_isi_submit text-center" type="reset" name="reset_isi_submit" value="Cancel" val="password">
                      <span></span>
                  </div>

              </span>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="getmj">

  </div>
  <?php include 'source/etc/footer.php'; ?>
  <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
  <script src="source/js/fontawesome-all.min.js" charset="utf-8"></script>
  <script src="source/js/header.js" charset="utf-8"></script>
  <script src="source/js/img_preview.js" charset="utf-8"></script>
  <script src="source/js/select_input.js" charset="utf-8"></script>
  <script src="source/js/bookmarks.js" charset="utf-8"></script>
  <script src="source/js/pelihara.js" charset="utf-8"></script>
  <script src="source/js/getMajikan.js" charset="utf-8"></script>
  <script type="text/javascript">
    var sampul = '<?php echo $sampul; ?>';
    $(".dp-dan-sampul").css("background-image", "url('"+sampul+"')");
    $(document).ready(function(){
      $(".dp-dan-sampul").hover(function(e){
        $(".ganti-sampul").fadeIn(800);
      }, function(e){
        $(".ganti-sampul").fadeOut(800);
      });
      $(".dp").hover(function(e){
        $(".ganti-dp").fadeIn(800);
      }, function(e){
        $(".ganti-dp").fadeOut(800);
      });

    });

    $(document).on("change", "#upl", function(){
      $(".modal").css("height", "auto");
      $(".img-upl-front .grid").html("<span>Ganti</span>");
      $(".img-upl-front .grid").css("margin-bottom", "50px");
      $(this).attr("class", "form-control upl-changed");
      var dis = this;
        setTimeout(function(){
          if($(".img-upl-front .grid").text() === "Ganti") {
            $(dis).attr("type", "button");
          }
        }, 500)
    });

    $(document).on("click", ".upl-changed", function(){
      var teks = $(".img-upl-con .title").text();
      var ganti = "";
      if (teks === "Ganti DP") {
        ganti = "dp";
      } else if(teks === "Ganti Sampul") {
        ganti = "sampul";
      }
      var link = $("#view-img").attr("src");
      $.post("source/etc/ganti_dp_sampul.php", {ganti:ganti, link:link}, function(result){
        console.log(result)
        window.location = window.location;
      });
    });

    $(document).on("click", ".ganti-dp, .ganti-sampul", function(ee){
        $(".container-modal").show(800);
        var g = $(this).attr("class");
        if (ee.target === this) {
          if (g !== "ganti-sampul") {
            g = "Ganti DP";
          } else {
            g = "Ganti Sampul";
          }
          $(".img-upl-con .title").text(g);
        }
    });

    $(document).on("click", ".container-modal", function(e){
      if (e.target === this) {
        $(this).hide(800);
        $(".modal").css("height", "40vh");
        $(".img-upl-front .grid").html("<i class='fas  fa-arrow-up'></i><i class='border-upload'></i><span>Upload</span>");
        $("#upl").attr("type", "file");
        $("#upl").attr("class", "form-control");
        $("#view-img").attr("src", "");
        $("#view-img").css("display", "none");
      }
    });
    $(document).on("click", ".click-profile", function(){
      var id = $(this).attr("id");
      var r = '<?php echo $r ?>';
      $.post("source/etc/profil.php", {id:id, r:r}, function(result){
        $(".isi").html(result);
      });
    });
    $(document).on("mouseenter", ".kucing_saya_container", function(){
      $(this).find(".edit-kucing").fadeIn(800);
      if ($(this).find(".edit-kucing").length) {
        $(this).find(".bookmarks.bookmarks-in-profil").animate({"right":"100px"});
      }
    });

    $(document).on("mouseleave", ".kucing_saya_container", function(){
      $(this).find(".edit-kucing").fadeOut(800);
      $(this).find(".bookmarks.bookmarks-in-profil").animate({"right":"34px"});
    });

    $(document).on({
      mouseenter: function () {
        $(this).find("span .isi-edit").css("display", "inline-block");
        },
      mouseleave: function () {
        $(this).find("span .isi-edit").css("display", "none");
      }
    }, '.isi .isi-info');
  </script>

  <script type="text/javascript">
    $(document).on('click', '.isi-edit', function(){
      var vale = $(this).attr("vale");
      if (vale === "alamat") {
        $("div[val='"+vale+"']").hide(800);
        $("div[val='"+vale+"-clicked']").show(800);
      } else {
        $("span[val='"+vale+"']").hide(800);
        $("span[val='"+vale+"-clicked']").show(800);
        setTimeout(function(){
          $("span[val='"+vale+"-clicked']").css("display", "grid");
        }, 900);
      }
      $(document).on('click', "input[type='reset']", function(){
        var val = $(this).attr("val");
        if (val === "alamat") {
          $("div[val='"+val+"-clicked']").hide(800);
          $("div[val='"+val+"']").show(800);
        } else {
          $("span[val='"+val+"-clicked']").hide(800);
          $("span[val='"+val+"']").show(800);
        }
      });
    });
    $(document).ready(function(){
      $("form").off();

    })
  </script>
  <script type="text/javascript">
  var ksc = [];
    $(document).on("click", ".edit-kucing .fa-edit", function(){
      var val = $(this).attr("val");
      var parent = $(this).parents(".kucing_saya_container");
      $.post("source/etc/edit_profil_kucing_saya.php", {val:val}, function(result){
        parent.css("display", "none");
        ksc[val] = parent.html();
        parent.html(result).show(800);
      });
    });
    $(document).on("click", ".kucing_saya_container input[type='reset']", function(){
      var val = $(this).attr("val");
      var parent = $(this).parents(".kucing_saya_container");
      parent.css("display", "none");
      parent.html(ksc[val]).show(800);
    });
    $(document).on("change", ".img-upl-con input[type='file']", function(){
      // alert("change");
      var name = $(this).attr("name");
      $("div[class='close-img'][val='"+name+"']").show(800);
    });
    $(document).on("click", ".close-img-con .fa-window-close", function(){
      var id = $(this).parents(".close-img").attr("val");
      var id2 = "view-img"+id.substr(7);
      id = id.substr(4);
      $("#"+id).parents(".img-upl-front").show(800);
      $("#"+id).val(null);
      $("#"+id2).attr("src", "");
      $(this).parents(".close-img").hide(800);
    });
    $(document).on("click", ".isi-edit[vale='password']", function(){
      // $(".isi-edit[vale='password']").attr("vale");
      var h = $("#passbaru").height();
      $("#passbaru").height(h);
      $("#passlama").height(h);
      $("#repasslama").height(h);
    })
  </script>
  <script type="text/javascript">
    $(document).on("click", ".isi-edit[vale='alamat']", function(){
      if ($("label[for='tempat-kucing']").length) {
        $("label[for='tempat-kucing']").text("Ganti Alamat");
        if ($(".isi-clicked[val='alamat-clicked'] p em strong small")[0].innerHTML === "Harap Pilih Lokasi Anda") {
          $(".isi-clicked[val='alamat-clicked'] p em strong small")[0].innerHTML = "Ganti Lokasi";
          $(".isi-clicked[val='alamat-clicked'] p em strong small")[2].style.display = "none";
          $(".isi-clicked[val='alamat-clicked'] p em strong small label")[0].innerHTML = "Ganti Alamat Lengkap";
          uname = userses;
          $.post("source/etc/isiAlamatAuto.php", {uname:uname}, function(result){
            $(".isi-clicked").parents(".isi-info").append(result);
            var id_prov_p = $(".isi-clicked").parents(".isi-info").find("#id_prov_p").attr("val");
            var nama_prov_p = $(".isi-clicked").parents(".isi-info").find("#nama_prov_p").attr("val");

            var id_kab_p = $(".isi-clicked").parents(".isi-info").find("#id_kab_p").attr("val");
            var nama_kab_p = $(".isi-clicked").parents(".isi-info").find("#nama_kab_p").attr("val");

            var id_kec_p = $(".isi-clicked").parents(".isi-info").find("#id_kec_p").attr("val");
            var nama_kec_p = $(".isi-clicked").parents(".isi-info").find("#nama_kec_p").attr("val");

            var id_kel_p = $(".isi-clicked").parents(".isi-info").find("#id_kel_p").attr("val");
            var nama_kel_p = $(".isi-clicked").parents(".isi-info").find("#nama_kel_p").attr("val");
            var alamat_lengkap_p = $(".isi-clicked").parents(".isi-info").find("#alamat_lengkap_p").attr("val");
            console.log(nama_kel_p);

            $(".container-select-input #hidden_id_prov").val(id_prov_p);
            $(".container-select-input input[type='text'][val='prov']").val(nama_prov_p);
            $(".container-select-input #hidden_id_kab").val(id_kab_p);
            $(".container-select-input input[type='text'][val='kab']").val(nama_kab_p);
            $(".container-select-input #hidden_id_kec").val(id_kec_p);
            $(".container-select-input input[type='text'][val='kec']").val(nama_kec_p);
            $(".container-select-input #hidden_id_kel").val(id_kel_p);
            $(".container-select-input input[type='text'][val='kel']").val(nama_kel_p);
            $("#alamat_lengkap").val(alamat_lengkap_p);

          });
        }
      }
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#password-form").submit(function(e){
        var passlama = $("#passlama").val();
        var passbaru = $("#passbaru").val();
        var repassbaru = $("#repassbaru").val();
        var fank = function(teks) {
          $("body").append("<div class='pesanE'><h1></h1></div>");
          $(".pesanE h1").text(teks);
          $(".pesanE").fadeIn(800);
          setTimeout(function(){
            $(".pesanE").fadeOut(800);
          }, 1000);
        }
        if (!passlama || !passbaru || !repassbaru) {
          fank("Gagal Ganti Password, Harap Lengkapi Isian Form");
          e.preventDefault();
        } else if (passbaru !== repassbaru) {
          fank("Gagal Ganti Password, Password Baru Tidak Sesuai");
          e.preventDefault();
        }
      });
    });

    $(document).on("click", ".pesanE", function (){
      $(this).fadeOut(800);
    });
  </script>
  </body>
</html>
