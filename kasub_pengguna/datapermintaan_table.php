<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$subbidang_id = $_SESSION['subbidang_id'];

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
//echo $sekarang.'s';

//echo " subbidang_id = ".$subbidang_id;

//$query_old = mysqli_query($koneksi, "SELECT distinct(unit),
//instansi, tgl_permintaan FROM permintaan WHERE status=0");


$query_old = mysqli_query($koneksi, "Select * from sementara where status_acc='Pengajuan Kasub' 
and id_subbidang='$_SESSION[subbidang_id]' group by tgl_permintaan");

$_SESSION['sesi_jenis_barang']="";
$_SESSION['sesi_kode_barang']="";
$_SESSION['sesi_kode_barang_lengkap']="";
//NYONTOH DISINI CUY
if (isset($_POST["tampilkan"])) {
    $tanggala = $_POST["tanggala"];
    $tanggalb = $_POST["tanggalb"];

    $_SESSION['tanggala']  = $tanggala;
    $_SESSION['tanggalb']  = $tanggalb;
//    echo $tanggala."-".$tanggalb;

    $kode_barang = $_POST['kode_barang'];
    $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang'];

    //echo $tanggala."::";
    //echo $tanggalb."::";
    //echo "kode brg::".$kode_barang."::";

    //jika sesi_kode_barang_lengkap telah terset
    if(isset($_SESSION['sesi_kode_barang_lengkap'])){
        if($_SESSION['sesi_kode_barang_lengkap']!=""){
            //echo "sesi kode barang terset dan ada isi:".$_SESSION['sesi_kode_barang_lengkap'];
            $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan between '$tanggala' AND '$tanggalb' 
and status_acc ='Pengajuan Kasub' and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
group by tgl_permintaan desc,user_id");
        } else if($_SESSION['sesi_kode_barang_lengkap']==""){
            //echo "sesi kode barang terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
            $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan between '$tanggala' AND '$tanggalb' 
and status_acc ='Pengajuan Kasub' 
group by tgl_permintaan desc,user_id");
        }
    } else if (!isset($_SESSION['sesi_kode_barang_lengkap'])){
        $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan between '$tanggala' AND '$tanggalb' 
and status_acc ='Pengajuan Kasub' 
group by tgl_permintaan desc,user_id");
    }

    $query_bk_1 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tanggala' AND '$tanggalb' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");

    $query_old_v1 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tanggala' AND '$tanggalb' and status_acc ='Pengajuan Kasub' group by tgl_permintaan desc,user_id");

} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){

        if(isset($_SESSION['sesi_kode_barang_lengkap'])){
            if($_SESSION['sesi_kode_barang_lengkap']!=""){
                $query = mysqli_query($koneksi,"Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan between '$tanggala' AND '$tanggalb' 
and status_acc ='Pengajuan Kasub' and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
group by tgl_permintaan desc,user_id");
            } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                //set saat TANGGALA DAN TANGGALB TIDAK DIKENALI, MAKAN PADA QUERY LANGSUNG DITARUH $_SESSION[TANGGALA]
                $query = mysqli_query($koneksi,"Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' 
and status_acc ='Pengajuan Kasub' 
group by tgl_permintaan desc,user_id");
            }
        }

        $query_bk_2 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");

        $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc ='Pengajuan Kasub' group by tgl_permintaan desc,user_id");
    } else {

        $query_bk_3 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tgl_satu_bulan_lalu' AND '$sekarang' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");

        $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tgl_satu_bulan_lalu' AND '$sekarang' and status_acc ='Pengajuan Kasub' group by tgl_permintaan desc,user_id");
    }

}
?>
<!--filter 'acc_kasub=0' yg sebelumnya ada dihilangkan-->

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php
                    $query_get_nama_sub_bidang = mysqli_query($koneksi,"select * from subbidang
where id_subbidang='$_SESSION[subbidang_id]'");

                    while ($item = mysqli_fetch_array($query_get_nama_sub_bidang)){
                        $nama_subbidang = $item['nama_subbidang'];
                    }
                    ?>
                    <h3 class="text-center">Data Permintaan Barang <strong><?php echo $nama_subbidang; ?></strong></h3>
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
                            &emsp;
                            <div style="margin-top: 20px">

                            </div>

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

                            <div style="margin-top: 20px">

                            </div>
                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                        <!--                    <div class="form-group">-->
                        <!--                        <label>  Namas </label>&emsp;&emsp;-->
                        <!--                        <input type="text" id="unit" class="form-control" name="unit" required>-->
                        <!--                    </div>-->
                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="datapermintaan_table" class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>User ID</th>
                                <th>Tgl Permintaan</th>
                                <th>Intansi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                if(mysqli_num_rows($query)){
                                    while($dt = mysqli_fetch_assoc($query)){ ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td><?php echo $dt['unit'];?></td>
                                            <td><?php echo $dt['user_id'];?></td>
                                            <td><?php echo tanggal_indo($dt['tgl_permintaan']);?></td>
                                            <td><?php echo ucwords($dt['instansi']) ;?></td>
                                            <td>
                                                <?php
                                                if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                    if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                                        ?>
                                                        <a href="?p=detilpermintaan_table&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan'];?>&kode_brg_lengkap=<?php echo $_SESSION['sesi_kode_barang_lengkap']?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button name="bt_detail_permintaan" type="submit" class="btn btn-info">
                                                                    Detail Permintaan
                                                                </button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                                                        ?>
                                                        <a href="?p=detilpermintaan_table&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan'];?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button name="bt_detail_permintaan" type="submit" class="btn btn-info">
                                                                    Detail Permintaan
                                                                </button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>

<!--                                            <td>-->
<!--                                                <a href="?p=detilpermintaan_table&unit=--><?php //echo $dt['unit']?><!--&user_id=--><?php //echo $dt['user_id']?><!--&tgl_permintaan=--><?php //echo $dt['tgl_permintaan'];?><!--">-->
<!--                                                                                <span data-placement='top'-->
<!--                                                                                      data-toggle='tooltip'-->
<!--                                                                                      title='Detail Permintaan'>-->
<!--                                                                                    <button name="bt_detail_permintaan" type="submit" class="btn btn-info">-->
<!--                                                                                        Detail Permintaan-->
<!--                                                                                    </button>-->
<!--                                                                                </span>-->
<!--                                                </a>-->
<!---->
<!--                                            </td>-->
                                        </tr>
                                    <?php }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <span style="color: black">
            <!--index.php?p=history_kasub&pa=history_kasub_pengguna-->
        NB : Setelah semua permintaan disetujui/tidak disetujui, Anda dapat melihat posisi proses pada menu
            <!--            <a style="font-weight: bold" href="?p=history_permintaan_barang&pa=history_pengguna">-->
            <!--                History-->
            <!--            </a>-->
            <a style="font-weight: bold" href="index.php?p=history_kasub_table&pa=history_kasub_pengguna">
                History
            </a>
    </span>

    </div>

</section>

<script>

    $(function () {
        $("#datapermintaan_table").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>