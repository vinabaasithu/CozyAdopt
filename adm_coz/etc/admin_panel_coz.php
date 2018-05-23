<?php
  include '../../source/etc/coz_domain.php';
  if (isset($_POST["val"])) {
    $val = $_POST["val"];
    if ($val === "dashboard") {
      ?>
      <div class="dashboard">
        <div class="h2 text-right dash-title">
         Dashboard &nbsp;&nbsp;&nbsp;
        </div>
        <br><br><br>
        <div id="first-content-dash" class="grid-4">
        <?php
           $arrDash = array(
             array("Used <br>Space", "49/50", "GB", "Custom Space", "fas fa-hdd"),
             array("Registered <br>Users", "4094", "Users", "Check Registered Users", "fas fa-user-plus"),
             array("Online <br>Users", "2004", "Users", "View Online Users", "fas fa-users"),
             array("inactive <br>Users", "400", "Users", "View Inactive Users", "fas fa-user-times")
           );
           for ($i=0; $i < 4; $i++) {
             ?>
             <div class="window">
               <div class="icon-window icon-window-<?php echo $i; ?>">
                 <i class="<?php echo $arrDash[$i][4]; ?>"></i>
               </div>
               <div class="content text-right">
                 <p class="first"><?php echo $arrDash[$i][0]; ?></p>
                 <p class="second"><?php echo $arrDash[$i][1]; ?></p>
                 <p class="third"><?php echo $arrDash[$i][2]; ?></p>
               </div><hr>
               <div class="footer text-center">
                 <p><a href="#"><?php echo $arrDash[$i][3]; ?></a></p>
               </div>
             </div>
             <?php
           }
         ?>
        </div>
        <div id="secont-content-dash" class="grid-2">
          <div class="user-stat">
            <canvas id="user-stat" width="300" height="300"></canvas>
          </div>
          <div class="data-stat">
            <canvas id="data-stat" width="300" height="300"></canvas>
          </div>
        </div>
      </div>
      <?php
    } else if($val === "cozUserData") {
      include '../../source/etc/db.php';
      $orderby = "ORDER BY u.username DESC";
      $query = "SELECT u.fullname, u.username, u.email, u.no_hp, prov.nama, kab.nama, kec.nama, kel.nama, u.alamat_lengkap, u.id_prov, u.id_kab, u.id_kec, u.id_kel FROM users u INNER JOIN provinsi_daerah prov ON u.id_prov = prov.id_prov INNER JOIN kabupaten_daerah kab ON u.id_kab = kab.id_kab INNER JOIN kecamatan_daerah kec ON u.id_kec = kec.id_kec INNER JOIN kelurahan_daerah kel ON u.id_kel = kel.id_kel $orderby LIMIT 20";
      ?>
      <div class="cozUserData">
        <p class="h2 text-right">Data User &nbsp;</p>
        <div class="grid-2 cozy-edit-table">
          <div class="filter">
            <input type="text" name="search" placeholder="Cari.."><button type="button" name="button" class="searchSort"> <i class="fas fa-search"></i> </button>
            <select class="SortBy" name="SortBy">
              <!-- <option value="">Cari Berdasarkan</option> -->
              <option value="fullname">Fullname</option>
              <option value="username">Username</option>
              <option value="email">Email</option>
              <option value="no_hp">No.HP</option>
              <option value="alamat">Alamat</option>
            </select>
          </div>
          <div class="add-data text-right">
            <small class="pagination">page 1-3/3</small>
            <small class="add-data-user">add data <i class="fas fa-plus"></i> </small>
          </div>
        </div>
        <table class="adm_table">
          <tr>
            <th val="fullname">Fullname <i class="fas fa-chevron-circle-up"></i><i class="fas fa-chevron-circle-down"></i> </th>
            <th val="username">Username <i class="fas fa-chevron-circle-up"></i><i class="fas fa-chevron-circle-down"></i></th>
            <th val="email">Email <i class="fas fa-chevron-circle-up"></i><i class="fas fa-chevron-circle-down"></i></th>
            <th val="no_hp">No.HP <i class="fas fa-chevron-circle-up"></i><i class="fas fa-chevron-circle-down"></i></th>
            <th val="alamat">Alamat <i class="fas fa-chevron-circle-up"></i><i class="fas fa-chevron-circle-down"></i></th>
            <th>Password</th>
            <th>Delete</th>
          </tr>
        <?php
          $arrData = array();
          $stmt = $mysqli->prepare($query);
          $stmt->execute();
          $stmt->store_result();
          $num_rows = $stmt->num_rows;
          $stmt->bind_result($fullname, $username, $email, $no_hp, $nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap, $id_prov, $id_kab, $id_kec, $id_kel);
          $ind=0;
          while ($stmt->fetch()) {
            $arrData[$ind]["fullname"] = $fullname;
            $arrData[$ind]["username"] = $username;
            $arrData[$ind]["email"] = $email;
            $arrData[$ind]["no_hp"] = $no_hp;
            $arrData[$ind++]["nama_prov"] = $nama_prov;
            ?>
              <tr id="id<?php echo $ind-1; ?>" class="getUser">
                <td class="td_edit"><?php echo $fullname ?></td><td class="read"><?php echo $username ?></td><td class="td_edit"><?php echo $email ?></td><td class="td_edit"><?php echo $no_hp ?></td><td class="td_alamat" prov="<?php echo $id_prov ?>" kab="<?php echo $id_kab ?>" kec="<?php echo $id_kec ?>" kel="<?php echo $id_kel ?>" kelnam="<?php echo $nama_kel ?>" aleng="<?php echo $alamat_lengkap ?>"><?php echo "$nama_prov, $nama_kab, $nama_kec, $nama_kel, $alamat_lengkap"; ?> </td>
                <td class="text-center bkn-text td_pass td_edit"> <i class="fas fa-key"></i> </td> <td class="text-center bkn-text trash-del"> <i class="fas fa-trash-alt"></i> </td>
              </tr>
            <?php
          }
          $stmt->close();
         ?>
       </table>
       <div class="modal-alamat">
         <div class="alamat-form">
           <?php include '../../source/etc/select_input.php'; ?>
         </div>
       </div>

       <script type="text/javascript">
         // modal-alamat
         $(".modal-alamat label[for='tempat-kucing']").attr("for","alamat-user").text("Ganti Alamat User");
         $(".modal-alamat em strong small").eq(0).text("Pilih Lokasi User");
         $(".modal-alamat em strong small").eq(1).text("Alamat Lengkap User");
         $(".modal-alamat #alamat_lengkap").attr("placeholder", "Isi dengan nama jalan atau nomor rumah user");
         $(".modal-alamat label[for='isiAlamatAuto']").html("<button class='btn-primary' id='chg-alamat'>Ganti Alamat User</button>");
         // on-click-modal-alamat
         var flushModalAlamat = function() {
           $("#hidden_id_prov").val("");
           $("#hidden_id_kab").val("");
           $("#hidden_id_kec").val("");
           $("#hidden_id_kel").val("");
           $("#prov-text-id").val("");
           $("#kab-text-id").val("");
           $("#kec-text-id").val("");
           $("#kel-text-id").val("");
           $("#alamat_lengkap").val("");
           $("#uname-alamat").remove();
           $("#modal-id-tr").remove();
         }
         $(document).on("click", ".td_alamat", function(){
           flushModalAlamat();
           var trId = $(this).parents("tr").attr("id");
           var reg = /^([^0-9,]+), ([^0-9,]+), ([^0-9,]+), (.+)$/;
           var a = $(this).text();
           var arrMatch = a.match(reg);

           if (trId === "newdata") {
             $(".modal-alamat label[for='isiAlamatAuto']").hide();
           } else {
             $(".modal-alamat label[for='isiAlamatAuto']").show();
           }

           if(arrMatch !== null) {
             $("#hidden_id_prov").val($(this).attr("prov"));
             $("#hidden_id_kab").val($(this).attr("kab"));
             $("#hidden_id_kec").val($(this).attr("kec"));
             $("#hidden_id_kel").val($(this).attr("kel"));
             $("#prov-text-id").val(arrMatch[1]);
             $("#kab-text-id").val(arrMatch[2]);
             $("#kec-text-id").val(arrMatch[3]);
             $("#kel-text-id").val($(this).attr("kelnam"));
             $("#alamat_lengkap").val($(this).attr("aleng"));
           }

           var tridp = $(this).parents("tr").attr("id");
           var uname = $("#"+tridp+" td").eq(1).text();
           $("#alamat_lengkap").after("<input type='hidden' id='uname-alamat'>");
           $("#alamat_lengkap").after("<input type='hidden' id='modal-id-tr'>");
           $("#uname-alamat").val(uname);
           $("#modal-id-tr").val(tridp);
           //
           $(".alamat-form").hide();
           $(".modal-alamat").slideDown(800);
           $(".alamat-form").slideDown(800);
         });
         $(document).on("click", ".modal-alamat", function(e){
           if ($(".modal-alamat label[for='isiAlamatAuto']").css("display") === "none" && e.target === this) {
             $(".alamat-form").slideUp(800);
             $(".modal-alamat").slideUp(800);
           } else if (e.target === this) {
             flushModalAlamat();
             $(".alamat-form").slideUp(800);
             $(".modal-alamat").slideUp(800);
           }
         });
       </script>
       <script type="text/javascript">
         // onclick orderby
         var updown = function(dis){
           setTimeout(function(){
             dis.fadeIn(400);
           }, 400);
         }
         var funcOrderBy = function(dis){
           var up = $(dis).find(".fa-chevron-circle-up");
           var upDisplay = up.css("display");
           var down = $(dis).find(".fa-chevron-circle-down");
           var downDisplay = down.css("display");
           if (up[0] === undefined) { return 0 };
            for (var i = 0; i < 5; i++) {
              if (i === $(dis).index()) {
                continue;
              }
              var a = $(".adm_table th").eq(i).find(".fa-chevron-circle-up");
              var b = $(".adm_table th").eq(i).find(".fa-chevron-circle-down");
              if (a.css("display") === "block" || b.css("display") === "block") {
                $(".fa-chevron-circle-up").css("display", "");
                $(".fa-chevron-circle-down").css("display", "");
              }
            }
           if (upDisplay === "none") {
             down.fadeOut(400);
             updown(up);
           } else if(downDisplay === "none") {
             up.fadeOut(400);
             updown(down);
           }
         }
        $(document).on("click", ".adm_table th", function(e) {
          funcOrderBy(this);
         });
         // orderby
         var arrLength = <?php echo count($arrData) ?>;
         var arrData = [];
         <?php
         for ($ind = 0; $ind < count($arrData); $ind++) {
           ?>
           arrData.push(['<?php echo $arrData[$ind]['fullname']; ?>', '<?php echo $arrData[$ind]['username']; ?>', '<?php echo $arrData[$ind]['email'] ?>', '<?php echo $arrData[$ind]['no_hp'] ?>', '<?php echo $arrData[$ind]['nama_prov']; ?>']);
           <?php
         }
         ?>
         // var bandingkan = function (a, b, c) {
           // return a-b;
           // return -1;
           // -1 besar ke kecil
           // 1 kecil ke besar
         // }
         var orderASC = function(a, b){
           return 1;
         }
         var orderDESC = function(a, b){
           return -1;
         }
         function order(a, len, arrnya, orderf) {
           switch (a) {
             case "fullname": a = 0; break;
             case "username": a = 1; break;
             case "email": a = 2; break;
             case "no_hp": a = 3; break;
             case "nama_prov": a = 4; break;
           }
           var arr = [];
           var element = "";
           for (var i = 0; i < len; i++) {
             arr.push([i, arrnya[i][a]]);
           }
           arr.sort(orderf);
           for (var i = 0; i < len; i++) {
             element += "<tr id='id"+arr[i][0]+"' class='getUser' style='display:none;'>"+$("#id"+arr[i][0]).html()+"</tr>";
           }
           $(".getUser").remove();
           $(".adm_table tr").eq(0).after(element);
           $(".getUser").fadeIn(800);
           return arr;
         }
         $(document).on("click", ".adm_table th", function(e) {
           var val = $(this).attr("val");
           if (val === "alamat") {
             val = "nama_prov";
           }
           var ord = orderASC;
           if ((!($(this).find(".fa-chevron-circle-up").css("display") == "block") && !($(this).find(".fa-chevron-circle-down").css("display") == "block")) || $(this).find(".fa-chevron-circle-down").css("display") == "block") {
             ord = orderDESC;
           }
           var arrData2 = order(val, arrData.length, arrData, ord);
         });
         setTimeout(function(){
           $(".adm_table th[val='fullname']").trigger("click");
         }, 400);
         // function search
         var funcSearch = function(arr, sortBy, val) {
           var arrSort = [];
           var a = 0;
           var reg = new RegExp(val, "i");
           var arrSort2 = [];
           switch (sortBy) {
             case "fullname": a = 0; break;
             case "username": a = 1; break;
             case "email": a = 2; break;
             case "no_hp": a = 3; break;
             case "alamat": a = 5; break;
           }
           for (var i = 0; i < arr.length; i++) {
             arrSort.push([i, arr[i][a]]);
           }
           var j = 0;
           var element = "";
           for (var i = 0; i < arrSort.length; i++) {
             if (reg.test(arrSort[i][1])) {
               arrSort2[j++] = arrSort[i][0];
               $("#id"+arrSort[i][0]).fadeIn(200);
             } else {
               $("#id"+arrSort[i][0]).fadeOut(200);
             }
           }
         }
         var searchSortCnE = function() {
           var sortBy = $(".SortBy").val();
           var arr = arrData;
           for (var i = 0; i < arr.length; i++) {
             arr[i][5] = $(".td_alamat").eq(i).text();
           }
           var val = $("input[name='search'][type='text']").val();
           funcSearch(arr, sortBy, val);
         }
         $(document).on("click", ".searchSort", function(){
           searchSortCnE();
         });
         $(document).on("keyup", "input[name='search'][type='text']", function(e){
           if (e.keyCode === 13) {
             searchSortCnE();
           }
         });

         // update inline
         var funcMess = function(teks, length = 1800) {
             $(".pesanE h1").text(teks);
             $(".pesanE").fadeIn(800);
             setTimeout(function(){
               $(".pesanE").fadeOut(800);
             }, length);
             $(".adm_table").trigger("click");
         }
         $(document).on("keyup", "input[class='inp_edit'][type='text'], input[class='inp_edit'][type='password']", function(e){
           if ($(this).parents(".td_pass").hasClass("td_pass_add")) {
             return 0;
           }
           var tridp = $(this).parents("tr").attr("id");
           var index = $(this).parents(".td_edit[val='editing']").index();
           var col = "";
           var uname = $("#"+tridp+" td").eq(1).text();
           if(!uname) {
             uname = $("#"+tridp+" td .inp_edit").attr("placeholder");
           }
           switch (index) {
             case 0: col = "fullname"; break;
             case 1: col = "username"; break;
             case 2: col = "email"; break;
             case 3: col = "no_hp"; break;
             case 5: col = "password"; break;
           }
           var val = $(this).val();
           if (col === "username") {
             funcMess("Mohon Maaf Fitur Belum Tersedia");
           } else if (e.keyCode === 13) {
             $.post("<?php echo $coz_domain ?>adm_coz/etc/adm_edit_inline.php", {uname:uname, col:col, val:val}, function(result){
               if (!result) {
                funcMess("Data Berhasil Diubah");
                $("#"+tridp+" .td_edit").eq(index).text(val);
              } else {
                funcMess(result);
              }
             });
           }
         });
         // ganti alamat
         $(document).on("click", "#chg-alamat", function(){
           var id_prov = $("#hidden_id_prov").val();
           var id_kab = $("#hidden_id_kab").val();
           var id_kec = $("#hidden_id_kec").val();
           var id_kel = $("#hidden_id_kel").val();
           var prov_text = $("#prov-text-id").val();
           var kab_text = $("#kab-text-id").val();
           var kec_text = $("#kec-text-id").val();
           var kel_text = $("#kel-text-id").val();
           var alamat_lengkap = $("#alamat_lengkap").val();
           var uname = $("#uname-alamat").val();
           var modalidtr = $("#modal-id-tr").val();
           $.post("<?php echo $coz_domain ?>adm_coz/etc/adm_edit_inline.php", {id_prov:id_prov, id_kab:id_kab, id_kec:id_kec, id_kel:id_kel, alamat_lengkap:alamat_lengkap, uname:uname}, function(result){
             if (!result) {
               funcMess("Data Berhasil Diubah");
               $(".modal-alamat").trigger("click");
               var tdAlamat = $("#"+modalidtr+" .td_alamat")
               tdAlamat.text(prov_text+", "+kab_text+", "+kec_text+", "+kel_text+", "+alamat_lengkap);
               tdAlamat.attr({
                 prov:id_prov, kab:id_kab, kec:id_kec, kel:id_kel, kelnam:kel_text, aleng:alamat_lengkap
               });
             } else {
               funcMess(result);
             }
           });
         })

         // del data
         $(document).on("click", ".adm_table .trash-del", function(){
           var trId = $(this).parents("tr").attr("id");
           var uname = $("#"+trId+" .td_edit").eq(1).text();
           var trash = "trash";
           if(confirm("Yakin Data Ingin Dihapus ?")) {
             $.post("<?php echo $coz_domain ?>adm_coz/etc/adm_edit_inline.php", {uname:uname, trash:trash}, function(result){
               if (!result) {
                 funcMess("Data Berhasil Dihapus");
                 $("#"+trId).remove();
               }
             });
             alert("Data Berhasil Dihapus");
           } else {
             alert("Data Gagal Dihapus");
           }
         });
         // pagination
         $(document).ready(function(){
           var dataCount = $(".adm_table tr").length - 1;
           var teks = "1-"+dataCount+"/"+dataCount;
           $(".pagination").text(teks);
         });
         // add data
         $(document).on("click", ".trash-temp", function(){
           var tr = $(this).parents("tr");
           tr.remove();
           flushModalAlamat();
         });

         $(document).on("keyup", ".td_pass_add .inp_edit", function(e){
           if (e.keyCode === 13) {
             var tr = $(this).parents("tr");
             var username = tr.find("td input.inp_edit_plus").eq(0).val();
             var nama_lengkap = tr.find("td input.inp_edit_plus").eq(1).val();
             var email = tr.find("td input.inp_edit_plus").eq(2).val();
             var no_hp = tr.find("td input.inp_edit_plus").eq(3).val();
             var password = $(this).val();
             var id_prov = $("#hidden_id_prov").val();
             var id_kab = $("#hidden_id_kab").val();
             var id_kec = $("#hidden_id_kec").val();
             var id_kel = $("#hidden_id_kel").val();
             var prov_text = $("#prov-text-id").val();
             var kab_text = $("#kab-text-id").val();
             var kec_text = $("#kec-text-id").val();
             var kel_text = $("#kel-text-id").val();
             var alamat_lengkap = $("#alamat_lengkap").val();
             var register = "Regist";
             $.post("<?php echo $coz_domain ?>source/etc/sign.php", {username:username, nama_lengkap:nama_lengkap, email:email, no_hp:no_hp, password:password, id_prov:id_prov, id_kab:id_kab, id_kec:id_kec, id_kel:id_kel, alamat_lengkap, register:register}, function(result){
               var res = result.slice(20, -5);
               funcMess(res);
               $("#cozUserData").click();
             });
           }
         });

       </script> 
      </div>
      <?php
    }

  } else {
  }
 ?>
