

<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));

//metode array_push dan is_array pada proses cetak bpp
$_SESSION["sesi_jenis_barang"] = "";
$_SESSION["sesi_kode_barang"] = "";
$_SESSION["sesi_kode_barang_lengkap"] = "";

if(isset($_POST['tampilkan'])){


    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    $kode_barang = $_POST['kode_barang'];
    $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang'];

    //disini sudah dibuatkan pilihan pilih status
    //tinggal diatifkan komenan dibawah
//    $jenis_status_acc = $_POST['jenis_status_acc'];

//    echo $jenis_status_acc;


    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

    //echo $tanggala . "::";
    //echo $tanggalb . "::";
    //echo "kode brg::".$kode_barang."::";


    if(isset($_SESSION['sesi_kode_barang_lengkap'])){
        if($_SESSION['sesi_kode_barang_lengkap']!=""){
           // echo "sesi_kode_barang_lengkap sudah terset dan ADA ISI";
            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' group by sementara.tgl_permintaan DESC, sementara.bendahara");

        } else if($_SESSION['sesi_kode_barang_lengkap']=="") {
           // echo "sesi_kode_barang_lengkap sudah terset dan TIDAK ADA ISI";

            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' group by sementara.tgl_permintaan DESC, sementara.bendahara");
        }
    }

    $query_old_v1 = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' group by sementara.tgl_permintaan DESC, sementara.bendahara");



} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){

        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and permintaan.`status`='1' group by sementara.tgl_permintaan DESC, sementara.bendahara");


    } else {


        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and permintaan.`status`='1' group by sementara.tgl_permintaan DESC, sementara.bendahara");


    }
}

?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php $nama_subbidang = ""; ?>
                    <?php
                    $getSubBidang = mysqli_query($koneksi,"select * from subbidang where 
                        id_subbidang='$_SESSION[subbidang_id]'");

                    while($dt = mysqli_fetch_array($getSubBidang)){
                        $nama_subbidang = $dt['nama_subbidang'];
                    }
                    ?>

                    <h3 class="text-center">Cetak BPP<br>
                        <span style="font-weight: bold"><?php echo $nama_subbidang;?></span>
                    </h3>
                </div>

                <center>
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggala'])){ echo $_SESSION['tanggala']; } else { echo $tgl_satu_bulan_lalu; } ?>"
                                       type="date"  id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggalb'])){ echo $_SESSION['tanggalb']; } else { echo $sekarang; } ?>"
                                       type="date" id="tanggalb"
                                       class="form-control" name="tanggalb" required>
                            </div>

                            <br>

                            <!--UNTUK ENTER-->
                            <div style="margin-top: 20px">
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <select name="kode_barang" class="form-control">
                                        <option value="" class="text-center">--Jenis Barang--</option>
                                        <!--contoh selected barang agar tetap terselect ketika sudah disubmit-->
                                        <?php
                                        $query_get_brg = mysqli_query($koneksi,"select id_kode_brg,kode_brg,nama_brg from stokbarang");
                                        while($item = mysqli_fetch_array($query_get_brg)){

                                            ?>
                                            <option <?php
                                            if($_SESSION["sesi_kode_barang_lengkap"]==$item['kode_brg']) { ?>
                                                selected
                                            <?php }
                                            ?> value="<?php echo $item['kode_brg']?>"
                                               class="text-center">
                                                <?php echo $item['nama_brg'] ;?>
                                            </option>
                                            <?php
                                        }
                                        ?>


                                    </select>
                                </div>
                            </div>

                            <div style="margin-top: 20px">
                            </div>

                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>



                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="cetak_bpp_baru" class="table text-center">
                            <thead style="background-color: #a1d5ff">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Pengelola</th>
                                <th>Tgl Permintaan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            if(mysqli_num_rows($query)){
                                while($dt = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <?php
                                            $get_nama_pemohon = mysqli_query($koneksi, "select nama_lengkap from `user` where id_user='$dt[user_id]'");
                                            echo mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap'];

                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $get_nama_bendahara = mysqli_query($koneksi, "select nama_lengkap from `user` where id_user='$dt[bendahara_id]'");
                                            echo mysqli_fetch_assoc($get_nama_bendahara)['nama_lengkap'];

                                            ?>
                                        </td>
                                        <td><?php echo tanggal_indo($dt['tgl_permintaan']);?></td>
                                        <td>
                                            <?php
                                                if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                    if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                                        ?>
                                                        <a target="_blank"
                                                           href="cetakpesanan.php?&tgl=<?= $dt['tgl_permintaan']; ?>&unit=<?= $dt['unit']; ?>&instansi=<?= $dt['instansi']; ?>&bendahara=<?= $dt['bendahara']; ?>&bendahara_id=<?= $dt['bendahara_id']; ?>&kode_brg_lengkap=<?php echo $_SESSION['sesi_kode_barang_lengkap']?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Cetak BPP'>
                                                                <button class="btn btn-success" style="background-color: #10d4cb">
                                                                    <i class="fa fa-print" style=""> Cetak BPP </i>
                                                                </button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    } else if($_SESSION['sesi_kode_barang_lengkap']==""){ ?>
                                                        <a target="_blank"
                                                           href="cetakpesanan.php?&tgl=<?= $dt['tgl_permintaan']; ?>&unit=<?= $dt['unit']; ?>&instansi=<?= $dt['instansi']; ?>&bendahara=<?= $dt['bendahara']; ?>&bendahara_id=<?= $dt['bendahara_id']; ?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Cetak BPP'>
                                                                <button class="btn btn-success" style="background-color: #10d4cb">
                                                                    <i class="fa fa-print" style=""> Cetak BPP </i>
                                                                </button>
                                                            </span>
                                                        </a>
                                                        <?php

                                                    }
                                                }
                                            ?>
<!--                                            <a target="_blank"-->
<!--                                               href="cetakpesanan.php?&tgl=--><?//= $dt['tgl_permintaan']; ?><!--&unit=--><?//= $dt['unit']; ?><!--&instansi=--><?//= $dt['instansi']; ?><!--&bendahara=--><?//= $dt['bendahara']; ?><!--&bendahara_id=--><?//= $dt['bendahara_id']; ?><!--">-->
<!--                                                <span data-placement='top' data-toggle='tooltip' title='Cetak BPP'>-->
<!--                                                    <button class="btn btn-success" style="background-color: #10d4cb">-->
<!--                                                        <i class="fa fa-print" style=""> CCetaak BPP </i>-->
<!--                                                    </button>-->
<!--                                                </span>-->
<!--                                            </a>-->
                                        </td>
                                    </tr>
                                    <?php $no++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    $(function () {
        $("#cetak_bpp_baru").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
