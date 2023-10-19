<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
//index.php?p=history_permintaan_barang_table&pa=history_pengguna
if (isset($_GET['p']) && isset($_GET['pa'])) {
//    echo "sudah terset p dan pa nya";
    $query_bk_old = mysqli_query($koneksi, "select * from sementara 
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$tgl_satu_bulan_lalu' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    $query_bk_old_2 = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on sementara.kode_brg=stokbarang.kode_brg)
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
 and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
group by tgl_permintaan desc");

}

//disini menggunakan konsep filter rekap barang berdasarkan jenis barang
$_SESSION["sesi_jenis_barang"] = "";
$_SESSION["sesi_kode_barang"] = "";
$_SESSION["sesi_kode_barang_lengkap"] = "";
//dari sini
if(isset($_POST['tampilkan'])){
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    $kode_barang = $_POST['kode_barang'];
//    $_SESSION["sesi_kode_barang"] = $_POST['kode_barang'];
    $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang'];
//    $jenis_brg = $_POST['jenis_brg'];
//    $nama_brg = $_POST['nama_brg'];

//    echo "tanggal sudah terset dan pencet tampilkan::";
    //echo $tanggala."::";
    //echo $tanggalb."::";
    //echo "kode brg::".$kode_barang."::";
//    echo $jenis_brg."::";
//    echo $nama_brg."::";

    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

    if(isset($_SESSION['sesi_kode_barang_lengkap'])){
        if($_SESSION['sesi_kode_barang_lengkap']!=""){
            //echo "sesi kode barang terset dan ada isi:".$_SESSION['sesi_kode_barang_lengkap'];
//            $query
            $query = mysqli_query($koneksi, "select * from sementara
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
and kode_brg='$_SESSION[sesi_kode_barang_lengkap]' group by tgl_permintaan desc");
        } else if($_SESSION['sesi_kode_barang_lengkap']=="") {
            //echo "sesi kode barang terset dan tidak ada isis:".$_SESSION['sesi_kode_barang_lengkap'];
            $query = mysqli_query($koneksi, "select * from sementara
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') group by tgl_permintaan desc");
        }
    }

    $query_v1_old = mysqli_query($koneksi, "select * from sementara
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
group by tgl_permintaan desc");
//    $_SESSION['jenis_brg'] = $jenis_brg;
//    $_SESSION['nama_brg'] = $nama_brg;

    //darisini
//    if($jenis_brg=='pilih_jenis_barang' && $nama_brg=='pilih_nama_barang'){
//        echo "<script>window.alert('Anda Belum Memilih Barang')
//		window.location='index.php?p=history_permintaan_barang_table&pa=history_pengguna'</script>";
//    } else if($jenis_brg=='semua_jenis_brg' && $nama_brg=='semua_nama_brg') {
//        $query = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on
//sementara.kode_brg=stokbarang.kode_brg)
//where tgl_permintaan between '$_POST[tanggala]' and '$_POST[tanggalb]' and unit='$_SESSION[username]'
//and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
//and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
//group by tgl_permintaan desc");
//    } else  {
//            $query = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on
//sementara.kode_brg=stokbarang.kode_brg)
//where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]'
//and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
//and sementara.id_jenis='$_POST[jenis_brg]' and sementara.kode_brg='$_POST[nama_brg]'
//and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
//group by tgl_permintaan desc");
//    }
    //sampaisini

} else {
    if (isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])) {
       // echo "tanggal sudah terset<br>";

        if(isset($_SESSION['sesi_kode_barang'])){
            if($_SESSION['sesi_kode_barang']!=""){
                //echo "sesi kode brg sudah terset sebelum nya dan ada isi";
            } else if($_SESSION['sesi_kode_barang']==""){
                //echo "sesi kode brg sudah terset sebelum nya dan tidak ada isi";
            }
        }

        $query = mysqli_query($koneksi, "select * from sementara
where tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
group by tgl_permintaan desc");

//        $query_bk_2 = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on
//sementara.kode_brg=stokbarang.kode_brg)
//where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]'
//and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
// and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
//group by tgl_permintaan desc");
    } else {

        $query = mysqli_query($koneksi, "select * from sementara
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
group by tgl_permintaan desc");

//        $query_bk_3 = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on
//sementara.kode_brg=stokbarang.kode_brg)
//where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]'
//and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
// and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
//group by tgl_permintaan desc");
    }
}
//sampai sini



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
                    $getSubBidang = mysqli_query($koneksi, "select * from subbidang where 
                        id_subbidang='$_SESSION[subbidang_id]'");

                    while ($dt = mysqli_fetch_array($getSubBidang)) {
                        $nama_subbidang = $dt['nama_subbidang'];
                    }
                    ?>
                    <h3 class="text-center">History Permintaan Barang Sub Bidaang <br>
                        <span style="font-weight: bold"><?php echo $nama_subbidang; ?></span>
                    </h3>
                </div>

                <center>
                    <!--metode filter dengan kode dan nama brg-->
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
<!--                    <form method="post" action="add-proses_table_lihat_data.php" class="form-inline">-->
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

                            <br>

                            <!--UNTUK ENTER-->
                            <div style="margin-top: 20px"></div>



                            <div class="hidden form-group">
                                <label for="jenis_brg" class=" col-sm-3 control-label">Jenis Barang</label>
                                <div style="" class="col-sm-6">
                                    <select id="jenis_brg" name="jenis_brg" required="isikan dulu" class="form-control" >
                                        <option value="pilih_jenis_barang">--Pilih Jenis Barang--</option>
                                        <option value="semua_jenis_brg">Semua Jenis Barang</option>
                                        <?php
                                        include "../fungsi/koneksi.php";
                                        $queryJenis = mysqli_query($koneksi, "select * from jenis_barang");
                                        if (mysqli_num_rows($queryJenis)) {
                                            while ($row = mysqli_fetch_assoc($queryJenis)):
                                                ?>
                                                <option value="<?= $row['id_jenis']; ?>"><?= $row['jenis_brg']; ?></option>
                                            <?php endwhile;
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="hidden form-group">
                                <!--di getData.php telah ditentukan value dan nama barang yg ditampilkan-->
                                <label for="nama_brg" class="col-sm-3 control-label">Nama Barang</label>
                                <div class="col-sm-6">
                                    <select id="nama_brg" name="nama_brg" required="isikan dulu" class="form-control" >
                                        <option value="pilih_nama_barang">--Pilih Nama Barang--</option>
                                        <option value="semua_nama_brg">Pilih Nama Barang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
<!--                                <label id="tes"for="level" class="col-sm-offset-1 col-sm-3 control-label">-->
<!--                                    Jenis Barang-->
<!--                                </label>-->
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
                                <input type="submit"
                                       id="tampilkan"
                                       name="tampilkan"
                                       value="Lihaat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>

                <div class="box-body">
                    <!--penggunaan Datatables utk fitur pencarian-->
                    <div class="table-responsive">
                        <table id="permintaan_barang" class="table text-center">
                            <!--standard warna table header-->
                            <thead style="background-color: #a1d5ff">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>User ID</th>
                                <th>Tgl Permintaan</th>
<!--                                <th>Nama Barang</th>-->
<!--                                <th>Status</th>-->
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= $row['unit']; ?> </td>
                                        <td> <?= $row['user_id']; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
<!--                                        <td> --><?//= $row['nama_brg']; ?><!-- </td>-->
<!--                                        <td> --><?//= $row['instansi']; ?><!-- </td>-->
                                        <!--metode gabungan ucwords dan str_replace-->
<!--                                        <td> --><?php //echo ucwords(str_replace("_"," ",$row['status_acc'])) ; ?><!-- </td>-->

                                        <td style="background-color: ">
                                            <?php if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                                    ?>
                                                    <a href="?p=detil_history_permintaan_barang_table&unit=<?php echo $row['unit'] ?>&user_id=<?php echo $row['user_id'] ?>&tgl_permintaan=<?php echo $row['tgl_permintaan'] ?>&kode_brg_lengkap=<?php echo $_SESSION['sesi_kode_barang_lengkap']?>">
                                                        <span data-placement="top"
                                                              data-toggle="tooltip"
                                                              title="Detail Permintaan">
                                                            <button name="bt_detail_history_kasubpengguna"
                                                                    class="btn btn-info">
                                                        Detail Permintaann
                                                            </button>
                                                        </span>
                                                    </a>
                                                    <?php
                                                } else if($_SESSION['sesi_kode_barang_lengkap']=="") {
                                                    $kode_brg_lengkap = "";
                                                    ?>

                                                    <a href="?p=detil_history_permintaan_barang_table&unit=<?php echo $row['unit'] ?>&user_id=<?php echo $row['user_id'] ?>&tgl_permintaan=<?php echo $row['tgl_permintaan'] ?>&kode_brg_lengkap=<?php echo $kode_brg_lengkap?>">
                                                        <span data-placement="top"
                                                      data-toggle="tooltip"
                                                      title="Detail Permintaan">
                                                            <button name="bt_detail_history_kasubpengguna"
                                                            class="btn btn-info">
                                                        Detail Permintaannz
                                                            </button>
                                                        </span>
                                                    </a>

                                                    <?php
                                                }

                                            } ?>


                                        </td>
                                    </tr>
                                    <?php $no++;
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--bagian bawah-->

</section>


<script>

    $(function () {
        $("#permintaan_barang").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });

</script>

<script>
    $(document).ready(function(){
        $("#jenis_brg").change(function(){
            var jenis = $("#jenis_brg").val();
            var dataString = 'jenis=' + jenis;
            $.ajax({
                type: "POST",
                url: "getdata_by_jenis_brg.php",
                data: dataString,
                success: function(html){
                    $("#nama_brg").html(html);
                },
            });
        });
    });
</script>