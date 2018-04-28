<?php
  session_start();
  if (!isset($_GET["r"])) {
    header("Location: index.php");
  } else {
    $r = $_GET["r"];
    include 'source/etc/db.php';
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
      $stmt = $mysqli->prepare("UPDATE users SET $col = ? WHERE username = ?");
      $stmt->bind_param("ss", $isi, $username);
      $stmt->execute();
      $stmt->close();
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
  </head>
  <body>
  <?php include 'source/etc/header.php'; ?>

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
          <div class="ganti-dp text-center">
            Ganti DP
          </div>
          <div class="full-name">
            <p class="h1"><?php echo $fname ?></p>
          </div>
        </div>
      </div>

      <div class="ganti-sampul">
        <i class="fas fa-edit"></i>
      </div>
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
            <input type="hidden" name="isi" value="alamat">
            <div class="isi-clicked" val="alamat-clicked">
              <br>
              <?php include 'source/etc/select_input.php'; ?>
              <p class="text-center">
                <input class="edit_isi_submit" type="submit" name="edit_isi_submit" value="Edit">
                <input class="edit_isi_submit" type="reset" name="reset_isi_submit" value="Cancel" val="alamat">
              </p>
            </div>
          </p>
        </form>
      </div>
    </div>
  </div>

  <?php include 'source/etc/footer.php'; ?>
  <script src="source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
  <script src="source/js/fontawesome-all.min.js" charset="utf-8"></script>
  <script src="source/js/header.js" charset="utf-8"></script>
  <script src="source/js/img_preview.js" charset="utf-8"></script>
  <script src="source/js/select_input.js" charset="utf-8"></script>
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
      $("#upl").change(function(){
        $(".modal").css("height", "auto");
        $(".img-upl-front .grid").html("<span>Ganti</span>");
        $(".img-upl-front .grid").css("margin-bottom", "50px");
        $(this).attr("type", "button");
        $(this).attr("class", "form-control upl-changed");
      });
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
    });

    $(document).on("mouseleave", ".kucing_saya_container", function(){
      $(this).find(".edit-kucing").fadeOut(800);
    });

    $(document).on({
      mouseenter: function () {
        $(this).find("span .isi-edit").css("display", "inline-block");
        },
      mouseleave: function () {
        $(this).find("span .isi-edit").css("display", "none");
      }
    }, '.isi p');
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
  </script>
  </body>
</html>
