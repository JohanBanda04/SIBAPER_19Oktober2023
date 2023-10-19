

<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));

//metode array_push dan is_array pada proses cetak bpp
if(isset($_POST['tampilkan'])){


    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    //disini sudah dibuatkan pilihan pilih status
    //tinggal diatifkan komenan dibawah
//    $jenis_status_acc = $_POST['jenis_status_acc'];

//    echo $jenis_status_acc;


    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;



    $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' ");


    $array_bendahara = array();
    $array_bendahara_done = array();
    while($item = mysqli_fetch_array($query)){

        array_push($array_bendahara,$item['bendahara']);

        $query_cek = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' ");

        while($values = mysqli_fetch_array($query_cek)){
            if($item['bendahara'] == $values['bendahara']){
                array_push($array_bendahara_done,"Nama Bendahara Sama");
            } else if($item['bendahara'] != $values['bendahara']){
                array_push($array_bendahara_done,"Nama Bendahara Ada Yang Beda");
            }
        }
    }



    if(!in_array("Nama Bendahara Ada Yang Beda",$array_bendahara_done)){
        echo "nama bendahara sama semua";
        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' group by sementara.tgl_permintaan");
    } else {
        echo "nama bendahara ada yang tidak sama";
        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tanggala' and '$tanggalb'
and permintaan.`status`='1' ");
    }


} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){

        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and permintaan.`status`='1' ");


        $array_bendahara = array();
        $array_bendahara_done = array();
        while($item = mysqli_fetch_array($query)){

            array_push($array_bendahara,$item['bendahara']);

            $query_cek = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and permintaan.`status`='1' ");

            while($values = mysqli_fetch_array($query_cek)){
                if($item['bendahara'] == $values['bendahara']){
                    array_push($array_bendahara_done,"Nama Bendahara Sama");
                } else if($item['bendahara'] != $values['bendahara']){
                    array_push($array_bendahara_done,"Nama Bendahara Ada Yang Beda");
                }
            }
        }



        if(!in_array("Nama Bendahara Ada Yang Beda",$array_bendahara_done)){
            echo "nama bendahara sama semua";
            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and permintaan.`status`='1' group by sementara.tgl_permintaan");
        } else {
            echo "nama bendahara ada yang tidak sama";
            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and permintaan.`status`='1' ");
        }


    } else {


        $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and permintaan.`status`='1' ");

        $array_bendahara = array();
        $array_bendahara_done = array();
        while($item = mysqli_fetch_array($query)){

            array_push($array_bendahara,$item['bendahara']);

            $query_cek = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and permintaan.`status`='1' ");

            while($values = mysqli_fetch_array($query_cek)){
                if($item['bendahara'] == $values['bendahara']){
                    array_push($array_bendahara_done,"Nama Bendahara Sama");
                } else if($item['bendahara'] != $values['bendahara']){
                    array_push($array_bendahara_done,"Nama Bendahara Ada Yang Beda");
                }
            }
        }



        if(!in_array("Nama Bendahara Ada Yang Beda",$array_bendahara_done)){
            echo "nama bendahara sama semua";
            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and permintaan.`status`='1' group by sementara.tgl_permintaan");
        } else {
            echo "nama bendahara ada yang tidak sama";
            $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara)
where sementara.unit='$_SESSION[username]' and sementara.user_id='$_SESSION[user_id]' 
and sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and permintaan.`status`='1' ");
        }
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
                            <div style="margin-top: 20px"></div>


                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>



                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="cetak_bpp_baru" class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Bendahara</th>
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
                                            <td><?php echo $dt['unit'];?></td>
                                            <td><?php echo $dt['bendahara'];?></td>
                                            <td><?php echo tanggal_indo($dt['tgl_permintaan']);?></td>
                                            <td>
                                                <a target="_blank" href="cetakpesanan.php?&tgl=<?= $dt['tgl_permintaan']; ?>&unit=<?= $dt['unit']; ?>&instansi=<?= $dt['instansi']; ?>&bendahara=<?= $dt['bendahara']; ?>&bendahara_id=<?= $dt['bendahara_id']; ?>">
                        <span data-placement='top' data-toggle='tooltip' title='Cetak BPP'>
                            <button class="btn btn-success" style="background-color: #10d4cb">
                                <i class="fa fa-print" style=""> sCetak BPP </i>
                            </button>
                        </span>
                                                </a>
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
