<?php
$tgl_satu_bulan_lalu = date('Y-m-d',strtotime('-1 month'));
?>
<section class="content">
  <div class="row">
    <div class="col-sm-12 col-xs-18">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="text-center">Detil Laporan Permintaan Barang</h3>
        </div>
        <form method="POST"  class="form-inline">
          <div class="box-body">

            <div class="form-group">
              <label>  Dari Tanggal   </label>
              <input value="<?php echo date('Y-m-d',strtotime('-1 month'));?>" type="date" id="tanggala" class="form-control" name="tanggala" required>
            </div>&emsp;
            <div class="form-group">
              <label>  Sampai Tanggal   </label>
              <input value="<?php echo date('Y-m-d');?>" type="date" id="tanggalb" class="form-control" name="tanggalb" required>
            </div>
            <!--cuys-->
              <div class="form-group">
                  <div class="col-sm-3">
                      <select name="kode_barang" class="form-control" id="">
                          <!--// disini pakai metode filter berdasarkan jenis barang , filter by jenis barang SUKSES-->
                          <option value="" class="text-center">--Jenis Barang--</option>
                          <?php
                          $query_get_brg = mysqli_query($koneksi,"select id_kode_brg,kode_brg,nama_brg from stokbarang");

                          while ($item = mysqli_fetch_array($query_get_brg)) { ?>

                              <option <?php if ($_SESSION['sesi_kode_barang_lengkap']==$item['kode_brg']) { ?>
                                  selected
                              <?php } ?> value="<?php echo $item['kode_brg']?>" class="text-center">
                                  <?php echo $item['nama_brg'];?>
                              </option>
                          <?php }
                          ?>
                      </select>
                  </div>
              </div>
            <!--untuk enter-->
            <div style="margin-top: 20px">

            </div>
            &emsp;
            <div class="form-group">
              <label>  Namaa </label>&emsp;&emsp;
              <input type="text" id="unit" class="form-control" name="unit" required>
            </div>

            <div class="form-group">&emsp;
              <input type='submit' name="tampilkan" value="Viewz" class='btn btn-success'>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php
    include "../fungsi/koneksi.php";
    include "../fungsi/fungsi.php";

    $kode_barang = "";

    $_SESSION['sesi_jenis_barang']="";
    $_SESSION['sesi_kode_barang']="";
    $_SESSION['sesi_kode_barang_lengkap']="";

    //COPY DISINI
    if(isset($_POST["tampilkan"])){
      $tanggala = $_POST["tanggala"];
      $tanggalb = $_POST["tanggalb"];
      $kode_barang = $_POST["kode_barang"]??"";
      $unit = $_POST["unit"];

        $_SESSION['tanggala']  = $tanggala;
        $_SESSION['tanggalb']  = $tanggalb;

        $kode_barang = $_POST['kode_barang']??"";
        $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang']??"";

//      echo $tanggala."::";
//      echo $tanggalb."::";
      // LANJUTKAN DISINI CUY
//      echo "kode brg cuy::".$kode_barang."::";
      ?>

      <div class="col-sm- col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <div class="form-group">

              <!-- Untuk Cetak -->

                <?php

                $query_get_id_user = mysqli_query($koneksi,"select * from user where username='$unit'");
                while($item = mysqli_fetch_array($query_get_id_user)){
                    $id_user = $item['id_user'];
                }
//                echo $id_user;
                ?>
              <div class="col-md-12">
                <form method="POST" action='cetak_lap_detilpermintaan.php' target="_blank" class="form-inline">
                  <div class="form-group">
                    <label> Periode</label>
                    <input readonly type="text"  value="<?php echo $id_user; ?>"
                           id="user_id" class="hide form-control"
                           name="user_id" >
                    <input readonly type="text"  value='<?= ($tanggala); ?>'
                           id="tanggala" class="form-control"
                           name="tanggala" required>
                  </div>
                  <div class="form-group">
                    <label> s/d </label>
                    <input readonly type="text"  value='<?= ($tanggalb); ?>'
                           id="tanggalb" class="form-control"
                           name="tanggalb" required>
                  </div>&emsp;
                  <div class="form-group">
                    <label>  Nama Pengguna </label>
                    <input readonly type="text"  value='<?= ($unit); ?>'
                           id="unit" class="form-control"
                           name="unit" required>
                  </div>

                    <!--lampiran post-->
                    <?php if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                        if($_SESSION['sesi_kode_barang_lengkap']!=""){
                            ?>
                            <div class="form-group hidden">
                                <label>  Kode Barang </label>
                                <input readonly type="text"  value='<?= $_SESSION['sesi_kode_barang_lengkap']; ?>'
                                       id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                            </div>
                            <?php
                        } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                            ?>
                            <div class="form-group hidden">
                                <label>  Kode Barang </label>
                                <input readonly type="text"  value=''
                                       id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                            </div>
                            <?php
                        }
                    } else if (!isset($_SESSION['sesi_kode_barang_lengkap'])){ ?>
                        <div class="form-group hidden">
                            <label>  Kode Barang </label>
                            <input readonly type="text"  value=''
                                   id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                        </div>
                        <?php

                    }?>

                  <div class="form-group">

                    <input type='submit' name="POST" value="Cetak PDF" class='btn btn-success'>
                    

                  </div>
                </form>

                  <form method="POST" action='lap_detilpermintaan_excel.php' target="_blank" class="form-inline">
                      <div class="hidden form-group">
                          <label> Periode</label>
                          <input readonly type="text"  value="<?php echo $id_user; ?>"
                                 id="user_id" class="hide form-control"
                                 name="user_id" >
                          <input readonly type="text"  value='<?= ($tanggala); ?>'
                                 id="tanggala" class="form-control"
                                 name="tanggala" required>
                      </div>
                      <div class="hidden form-group">
                          <label> s/d </label>
                          <input readonly type="text"  value='<?= ($tanggalb); ?>'
                                 id="tanggalb" class="form-control"
                                 name="tanggalb" required>
                      </div>&emsp;
                      <div class="hidden form-group">
                          <label>  Nama Pengguna </label>
                          <input readonly type="text"  value='<?= ($unit); ?>'
                                 id="unit" class="form-control"
                                 name="unit" required>
                      </div>

                      <!--lampiran post-->
                      <?php if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                          if($_SESSION['sesi_kode_barang_lengkap']!=""){
                              ?>
                              <div class="form-group hidden">
                                  <label>  Kode Barang </label>
                                  <input readonly type="text"  value='<?= $_SESSION['sesi_kode_barang_lengkap']; ?>'
                                         id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                              </div>
                              <?php
                          } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                              ?>
                              <div class="form-group hidden">
                                  <label>  Kode Barang </label>
                                  <input readonly type="text"  value=''
                                         id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                              </div>
                              <?php
                          }
                      } else if (!isset($_SESSION['sesi_kode_barang_lengkap'])){ ?>
                          <div class="form-group hidden">
                              <label>  Kode Barang </label>
                              <input readonly type="text"  value=''
                                     id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                          </div>
                          <?php

                      }?>

<!--                      <div  class="form-group">-->
<!---->
<!--<!--                          <input type='submit' name="POST" value="Cetak" class='btn btn-success'>-->-->
<!---->
<!--                          <input  type='submit' name="POST" value="Download Excel" class='btn btn-primary'-->
<!--                                 style="position: absolute; right: 10px; top: 0px">-->
<!---->
<!---->
<!--                      </div>-->
                  </form>
              </div>
            </div>

            <!-- Untuk Cetak -->
          </div>

          <table class="table table-responsive" id="detil_lap_permintaan_operator">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Tanggal Permintaan</th>
                  <th>Nama</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
              </tr>
              </thead>

            <tbody>   

              <?php


              $query_bk = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, 
jumlah, satuan, tgl_keluar FROM pengeluaran 
INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg 
WHERE unit='$unit' AND tgl_keluar BETWEEN '$tanggala' and '$tanggalb' ");

              if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                  if($_SESSION['sesi_kode_barang_lengkap']!=""){
                      //cetak berdasarkan jenis barang BERHASIL SUKSES I
//                      echo "sesi kode barang terset dan ada isi:".$_SESSION['sesi_kode_barang_lengkap'];
                      $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and permintaan.unit='$unit'");
                  } else if($_SESSION['sesi_kode_barang_lengkap']==""){
//                      echo "sesi kode barang terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
                      $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.unit='$unit'");
                  }
              } else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
//                  echo "sesi kode barang tidak terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
                  $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.unit='$unit'");
              }

              $query_old_v1 = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and permintaan.unit='$unit'");

              $no = 1;    


              echo " ";
              if (mysqli_num_rows($query))      {
                while($data=mysqli_fetch_assoc($query)):

                  ?>

                  <tr>

                   <td><?php echo $no;?></td>
                   <td hidden ><?php echo "kode barang:".$kode_barang;?></td>
<!--                   <td> --><?php //echo date('d/m/Y', strtotime($data['tgl_keluar']));  ?><!--</td>-->
                   <td> <?php echo tanggal_indo($data['tgl_keluar']);  ?></td>
                   <td><?php echo $data['unit'];?></td>
<!--                   <td>--><?php //echo $data['user_id'];?><!--</td>-->
                   <td><?php echo $data['kode_brg'];?></td>
                   <td><?php echo $data['nama_brg'];?></td>
                   <td><?php echo $data['satuan'];?></td>
                   <td><?php echo $data['jumlah'];?></td>
                 </tr>
                 
                 <?php $no++;  ?>

               <?php  endwhile; } else { 




                echo "<script>window.alert('DATA BARANG TIDAK ADA')
                window.location='index.php?p=detil_lap_permintaan'</script>
                ";}



              } ?>
            </tbody>  
          </table>    
        </div>
      </div>
    </div>
  </section>

<script>

    $(function () {
        $("#detil_lap_permintaan_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
