<?php
  include 'source/etc/db.php';
  if (isset($_POST["update"])) {
    $nama_kucing = $_POST["nama_kucing"];
    $umur_kucing = $_POST["umur_kucing"];
    $id_kucing = $_POST["id_kucing"];
    $stmt = $mysqli->prepare("UPDATE kucing SET nama_kucing = ?, umur_kucing = ? WHERE id_kucing = ?");
    $stmt->bind_param("sss", $nama_kucing, $umur_kucing, $id_kucing);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php");
  }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Admin</title>
     <style media="screen">
       input {
         border: 1px solid #ddd;
       }
     </style>
   </head>
   <body>
       <table>
         <tr>
           <th>Nama Kucing</th> <th>Jenis Kucing</th> <th>Umur Kucing</th>
         </tr>
         <?php
         $stmt = $mysqli->prepare("SELECT k.nama_kucing, j_k.jenis_kucing, k.umur_kucing, k.id_kucing, k.id_jenis_kucing FROM kucing k INNER JOIN jenis_kucing j_k ON k.id_jenis_kucing = j_k.id_jenis_kucing");
         $stmt->execute();
         $stmt->bind_result($nama_kucing, $jenis_kucing, $umur_kucing, $id_kucing, $id_jenis_kucing);
         while ($stmt->fetch()) {
           ?>
           <form class="" action="" method="post">
             <input type="hidden" name="id" value="<?php echo $id_kucing ?>">
             <input type="hidden" name="nama_kucing" value="<?php echo $nama_kucing ?>">
             <input type="hidden" name="jenis_kucing" value="<?php echo $jenis_kucing ?>">
             <input type="hidden" name="umur_kucing" value="<?php echo $umur_kucing ?>">
             <input type="hidden" name="id_jenis_kucing" value="<?php echo $id_jenis_kucing ?>">
             <tr>
              <td><?php echo $nama_kucing ?></td> <td><?php echo $jenis_kucing ?></td> <td><?php echo $umur_kucing ?></td> <td><input type="submit" name="edit" value="Edit" style="border: 1px solid #ddd"></td>
             </tr>
          </form>
           <?php
         }
         $stmt->close();
          ?>
       </table>

       <?php
         if (isset($_POST["edit"])) {
           $id = $_POST["id"];
           $nama_kucing_e = $_POST["nama_kucing"];
           $jenis_kucing_e = $_POST["jenis_kucing"];
           $umur_kucing_e = $_POST["umur_kucing"];
           $id_jenis_kucing_e = $_POST["id_jenis_kucing"];
           ?>
          <br><br><hr><br><br>
          <form class="" action="" method="post">
            <input type="hidden" name="id_kucing" value="<?php echo $id ?>">
            <table>
              <tr>
                <td> <input type="text" name="nama_kucing" value="<?php echo $nama_kucing_e ?>"> </td>
                <td> <input type="text" name="jenis_kucing" value="<?php echo $jenis_kucing_e ?>"> </td>
                <td>
                  <select class="" name="umur_kucing">
                    <option value="Kitten">Kitten</option>
                    <option value="Young">Young</option>
                    <option value="Adult">Adult</option>
                    <option value="Senior">Senior</option>
                  </select>
                </td>
                <td><input type="submit" name="update" value="update"></td>
              </tr>
            </table>
          </form>

           <?php
         }
        ?>
   </body>
 </html>
