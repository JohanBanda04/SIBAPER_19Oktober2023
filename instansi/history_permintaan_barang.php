

<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));

if(isset($_POST['tampilkan'])){


    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    //disini sudah dibuatkan pilihan pilih status
    //tinggal diatifkan komenan dibawah
//    $jenis_status_acc = $_POST['jenis_status_acc'];

//    echo $jenis_status_acc;


    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

    $query_bk_1 = mysqli_query($koneksi,"select * from sementara 
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

    $query = mysqli_query($koneksi,"select * from sementara 
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){


        $query = mysqli_query($koneksi,"select * from sementara 
where tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    } else {


        $query = mysqli_query($koneksi,"select * from sementara 
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
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
                    <h3 class="text-center">Historyy Permintaan Barang Sub Bidang <br>
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
                            <div style="margin-top: 20px"></div>

                            <!--tinggal diaktifkan comment an dibawah-->
<!--                            <div class="form-group">-->
<!--                                <select style="width: 140px" id="jenis_status_acc" name="jenis_status_acc"-->
<!--                                        required="isikan dulu" class=" form-control" name="id_jenis">-->
<!--                                    <option value="">--Pilih Status--</option>-->
<!--                                    --><?php
//
//                                    $status_accs=array('Permintaan Baru', 'Pengajuan Kasub' ,
//                                        'setuju', 'tidak_setuju', 'Pengajuan Bendahara',
//                                        'Pengajuan Kasub Bendahara', 'Setuju Kasub Bendahara', 'Tidak Setuju Kasub Bendahara', 'Penyerahan Barang Ke Pengguna', 'Penerimaan Barang Dari Bendahara', 'Selesai');
//                                    foreach ($status_accs as $val){?>
<!--                                        <option value="--><?php //echo $val; ?><!--">--><?php //echo $val; ?><!--</option>-->
<!--                                    --><?php //}
//                                    ?>
<!--                                </select>-->
<!--                            </div>-->



                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>



                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="userss" class="table text-center">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $no =1 ;
                                if (mysqli_num_rows($query)) {
                                while($row=mysqli_fetch_assoc($query)){

                                ?>
                                <!--Cetak Tanggal Ada Disini-->
                                <td style="color: #6d0000; font-weight: bold">
                                    <?php echo tanggal_indo($row['tgl_permintaan']);?> :
                                </td>

                            </tr>
                            <tr>
                                <th>No</th>
                                <!--                                <th>Tanggal Permintaan</th>-->
                                <th>Nama</th>
                                <th>User ID</th>
                                <th>Instansi</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $nomor = 1;

                            $query_filter_by_tanggal = mysqli_query($koneksi,"select * from sementara where 
tgl_permintaan='$row[tgl_permintaan]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
and user_id='$_SESSION[user_id]' group by user_id");
                            while($dt=mysqli_fetch_array($query_filter_by_tanggal)){ ?>
                                <tr>
                                    <td><?php echo $nomor;?></td>
                                    <td><?php echo $dt['unit'];?></td>
                                    <td><?php echo $dt['user_id'];?></td>
                                    <td><?php echo $dt['instansi'];?></td>
                                    <td>

                                        <?php
                                            $query_get_barang = mysqli_query($koneksi,"select * 
from sementara where unit='$dt[unit]' and user_id='$dt[user_id]' and tgl_permintaan='$row[tgl_permintaan]'
and status_acc in('Penyerahan Barang Ke Pengguna') group by
user_id");

                                        if((mysqli_num_rows($query_get_barang))>0){ ?>
                                            <a href="?p=detil_history_permintaan_barang&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan']?>">
                                                <span data-placement="top"
                                                      data-toggle="tooltip"
                                                      title="Detail Permintaan">
                                                    <button name="bt_detail_history_kasubpengguna"
                                                            class="btn btn-warning">
                                                        Ambil Barang
                                                    </button>
                                                </span>
                                            </a>
                                        <?php } else {
                                            //penggunaan metode array_push dan in_array disini
                                            $query_cek_selesai = mysqli_query($koneksi,"select * from sementara 
where tgl_permintaan='$row[tgl_permintaan]' and user_id='$dt[user_id]' and unit='$dt[unit]'");

                                            $array_cek_selesai = array();
                                            while($data = mysqli_fetch_array($query_cek_selesai)){
                                                array_push($array_cek_selesai,$data['status_acc']);
                                            }

                                            $array_cek_selesai_done = array();
                                            foreach ($array_cek_selesai as $val){
                                                if($val=="Selesai"){
                                                    array_push($array_cek_selesai_done,"Sudah Selesai");
                                                } else if($val!="Selesai") {
                                                    array_push($array_cek_selesai_done,"Ada Yang Belum Selesai");
                                                }
                                            }

                                            if(!in_array("Ada Yang Belum Selesai",$array_cek_selesai_done)){?>
                                                <a href="?p=detil_history_permintaan_barang&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan']?>">
                                                <span data-placement="top"
                                                      data-toggle="tooltip"
                                                      title="Detail Permintaan">
                                                    <button name="bt_detail_history_kasubpengguna"
                                                            class="btn btn-danger">
                                                        Sudah Selesai
                                                    </button>
                                                </span>
                                                </a>
                                            <?php } else { ?>
                                                <a href="?p=detil_history_permintaan_barang&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan']?>">
                                                <span data-placement="top"
                                                      data-toggle="tooltip"
                                                      title="Detail Permintaan">
                                                    <button name="bt_detail_history_kasubpengguna"
                                                            class="btn btn-info">
                                                        Detail Permintaans
                                                    </button>
                                                </span>
                                                </a>
                                            <?php }
                                            ?>

<!--                                            <a href="?p=detil_history_permintaan_barang&unit=--><?php //echo $dt['unit']?><!--&user_id=--><?php //echo $dt['user_id']?><!--&tgl_permintaan=--><?php //echo $dt['tgl_permintaan']?><!--">-->
<!--                                                <span data-placement="top"-->
<!--                                                      data-toggle="tooltip"-->
<!--                                                      title="Detail Permintaan">-->
<!--                                                    <button name="bt_detail_history_kasubpengguna"-->
<!--                                                            class="btn btn-info">-->
<!--                                                        Detail Permintaans-->
<!--                                                    </button>-->
<!--                                                </span>-->
<!--                                            </a>-->
                                        <?php }
                                        ?>



                                    </td>
                                </tr>
                                <?php
                                $nomor++;
                            }
                            ?>
                            <?php $no++; } } else {echo "<tr><td colspan=9>Tidak ada permintaan barang.</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        $("#userss").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
