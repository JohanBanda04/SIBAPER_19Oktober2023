<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');
$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];
    echo $tgl;
    if ($_GET['aksi'] == 'detil') {
        header("location:?p=detil&tgl=$tgl");
    }
}

$query_group_by_tgl_bk_6 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

// disini pakai metode filter berdasarkan jenis barang , filter by jenis barang SUKSES
$_SESSION["sesi_jenis_barang"] = "";
$_SESSION["sesi_kode_barang"] = "";
$_SESSION["sesi_kode_barang_lengkap"] = "";

if (isset($_POST['tampilkan'])) {
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];

    $kode_barang = $_POST['kode_barang'];
    $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang'];

    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

//    echo "passaatpencet tampilkan lalu dilakukan set tanggala dan tanggalb";

    //echo $tanggala . "::";
    //echo $tanggalb . "::";
    //echo "kode brg::".$kode_barang."::";

    //jika sesi_kode_barang_lengkap telah terset
    if(isset($_SESSION['sesi_kode_barang_lengkap'])){
        if($_SESSION['sesi_kode_barang_lengkap']!=""){
            echo "sesi kode barang terset dan ada isi:".$_SESSION['sesi_kode_barang_lengkap'];
            $query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan,
 kode_brg from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') and kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
group by tgl_permintaan desc");
            $query_group_by_tgl_old_1 = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan,
 kode_brg from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') and kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
group by tgl_permintaan desc");
        } else if($_SESSION['sesi_kode_barang_lengkap']==""){
            //echo "sesi kode barang terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
            $query_group_by_tgl_old_2 = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan 
from sementara where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

            $query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan,
 kode_brg from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
        }
    }

    $query_group_by_tgl_bk_1 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

    $query_group_by_tgl_bk_4 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

} else {
    //ketika di refresh dan belum tekan tombol tampilkan
    if (isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])) {
//        echo "tanpapencet tampilkan tapi sudah set tanggala dan tanggalb";
//        $tanggala = $_POST['tanggala'];
//        $tanggalb = $_POST['tanggalb'];
        if(isset($_SESSION['sesi_kode_barang_lengkap'])){
            if($_SESSION['sesi_kode_barang_lengkap']!=""){
                echo "sesi kode brg sudah terset sebelum nya dan ada isi";
                $query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan,
 kode_brg from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') and kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
group by tgl_permintaan desc");
            } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                //echo "sesi kode brg sudah terset sebelum nya dan tidak ada isi";
                $query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan 
from sementara where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
            }
        }

        $query_group_by_tgl_bk_2 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

        $query_group_by_tgl = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

    } else {

        $query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan 
from sementara where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
//        echo "belumpencet tampilkan";
        $query_group_by_tgl_bk_3 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

        $query_group_by_tgl_bk_5 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    }
}

?>
<!--Isi Utama dari menu Data Permintaan Barang (Side Instansi)-->
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Barang </h3>
                </div>

                <!--metode menambah filter tanggal-->
                <center>
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggal </label>
                                <input value="<?php if (isset($_SESSION['tanggala'])) {
                                    echo $_SESSION['tanggala'];
                                } else {
                                    echo $tgl_satu_bulan_lalu;
                                } ?>"
                                       type="date" id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if (isset($_SESSION['tanggalb'])) {
                                    echo $_SESSION['tanggalb'];
                                } else {
                                    echo $sekarang;
                                } ?>"
                                       type="date" id="tanggalb"
                                       class="form-control" name="tanggalb" required>
                            </div>
                            &emsp;
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
                            <!--untuk enter saja-->
                            <div style="margin-top: 20px">
                            </div>

                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>
                <div class="box-body">
                    <a href="index.php?p=formpesan_table" style="margin:10px 15px; background-color: #486055"
                       class="btn btn-success">
                        <i class='fa fa-plus' style="color: white; font-weight: bold">
                            Form Permintaan Barang
                        </i>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-center" id="datapesanan_table">
                            <thead style="background-color: #b6eee0">
                            <tr>
                                <th style="color: black">No</th>
                                <th style="color: black">Tanggal Permintaan</th>
                                <th style="color: black">Jumlah Permintaan</th>
                                <th style="color: black">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            <tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query_group_by_tgl)) {
                                while ($row = mysqli_fetch_assoc($query_group_by_tgl)):
                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
                                        <td> <?= $row['jumlah_permintaan']; ?> </td>
                                        <td>
                                            <!--error disini, saat klik detail permintaan, tidak di redirect-->
                                            <!--                                    <a href="?p=datapesanan&aksi=detil&tgl=-->
                                            <?//= $row['tgl_permintaan'];
                                            ?><!--">-->

                                            <?php
                                                if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                    if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                                        ?>
                                                        <a href="?p=detil_table&tgl=<?= $row['tgl_permintaan']; ?>&kode_brg_lengkap=<?php echo $_SESSION['sesi_kode_barang_lengkap']?>">
                                                            <span style="font-weight: bold" data-placement='top'
                                                      data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button class="btn btn-info" style="font-weight: bold">Detail Permintaan</button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    } else if($_SESSION['sesi_kode_barang_lengkap']=="") { ?>
                                                        <!--kode_brg_lengkap OTOMATIS TIDAK TERSET-->
                                                        <a href="?p=detil_table&tgl=<?= $row['tgl_permintaan']; ?>">
                                                            <span style="font-weight: bold" data-placement='top'
                                                      data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button class="btn btn-info" style="font-weight: bold">Detail Permintaan</button>
                                                            </span>
                                                        </a>
                                                    <?php }
                                                }
                                            ?>
<!--                                            <a href="?p=detil_table&tgl=--><?//= $row['tgl_permintaan']; ?><!--">-->
<!--                                                <span style="font-weight: bold" data-placement='top'-->
<!--                                                      data-toggle='tooltip' title='Detail Permintaan'>-->
<!--                                                    <button class="btn btn-info" style="font-weight: bold">DDetail Permintaan</button>-->
<!--                                                </span>-->
<!--                                            </a>-->


                                        </td>
                                    </tr>

                                    <?php $no++;
                                endwhile;
                            } ?>

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
        $("#datapesanan_table").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>

