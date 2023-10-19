<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-18">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-left">Cek Rekapitulasi Pengajuan Barang</h3>
                </div>
                <form method="POST"  class="form-inline">
                    <div class="box-body">

                        <div class="form-group">
                            <label>  Dari  Tanggal   </label>
                            <input value="<?php echo date('Y-m-d',strtotime('-1 month'));?>" type="date" id="tanggala" class="form-control" name="tanggala" required>
                        </div>&emsp;
                        <div class="form-group">
                            <label>  Sampai Tanggal   </label>
                            <input value="<?php echo date('Y-m-d');?>" type="date" id="tanggalb" class="form-control" name="tanggalb" required>
                        </div>
                        &emsp;
<!--                        <div class="form-group">-->
<!--                            <label>  Nama </label>&emsp;&emsp;-->
<!--                            <input type="text" id="unit" class="form-control" name="unit" value='--><?//=  $_SESSION['username']; ?><!--' required>-->
<!--                        </div>-->

                        <div class="form-group">&emsp;
                            <input type='submit' name="tampilkan" value="View" class='btn btn-success'>
                        </div>
                    </div>
                </form>


            </div>
        </div>
        <?php
        include "../fungsi/koneksi.php";
        include "../fungsi/fungsi.php";

        if(isset($_POST["tampilkan"])){
        $tanggala = $_POST["tanggala"];
        $tanggalb = $_POST["tanggalb"];


        $_SESSION['tanggala']  = $tanggala;
        $_SESSION['tanggalb']  = $tanggalb;
        ?>

        <div class="col-sm- col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="form-group">
                        <!-- Untuk Cetak -->

                        <div class="col-md-12">
                            <form method="POST" action='cetak_laprekapitulasipengajuan.php' target="_blank" class="form-inline">
                                <div class="form-group">
                                    <label> Perioode</label>
                                    <input type="text"  value='<?= ($tanggala); ?>' id="tanggala" class="form-control" name="tanggala" required>
                                </div>
                                <div class="form-group">
                                    <label>  s/d</label>
                                    <input type="text"  value='<?= ($tanggalb); ?>' id="tanggalb" class="form-control" name="tanggalb" required>
                                </div>&emsp;
<!--                                <div class="form-group">-->
<!--                                    <label>  Nama </label>-->
<!--                                    <input type="text"  value='--><?//= ($unit); ?><!--' id="unit" class="form-control" name="unit" required>-->
<!--                                </div>-->
                                <div class="form-group">

                                    <input type='submit' name="POST" value="Cetak PDF" class='btn btn-success'>


                                </div>
                            </form>

                            <form method="POST" action='rekapitulasi_lap_pengajuan_excel.php' target="_blank"  class="form-inline">
                                <div class="box-body">

                                    <div class="hidden form-group">
                                        <label>  Dari  Tanggal   </label>
                                        <input value="<?php echo $tanggala;?>" type="date" id="tanggala" class="form-control" name="tanggala" required>
                                    </div>&emsp;
                                    <div class="hidden form-group">
                                        <label>  Sampai Tanggal   </label>
                                        <input value="<?php echo $tanggalb;?>" type="date" id="tanggalb" class="form-control" name="tanggalb" required>
                                    </div>
                                    &emsp;
<!--                                    <div class="hidden form-group">-->
<!--                                        <label>  Nama </label>&emsp;&emsp;-->
<!--                                        <input type="text" id="unit" class="form-control" name="unit" value='--><?//=  $_SESSION['username']; ?><!--' required>-->
<!--                                    </div>-->

<!--                                    <div class="form-group">&emsp;-->
<!--                                        <input type='submit' name="POST" value="Download Excel" class='btn btn-primary'-->
<!--                                               style="position: absolute; right: 300px; top: 0px">-->
<!--                                    </div>-->
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Untuk Cetak -->
                </div>
                <table class="table table-responsive" id="lap_rekapitulasi_pengajuan_operator">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga Barang</th>
                        <th>Total</th>
                    </tr>
                    <tbody>

                    <?php


                    $query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, 
pengajuan.jumlah,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, 
tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE tgl_pengajuan BETWEEN '$tanggala' and '$tanggalb' ");


                    $no = 1;


                    echo " ";
                    if (mysqli_num_rows($query)) {
                        while($data=mysqli_fetch_assoc($query)):
                            ?>

                            <tr>
                                <td><?php echo $no;?></td>
                                <td> <?php echo date('d/m/Y', strtotime($data['tgl_pengajuan']));  ?></td>
                                <td><?php echo $data['kode_brg'];?></td>
                                <td><?php echo $data['nama_brg'];?></td>
                                <td><?php echo $data['satuan'];?></td>
                                <td><?php echo $data['jumlah'];?></td>
                                <td><?php echo number_format($data['hargabarang']); ?></td>
                                <td><?php echo number_format($data['total']); ?></td>
                            </tr>

                            <?php $no++;  ?>

                        <?php  endwhile; } else {




                        echo "<script>window.alert('DATA BARANG TIDAK ADA')
                window.location='index.php?p=detil_lap_pengajuan'</script>";;}

                    } ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</section>

<script>

    $(function () {
        $("#lap_rekapitulasi_pengajuan_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>