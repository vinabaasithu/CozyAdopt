<?php
  if (file_exists('db.php')) {
    include 'db.php';
  } else if(file_exists('source/etc/db.php')) {
    include 'source/etc/db.php';
  }
 ?>
<?php  ?>
<div class="form-group">
  <label for="tempat-kucing">Tempat Tinggal Kucing :</label>
  <p class=""> <em> <strong> <small>Harap Pilih Lokasi Anda</small> </strong> </em> </p>
  <div class="container-select-input">
    <div class="text-filter text-filter-prov form-control teks">
      <!--  -->
    </div>
    <div class="grid" val="prov">
      <input type="text" id="prov-text-id" class="form-control teks" val="prov" placeholder="Provinsi" name="" value="" required>
      <div class="chevron">
        <i class="fas fa-chevron-down"></i>
      </div>
      <input id="hidden_id_prov" type="hidden" name="id_prov" value="">
    </div>

    <div class="isi-select-input prov-isi">
      <ul>
        <?php
          $stmt = $mysqli->prepare("SELECT id_prov, nama FROM provinsi_daerah ORDER BY nama");
          $stmt->execute();
          $stmt->bind_result($id_prov, $nama_prov);
          while ($stmt->fetch()) {
            echo "<li val='$id_prov' da='prov'>$nama_prov</li>";
          }
          $stmt->close();
         ?>
      </ul>
    </div>
  </div>
  <div class="container-select-input">
    <div class="text-filter text-filter-kab form-control teks">
      <!--  -->
    </div>
    <div class="grid" val="kab">
      <input type="text" id="kab-text-id" class="form-control teks" val="kab" placeholder="Kabupaten" name="" value="" required>
      <div class="chevron">
        <i class="fas fa-chevron-down"></i>
      </div>
      <input id="hidden_id_kab" type="hidden" name="id_kab" value="">
    </div>

    <div class="isi-select-input kab-isi">
      <ul>
        <!-- isi li -->
      </ul>
    </div>
  </div>
  <div class="container-select-input">
    <div class="text-filter text-filter-kec form-control teks">
      <!--  -->
    </div>
    <div class="grid"  val="kec">
      <input type="text" id="kec-text-id" class="form-control teks" val="kec" placeholder="Kecamatan" name="" value="" required>
      <div class="chevron">
        <i class="fas fa-chevron-down"></i>
      </div>
      <input id="hidden_id_kec" type="hidden" name="id_kec" value="">
    </div>

    <div class="isi-select-input kec-isi">
      <ul>
        <!-- isi li -->
      </ul>
    </div>
  </div>
  <div class="container-select-input">
    <div class="text-filter text-filter-kel form-control teks">
      <!--  -->
    </div>
    <div class="grid"  val="kel">
      <input type="text" id="kel-text-id" class="form-control teks" val="kel" placeholder="Kelurahan" name="" value="" required>
      <div class="chevron">
        <i class="fas fa-chevron-down"></i>
      </div>
      <input id="hidden_id_kel" type="hidden" name="id_kel" value="">
    </div>

    <div class="isi-select-input kel-isi">
      <ul>
        <!-- isi li -->
      </ul>
    </div>
  </div>

  <div class="form-group margin-none">
    <p> <em> <strong> <small><label for="alamat_lengkap" class="em1">Isi Alamat Lengkap :</label></small> </strong> </em> </p>
    <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" rows="8" cols="80" placeholder="Isi dengan nama jalan atau nomor rumah Anda" required></textarea>
  </div>
  <p class="isi-d-alamat-a">
    <input id="isiAlamatAuto" type="checkbox" class="isiAlamatAuto" isc="unchecked">
    <label for="isiAlamatAuto">
      <em> <strong> <small>Atau Isi Alamat Dengan Alamat Anda</small> </strong> </em>
    </label>
  </p>


</div>
