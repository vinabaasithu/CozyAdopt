<?php
$pesanE = "";
$adaIndex = "";
if(!isset($index)) $adaIndex = "index.php" ;
 ?>
<?php
  if (isset($_GET['pesan'])) {
    $pesanE = $_GET['pesan'];
    ?>
    <div class="pesanE">
      <h1><?php echo $pesanE ?></h1>
    </div> <?php
  }
 ?>
 <?php include "check_for_the_firsttime.php"; ?>

 <script type="text/javascript">
   var userparam = "<?php if(isset($r)) { echo $r; } ?>";
   var userses = "<?php if (isset($_SESSION['username'])) { echo $_SESSION['username']; } ?>";
 </script>
 <div class="container-header">
   <header>
     <a class="logo" href="<?php echo $adaIndex ?>#home">
       <div class="">
         CozyAdopt
       </div>
     </a>
     <nav class="nav-head">
       <ul>
         <!-- <a href="<?php echo $adaIndex ?>#find"><li>Cari Kami</li></a> -->
         <a href="<?php echo $adaIndex ?>#tentang"><li>Tentang Kami</li></a>
         <a href="<?php echo $adaIndex ?>#kontak"><li>Kontak</li></a>
         <a href="adopt_kucing.php"><li>Adopt Kucing</li></a>
         <a href="rehome_kucing.php"><li>Rehome Kucing</li></a>
         <?php
            if (isset($_SESSION["username"])) {
              $dpUniv = "";
              include 'source/etc/selectDP.php';
              ?>
              <div href="#" class="dp_header">
                <div class="click-dp"> <img src="<?php echo $dpUniv ?>" alt=""> </div>
                <div class="menu_dp_header">
                  <ul>
                    <a href="profil.php?r=<?php echo $_SESSION["username"]; ?>"><li>Profil</li></a>
                    <!-- <a href="#"><li>Settings</li></a> -->
                    <a href="source/etc/logout.php?r=logout"><li>Logout</li></a>
                  </ul>
                </div>
              </div>
              <?php
            } else {
              ?>
            <a href="sign.php"><li>Login</li></a>
            <a href="sign.php?r=reg"><li>Register</li></a>
            <?php
            }
         ?>

       </ul>
     </nav>
     <div class="nav-head-min">
       <a class="min-logo" href="<?php echo $adaIndex ?>#home">
         <div class="">
           CozyAdopt
         </div>
       </a>
     </div>
     <div class="burger-menu">
       <i class="fas fa-bars"></i>
     </div>
   </header>
    <div class="menu-nav-min">
      <ul>
        <a href="<?php echo $adaIndex ?>#tentang"><li>Tentang Kami</li></a>
        <a href="<?php echo $adaIndex ?>#kontak"><li>Kontak</li></a>
        <a href="adopt_kucing.php"><li>Adopt Kucing</li></a>
        <a href="rehome_kucing.php"><li>Rehome Kucing</li></a>
        <?php
           if (isset($_SESSION["username"])) {
             $dpUniv = "";
             include 'source/etc/selectDP.php';
             ?>
             <div href="#" class="dp_header text-center dp_header_min">
               <div class="click-dp"> <img src="<?php echo $dpUniv ?>" alt=""> </div>
               <div class="">
                 <ul>
                   <a href="profil.php?r=<?php echo $_SESSION["username"]; ?>"><li>Profil</li></a>
                   <a href="#"><li>Settings</li></a>
                   <a href="source/etc/logout.php?r=logout"><li>Logout</li></a>
                 </ul>
               </div>
             </div>
             <?php
           } else {
             ?>
           <a href="sign.php"><li>Login</li></a>
           <a href="sign.php?r=reg"><li>Register</li></a>
           <?php
           }
        ?>
      </ul>
    </div>
 </div>
