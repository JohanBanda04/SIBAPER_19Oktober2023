<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

$array_pengajuan_bendahara = array();
$array_pengajuan_kasub_bendahara = array();
$array_setuju_kasub_bendahara = array();
$array_tidak_setuju_kasub_bendahara = array();
$array_serah_brg_ke_pengguna = array();
$array_selesai = array();
$tgl_sekarang = date('Y-m-d');

if (isset($_SESSION['kirim_email_ke_kasub_bendahara'])) {
//    echo "jangan kirim email lagi<br>";
} else {
//    echo "proses utk kirim email";
}

//index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-19&user_id_pemohon=23&bendahara_id=31
if (isset($_GET['tgl']) && isset($_GET['unit'])) {
    $tgl = $_GET['tgl'];
    $unit = $_GET['unit'];
    $user_id_pemohon = $_GET['user_id_pemohon'];
    $bendahara_id = isset($_GET['bendahara_id']) ? $_GET['bendahara_id'] : '';


    if(isset($_GET['kode_brg_lengkap'])){
        if($_GET['kode_brg_lengkap']!=""){
            //echo "<br> get kode barang DISET dan ADA ISINYA =".$_GET['kode_brg_lengkap']."<br>";
            $query = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and sementara.kode_brg='$_GET[kode_brg_lengkap]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and sementara.kode_brg='$_GET[kode_brg_lengkap]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai'))");
        } else if($_GET['kode_brg_lengkap']==""){
            //echo "kode brg tidak dipilih" ; die;
            //echo "<br> get kode barang DISET dan TIDAK ADA ISINYA <br>";
            $query = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai'))");
        }
    } else if(!isset($_GET['kode_brg_lengkap'])){
        //echo "<br> get kode barang TIDAK DISET dan TIDAK ADA ISINYA CUY <br>";
        $query = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai'))");


    }

//    echo "bendahara_id:" . $bendahara_id . "::";

    $query_old_v1 = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) ");

    $queries = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) ");


    $query_get_email_penggunas = mysqli_query($koneksi, "select * from (((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) inner join user on sementara.user_id=user.id_user) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) ");


    //metode kirim email ribet berhasil
    $query_pengecekan = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) ");


    $jml_request = mysqli_num_rows($query_pengecekan);
    //echo "jml request : ".$jml_request."<br>";

    $query_pengecekan_aju_kasub_bendahara = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Kasub Bendahara')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Kasub Bendahara')) ");

    $query_pengecekan_serah_brg_ke_pengguna = mysqli_query($koneksi, "select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Penyerahan Barang Ke Pengguna')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Penyerahan Barang Ke Pengguna')) ");

    $query_get_email_pengguna = mysqli_query($koneksi,"select * from user where jabatan='Kasub Operator'");
    $dt_email_pengguna = mysqli_fetch_assoc($query_get_email_pengguna) ;
    $email_kasub_pengguna = $dt_email_pengguna['email'];
    $nama_lengkap_kasub_pengguna = $dt_email_pengguna['nama_lengkap'];
    //echo "email tujuans : ".$email_kasub_pengguna."<br>";
    //echo "nama tujuans : ".$nama_lengkap_kasub_pengguna."<br>";


    while ($dt = mysqli_fetch_array($query_pengecekan)) {
        if ($dt['status_acc'] == "Pengajuan Bendahara") {
            array_push($array_pengajuan_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "Pengajuan Kasub Bendahara") {
            array_push($array_pengajuan_kasub_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "Setuju Kasub Bendahara") {
            array_push($array_setuju_kasub_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "Tidak Setuju Kasub Bendahara") {
            array_push($array_tidak_setuju_kasub_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if($dt['status_acc'] == "Penyerahan Barang Ke Pengguna"){
            array_push($array_serah_brg_ke_pengguna,(object)[
                    "status_sekarang"=>$dt['status_acc'],
            ]);
        } else if($dt['status_acc'] == "Selesai"){
            array_push($array_selesai,(object)[
                    "status_sekarang"=>$dt['status_acc'],
            ]);
        }
    }

    //echo "ini size pengajuan bendahara:" . count($array_pengajuan_bendahara) . "<br>";
    //echo "ini size pengajuan kasub bendahara:" . count($array_pengajuan_kasub_bendahara) . "<br>";
    //echo "ini size setuju kasub bendahara:" . count($array_setuju_kasub_bendahara) . "<br>";
    //echo "ini size tidak setuju kasub bendahara:" . count($array_tidak_setuju_kasub_bendahara) . "<br>";
    //echo "ini size serah barang ke pengguna:" . count($array_serah_brg_ke_pengguna) . "<br>";

    //echo "query_pengecekan_aju_kasub_bendahara : ".mysqli_num_rows($query_pengecekan_aju_kasub_bendahara)."<br>";
    //echo "query_pengecekan_serah_brg_ke_pengguna :".mysqli_num_rows($query_pengecekan_serah_brg_ke_pengguna)."<br>";

    //tinggal tambah disini jika ingin menambahkan proses pengiriman email bagi permintaan yg tdk disetujui
    if(count($array_pengajuan_kasub_bendahara)==$jml_request){
        //echo "<br>kirimlah email ke kasub bendahara";
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com"; //host email

        //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
        //$mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "senderforemail340@gmail.com"; //user email
        $mail->Password = "mtklbsimtazfowfi"; //password email
        $mail->SetFrom("senderforemail340@gmail.com", "Permohonan Konfirmasi Barang dari Pengelola"); //set email pengirim
        $mail->Subject = "Permohonan Konfirmasi Barang dari Pengelola"; //subyek email
        $mail->AddAddress($email_kasub_pengguna);  // email tujuan
        $mail->MsgHTML("Halo, ".$nama_lengkap_kasub_pengguna."Terdapat Permohonan Konfirmasi Barang dari Pengelola dari ".$_SESSION['nama_lengkap'].", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
        $mail->Send();
    } else if(count($array_serah_brg_ke_pengguna)==$jml_request){
        //echo "<br>kirimlah email penyerahan barang ke pengguna";

        while($data_email_pemohon = mysqli_fetch_array($queries)){
            //echo "USER IDN : ".$data_email_pemohon['user_id']."<br>";
            $query_get_pemohon = mysqli_query($koneksi,"select * from user where id_user=$data_email_pemohon[user_id]");
            $pemohon_data = mysqli_fetch_assoc($query_get_pemohon);


            $email_pemohon = $pemohon_data['email'];
            $nama_lengkap_pemohon = $pemohon_data['nama_lengkap'];

            //echo "EMAIL IDN : ".$email_pemohon."<br>";
            //echo "NAMA LENGKAP IDN : ".$nama_lengkap_pemohon."<br>";

            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com"; //host email

            //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
            //$mail->SMTPDebug = 2;
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = "senderforemail340@gmail.com"; //user email
            $mail->Password = "mtklbsimtazfowfi"; //password email
            $mail->SetFrom("senderforemail340@gmail.com", "Pemberian Barang Ke Pemohon Barang"); //set email pengirim
            $mail->Subject = "Pemberian Barang Ke Pemohon Barang"; //subyek email
            $mail->AddAddress($email_pemohon);  // email tujuan
            $mail->MsgHTML("Halo, ".$nama_lengkap_pemohon."Terdapat Pemberian Barang Ke Pemohon Barang dari Pengelola : ".$_SESSION['nama_lengkap'].", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
            $mail->Send();
        }

    } else if(count($array_selesai) == $jml_request){
        //disini array selesai
        //echo "<br>kirim email konfirmasi selesai ke pengguna";
        while($data_email_pemohon = mysqli_fetch_array($query_get_email_penggunas)){
            //echo "<br>data unit ".$data_email_pemohon['unit'];

            $dt_email_tujuan = $data_email_pemohon['email'];
            $dt_nama_lengkap = $data_email_pemohon['nama_lengkap'];

            //echo "<br>email tujuan konfirm selesai : ".$dt_email_tujuan;
            //echo "<br>nama lengkap tujuan konfirm selesai : ".$dt_nama_lengkap;

            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com"; //host email

            //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
            //$mail->SMTPDebug = 2;
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = "senderforemail340@gmail.com"; //user email
            $mail->Password = "mtklbsimtazfowfi"; //password email
            $mail->SetFrom("senderforemail340@gmail.com", "Konfirmasi Penerimaan Barang Selesai"); //set email pengirim
            $mail->Subject = "Konfirmasi Penerimaan Barang Selesai"; //subyek email
            $mail->AddAddress($dt_email_tujuan);  // email tujuan
            $mail->MsgHTML("Halo, ".$dt_nama_lengkap." Terdapat Konfirmasi Penerimaan Barang Selesai dari Pengelola : ".$_SESSION['nama_lengkap'].", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
            $mail->Send();
        }
    } else {
        //echo "<br>jangan kirim email dululah";
//        echo $email_kasub_pengguna."<br>";
//        echo $nama_lengkap_kasub_pengguna."<br>";
    }


}


if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'edit')
        header("location:?p=editpesan");
}

?>
<!--disini dicek johan-->

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">
                        <?php
                        $get_nama_pemohon = mysqli_query($koneksi,"select * from `user` where id_user='$user_id_pemohon'");
                        $nama_lengkap_pemohon = mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap'];
                        ?>
                        KKonfirmasi Permintaan <b><?php echo $nama_lengkap_pemohon; ?></b></h3><br>
                    <center>
                        <span style="font-weight: bold">
                            <?php echo tanggal_indo($tgl); ?>
                        </span>
                    </center>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapermintaan_table&pas=permintaanbarang" style="margin:10px;" class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center" id="detilpermintaan_side_operator">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Id Permintaan</th>
                                <th>Nama Pemohon</th>
                                <th>Nama Bendahara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--<tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)) {

                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= $row['id_sementara']; ?> </td>
                                        <td>
                                            <?php
                                            $get_nama_pemohon = mysqli_query($koneksi, "select nama_lengkap from `user` where id_user='$row[user_id]'");
                                            echo mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap'];
                                            //$row['unit'];
                                            ?>
                                        </td>

                                        <?php if ($row['bendahara'] == '' || $row['bendahara'] == null) { ?>
                                            <td> Belum Ada</td>
                                        <?php } else { ?>
                                            <td>
                                                <?php
                                                $get_nama_bendahara = mysqli_query($koneksi,"select nama_lengkap from `user` where id_user='$row[bendahara_id]'");
                                                //$row['bendahara'];
                                                echo mysqli_fetch_assoc($get_nama_bendahara)['nama_lengkap'];
                                                ?> </td>
                                        <?php } ?>

                                        <td> <?= $row['kode_brg']; ?> </td>
                                        <td> <?= $row['nama_brg']; ?> </td>
                                        <td> <?= $row['satuan']; ?> </td>
                                        <td> <?= $row['jumlah']; ?> </td>
                                        <td style="color: #00a7d0;font-weight: bold"> <?= $row['status_acc']; ?> </td>
                                        <td>

                                            <?php
                                            if ($row['status_acc'] != 'Pengajuan Bendahara') {
                                                if ($row['status_acc'] == 'Setuju Kasub Bendahara') {
                                                    ?>
                                                    <!--disini contoh penggunaan metode post terbaru-->
                                                    <form method="post" action="penyerahan_barang_pengguna_table.php">
                                                        <input class="hidden" type="text" name="unit"
                                                               value="<?php echo $row['unit']; ?>">
                                                        <input class="hidden" type="text" name="tgl_permintaan"
                                                               value="<?php echo $row['tgl_permintaan']; ?>">
                                                        <input class="hidden" type="text" name="user_id"
                                                               value="<?php echo $row['user_id']; ?>">
                                                        <input class="hidden" type="text" name="bendahara_id"
                                                               value="<?php echo $row['bendahara_id']; ?>">

                                                        <input class="hidden" type="text" name="bendahara"
                                                               value="<?php echo $row['bendahara']; ?>">
                                                        <input class="hidden" type="text" name="id_sementara"
                                                               value="<?php echo $row['id_sementara']; ?>">

                                                        <input onclick="return confirm('Penyerahan Barang Ke Pengguna?')"
                                                               type="submit" id="penyerahan_barang_pengguna"
                                                               name="penyerahan_barang_pengguna"
                                                               style="background-color: #1b860c"
                                                               class="btn btn-primary col-sm-offset-3"
                                                               value="Penyerahan Barang Ke Pengguna">

                                                    </form>
                                                    <!--                                                <a id="bt_penyerahan_barang_ke_pengguna" onclick="" class="btn btn-success"-->
                                                    <!--                                                   style="background-color: #1b860c"-->
                                                    <!--                                                   href="penyerahan_barang_pengguna.php?bendahara=--><?php //echo $row['bendahara'];
                                                    ?><!--">-->
                                                    <!--                                                    Penyerahan Barang Ke Pengguna-->
                                                    <!--                                                </a>-->
                                                    <?php
                                                } else if ($row['status_acc'] == "Pengajuan Kasub Bendahara") {
                                                    if ($row['status_acc'] == "Pengajuan Kasub Bendahara") { ?>
                                                        <a id="bt_edit_fake" href="#">
                                                        <span class="disabled btn btn-info" data-placement='top'
                                                              data-toggle='tooltip'
                                                              title='Edit'>
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                        </a>


                                                        <a id="bt_ajukan_kasubbendahara_fake" href="#">
                                                        <span class="disabled btn btn-success"
                                                              data-placement='top' data-toggle='tooltip'
                                                              title='sPemberitahuan Kasub Bendahara'>
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                        </a>
                                                    <?php } ?>
                                                <?php } else if ($row['status_acc'] == "Tidak Setuju Kasub Bendahara") { ?>
                                                    <!--penggunaan metode post disini juga-->
                                                    <form action="hapus_yg_tidak_disetujui.php" method="post">
                                                        <input class="hidden" type="text"
                                                               name="hapus_yg_tidak_disetujui"
                                                               id="hapus_yg_tidak_disetujui"
                                                               value="<?php echo $row['id_sementara']; ?>">
                                                        <button class="btn btn-danger"
                                                                title="Hapus" data-placement='top' data-toggle='tooltip'
                                                                type="submit"
                                                                onclick="return confirm('Menghapus Data?')">
                                                            <i class="fa fa-remove"></i>
                                                        </button>


                                                    </form>
                                                    <form action="edit_yg_tidak_disetujui.php" method="post">
                                                        <input class="hidden" type="text" name="edit_yg_tidak_disetujui"
                                                               id="edit_yg_tidak_disetujui"
                                                               value="<?php echo $row['id_sementara']; ?>">
                                                        <button class="btn btn-info"
                                                                title="Edit" data-placement='top' data-toggle='tooltip'
                                                                type="submit"
                                                                onclick="return confirm('Edit Data?')">
                                                            <i class="fa fa-edit"></i>
                                                        </button>


                                                    </form>


                                                <?php } else if ($row['status_acc'] == 'Penyerahan Barang Ke Pengguna') { ?>
                                                    <a href="#">Silakan Lakukan Pemberian Barang</a>
                                                <?php } else if ($row['status_acc'] == 'Penerimaan Barang Dari Bendahara') { ?>
                                                    <!--                                                <a href="#">Sudah Diterima Pengguna</a>-->
                                                    <!--                                                <form action="edit_yg_tidak_disetujui.php" method="post">-->
                                                    <!--                                                    <input class="hidden" type="text" name="edit_yg_tidak_disetujui"-->
                                                    <!--                                                           id="edit_yg_tidak_disetujui"-->
                                                    <!--                                                           value="--><?php //echo $row['id_sementara']; ?><!--">-->

                                                    <a href="index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=<?php echo $row['id_sementara']; ?>"
                                                       class="btn btn-info"
                                                       title="Konfirmasi Selesai"
                                                       data-placement='top'
                                                       data-toggle='tooltip'
                                                       onclick="return confirm('Konfirmasi Selesai?')">
                                                        Sudaah Diterima Pengguna
                                                    </a>


                                                    <!--                                                </form>-->
                                                <?php } else { ?>
                                                    <!--                                                <a href="index.php?p=sudah_serahkan_barang_ke_pengguna&id_sementara=--><?php //echo $row['id_sementara'];?><!--" class="btn btn-info"-->
                                                    <!--metode penggunaan satu baris tombol yang ada di satu baris-->
                                                    <div style=" width: 200px">
                                                        <a style="" href="../<?php echo $row['path_foto']; ?>"
                                                           class="btn btn-info"
                                                           title="Lihat Foto Penyerahan" target="_blank"
                                                           data-placement='top'
                                                           data-toggle='tooltip'
                                                           onclick="return confirm('Lihat Foto?')">
                                                            Lihat Foto Penyerahan
                                                        </a>

                                                        <!--                                                    <a href="index.php?p=sudah_serahkan_barang_ke_pengguna&id_sementara=-->
                                                        <?php //echo $row['id_sementara'];?><!--" class="btn btn-info"-->
                                                        <!--                                                       title="Konfirmasi Selesai"-->
                                                        <!--                                                       data-placement='top'-->
                                                        <!--                                                       data-toggle='tooltip' onclick="return confirm('Konfirmasi Selesai?')">-->
                                                        <!--                                                        Ganti Bukti-->
                                                        <!--                                                    </a>-->

                                                        <!--LANJUTKAN DISINI BENAHI URL UNTUK GANTI FOTO BUKTI-->
                                                        <a target="_blank" id="bt_ganti Foto"
                                                           href="index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=<?php echo $row['id_sementara']; ?>">
                                                        <span class="btn btn-success"
                                                              data-placement='top' data-toggle='tooltip'
                                                              title='Ganti Foto Buktiz'>
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                        </a>
                                                    </div>
                                                <?php }
                                                ?>

                                                <?php
                                            } else {

                                                if ($row['status_acc'] == 'Pengajuan Bendahara') { ?>
                                                    <a href="index.php?p=edit_permintaan_pengguna&unit=<?php echo $row['unit']; ?>&id_sementara=<?php echo $row['id_sementara']; ?>&tgl_permintaan=<?php echo $row['tgl_permintaan'] ?>&user_id_pemohon=<?php echo $row['user_id']; ?>">
                                                        <span class="btn btn-info" data-placement='top'
                                                              data-toggle='tooltip'
                                                              title='Edit Datas'>
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                    </a>
                                                    <a data-placement='top' data-toggle='tooltip'
                                                       title="Pemberitahuan Kasub Bendahara"
                                                       onclick="return confirm('Ajukan ke Kasub Bendahara?')"
                                                       class="btn btn-success"
                                                       style="background-color: #1b860c"
                                                       href="ajukan_via_kasub_barang_table.php?unit=<?php echo $row['unit']; ?>&id_sementara=<?php echo $row['id_sementara']; ?>&tgl_permintaan=<?php echo $row['tgl_permintaan']; ?>&user_id_pemohon=<?php echo $row['user_id'] ?>&bendahara_id=<?php echo $row['bendahara_id'] ?? ''; ?>">
                                                        <!--                                                        Pemberitahuan Kasub Bendahara-->
                                                        <i class="fa fa-check "></i>
                                                    </a>
                                                    <?php

                                                }
                                                ?>
                                                <!--Pemberitahuan Kasub Barang-->

                                                <?php
                                            }
                                            ?>

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
</section>

<script>

    $(function () {
        $("#detilpermintaan_side_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>

