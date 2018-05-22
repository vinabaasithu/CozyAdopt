<?php
  session_start();
  include '../source/etc/coz_domain.php';
  include '../source/etc/db.php';
  include '../source/etc/header_uri.php';
  include '../source/etc/vali.php';
  if (!isset($_SESSION['admin'])) {
    header("Location: ../admin.php");
    die();
  } else {
    $pesan = "";
    substr(($uname = vali_uname($_SESSION['admin'])), 0, 3) === "<h1" ? $pesan = $uname : $uname = $uname;
    if ($pesan) {
      header("Location: ../admin.php");
      die();
    } else {
      $stmt = $mysqli->prepare("SELECT a.username, a.fullname, a.password, a.email, a.no_hp, a.dp, a.gender, a.id_prov, a.id_kab, a.id_kec, a.id_kel, a.alamat_lengkap, prov.nama, kab.nama, kec.nama, kel.nama FROM admin a INNER JOIN provinsi_daerah prov ON prov.id_prov = a.id_prov INNER JOIN kabupaten_daerah kab ON kab.id_kab = a.id_kab INNER JOIN kecamatan_daerah kec ON kec.id_kec = a.id_kec INNER JOIN kelurahan_daerah kel ON kel.id_kel = a.id_kel WHERE a.username = ?");
      $stmt->bind_param("s", $uname);
      $stmt->execute();
      $stmt->bind_result($username, $fullname, $password, $email, $no_hp, $dp, $gender, $id_prov, $id_kab, $id_kec, $id_kel, $alamat_lengkap, $prov_nama, $kab_nama, $kec_nama, $kel_nama);
      $stmt->fetch();
      $stmt->close();
      $m = "";
      switch ($gender) {
        case 'Pria': $m = "Mr."; break;
        case 'Wanita': $m = "Ms."; break;
      }
      $tmp_name = $fullname;
      while (preg_match("/ (.+)/", $tmp_name, $lastname)){
        $tmp_name = $lastname[1];
      }
      $lastname = $m." ".$tmp_name;
    }
  }
?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Coz Admin</title>
     <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/styleUniversal.css">
     <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/styleAdmin_Panel.css">
     <link rel="stylesheet" href="<?php echo $coz_domain ?>source/css/select_input.css">
   </head>
   <body>

     <div class="pesanE">
       <h1></h1>
     </div>
     <div class="menu-container">
       <div class="menu-container-fixed">
         <div class="left-menu" val="show">
           <ul>
             <li class="TitlePage"> <p class="h2 text-center"> <u> <a href="<?php echo $coz_domain; ?>">CozyAdopt</a></u> </p> </li>
             <li id="dashboard"> <i class="fas fa-tachometer-alt"></i> Dashboard </li>
             <li class="li-penghover" val="data"> <i class="fas fa-database"></i> Cozy Data </li>
             <li class="li-dihover" val="data">
               <ul>
                 <li id="cozUserData"> <i class="fas fa-user"></i> User Data </li>
                 <li id="cozCatData"> <i class="fas fa-paw"></i> Cat Data </li>
               </ul>
             </li>
             <li id="cozMess"> <i class="fas fa-envelope"></i> Messages </li>
             <!-- <li> <i class="fas fa-sign-out-alt"></i> Logout </li> -->
           </ul>
         </div>
         <div class="menu-close menu-close-left">
           <div class="menu-close-rel">
             <p class="icon" val="left-menu"> <i class="fas fa-chevron-circle-left"></i> <i class="fas fa-chevron-circle-right"></i> </p>
           </div>
         </div>
       </div>
     </div>

     <div class="panel">
       <div class="head">
         <div class="head-cont-rel">
           <div class="username-name h2">
             Hello <?php echo $lastname; ?>
           </div>
           <div class="dp">
             <img src="<?php echo $coz_domain; ?>userData/dp_dummy.png" alt="">
             <div class="dp-click">
               <span>
                 <i class="fas fa-cog"></i> Settings
               </span>
               <span class="logout-click">
                 <i class="fas fa-sign-out-alt"></i> Logout
               </span>
             </div>
           </div>
         </div>
       </div>
       <!-- isi panel -->
     </div>

      <script src="<?php echo $coz_domain; ?>source/js/jquery-3.3.1.min.js" charset="utf-8"></script>
      <script src="<?php echo $coz_domain; ?>source/js/fontawesome-all.min.js" charset="utf-8"></script>
      <script src="<?php echo $coz_domain; ?>source/js/select_input.js" charset="utf-8"></script>
      <script src="<?php echo $coz_domain; ?>source/js/Chart.min.js"></script>
      <script type="text/javascript">
        // style
        $(".left-menu li").eq(1).css({"background-color":"#9c27b0", "color":"#fff"});
        $(document).on("click", ".left-menu li", function(){
          var disclass = $(this).attr("class");
          if (disclass === "li-dihover" || disclass === "TitlePage") {
            return 0;
          } else if($(this).parents(".li-dihover")[0]) {
            var val = $(this).parents(".li-dihover").attr("val");
            $(".left-menu li").css({"background-color":"", "color":""});
            $(".left-menu li.li-dihover li").css({"background-color":"", "color":""});
            $(".li-penghover[val='"+val+"']").css({"background-color":"#9c27b0", "color":"#fff"});
            $(this).css({"background-color":"#9c27b0", "color":"#fff"});
          } else {
            $(".left-menu li").css({"background-color":"", "color":""});
            $(this).css({"background-color":"#9c27b0", "color":"#fff"});
          }
        });
        // onclick li
        $(document).on("click", "li.li-penghover", function(){
          var val = $(this).attr("val");
          $("li.li-dihover[val='"+val+"']").slideToggle(800);
        });
        // onclick close
        $(document).on("click", ".icon", function(){
          var val = $(this).attr("val");
          var div = $("."+val);
          var valdiv = div.attr("val");
          if (valdiv === "show") {
            div.find("ul").css("visibility", "hidden");
            $(".menu-close-left .fa-chevron-circle-left").hide();
            $(".menu-close-left .fa-chevron-circle-right").show();
            $("body").css("grid-template-columns","0% auto");
            div.attr("val", "hide");
          } else {
            div.find("ul").css("visibility", "");
            $(".menu-close-left .fa-chevron-circle-right").hide();
            $(".menu-close-left .fa-chevron-circle-left").show();
            $("body").css("grid-template-columns","");
            div.attr("val", "show");
          }
          div.toggle(800);
        });
        // resize function
        $(window).resize(function(){
          if (window.matchMedia('(max-width: 901px)').matches) {
            $("#first-content-dash").attr("class", "grid-2");
          } else {
            $("#first-content-dash").attr("class", "grid-4");
          }
        });
        // dp
        $(document).on("click", ".dp", function(){
          $(this).find(".dp-click").fadeToggle(400);
        });
      </script>
      <script type="text/javascript">
        var graphFunc = function() {
          // graph
          var graph1 = $("#user-stat");
          var myChart = new Chart(graph1, {
              type: 'bar',
              data: {
                  labels: ["2013", "2014", "2015", "2016", "2017", "2018"],
                  datasets: [{
                      label: 'Registered User',
                      data: [1202, 2191, 2397, 3025, 3902, 4094],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 206, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(255, 159, 64, 0.2)'
                      ],
                      borderColor: [
                          'rgba(255,99,132,1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero:true
                          }
                      }]
                  }
              }
          });
          var graph2 = $("#data-stat");
          var yLabels = [];
          for (var i = 0; i <= 50; i+=5) {
            yLabels[i] = i+" GB";
          }
          var myChart = new Chart(graph2, {
              type: 'line',
              data: {
                  labels: ["2013", "2014", "2015", "2016", "2017", "2018"],
                  datasets: [{
                      label: 'Data Space Statistics',
                      data: [22, 32, 36, 41, 44, 49]
                      // data: ['22GB', '32GB', '36GB', '41GB', '44GB', '49GB']
                  }]
              },
              options: {
                  responsive: true,
                  tooltips: {
                      callback: {
                      label: function(tooltipItem, data) {
                        alert(data);
                      }
                    }
                  },
                  tooltips : {
                      callbacks : { // HERE YOU CUSTOMIZE THE LABELS
                          title : function() {
                              return 'Penggunaan Memory CozyAdopt';
                          },
                          beforeLabel : function(tooltipItem, data) {
                              return 'Tahun ' + ': ' + tooltipItem.xLabel;
                          },
                          label : function(tooltipItem, data) {
                              return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel+'GB';
                          }
                      }
                  },
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero:true,
                              callback: function(value, index, values) {
                                return yLabels[value];
                              }
                          }
                      }]
                  }
              }
          });

        }
        //

      </script>
      <script type="text/javascript">
      // first display
      var val = "dashboard";
      $.post("/CozyAdopt/adm_coz/etc/admin_panel_coz.php", {val:val}, function(result){
        $("div.panel .head").hide().after(result).fadeIn(800);

        if (val === "dashboard") {
          graphFunc();
        }
      });
      var responWidthPanel = function(){
        var a = $(".menu-container-fixed").width();
        var b = $(".menu-close.menu-close-left").width();
        var c = a+b;
        $(".menu-container").width(c);
        $("body").css("grid-template-columns", c+"px auto");
      };
      $(document).on("click", ".menu-close-rel .icon, .left-menu li", function(){
        setTimeout(function(){
          responWidthPanel();
        }, 800);
      });
      responWidthPanel();
      </script>
      <script type="text/javascript">
        var funcMess = function(teks) {
            $(".pesanE h1").text(teks);
            $(".pesanE").fadeIn(800);
            setTimeout(function(){
              $(".pesanE").fadeOut(800);
            }, 1800);
            $(".adm_table").trigger("click");
        }
        // ajax get data
        $(document).on("click", ".left-menu li", function() {
          var id = $(this).attr("id");
          var val = id;
          if (val === undefined || val === $(".panel > div").attr("class")) {
            return 0;
          } else if(id === "cozCatData" || id === "cozMess") {
            funcMess("Mohon Maaf Fitur Belum Tersedia");
            return 0;
          }
          $.post("<?php echo $coz_domain ?>adm_coz/etc/admin_panel_coz.php", {val:val}, function(result){
            $("div.panel > div:not(.head)").remove();
            $("div.panel .head").hide().after(result).fadeIn(800);
            if (val === "dashboard") {
              graphFunc();
            }
            setTimeout(function(){
              responWidthPanel();
            }, 800);
          });
        });
      </script>
      <script type="text/javascript">
        // table
        var teks = "";
        $(document).on("click", ".adm_table td.td_edit, .adm_table td.td_pass", function(){
          var idTr = $(this).parents("tr").attr("id");
          if ($("#"+idTr+" td")[1] === this) {
            funcMess("Mohon Maaf Fitur Belum Tersedia");
            return 0;
          }
          var a = $(this).attr("class");
          var reg = /td_pass/;
          if (!$(this).find("input[type='text']").length && !$(".adm_table td .inp_edit").length && !reg.test(a)) {
            teks = $(this).text();
            $(this).html("<input class='inp_edit' class='' type='text' placeholder='"+teks+"'>");
            $(".inp_edit").val(teks);
            $(".inp_edit").focus();
            $(this).attr("val", "editing");
          } else if(!$(this).find("input[type='text']").length && !$(".adm_table td .inp_edit").length && reg.test(a)) {
            teks = $(this).html();
            $(this).html("<input class='inp_edit' class='' type='password' placeholder='Password'>");
            $(".inp_edit").focus();
            $(this).attr("val", "editing");
          }
        });
        $(document).on("click", "body", function(e){
          var funcdeled = function(){
            var a = $(".adm_table td[val='editing']");
            a.html(teks);
            a.removeAttr("val");
          }
          if (typeof e.target.attributes["val"] !== 'undefined' ) {
            var a = e.target.attributes["val"].value;
            if (a !== "editing") {
              funcdeled();
            }
          } else if(typeof e.target.attributes["class"] !== 'undefined') {
            var a = e.target.attributes["class"].value;
            if (a !== "inp_edit") {
              funcdeled();
            }
          } else if($(".adm_table td .inp_edit").length) {
            funcdeled();
          }
        });
      </script>
      <script type="text/javascript">
        // logout
        $(document).on("click", ".dp-click .logout-click", function(){
          r = "logout";
          $.post("<?php echo $coz_domain ?>adm_coz/etc/adm_logout.php", {r:r}, function(result){
            window.location = "";
          });
        })
      </script>
   </body>
 </html>
