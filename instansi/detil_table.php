<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

$array_pengajuan_ke_bendahara = array();
$array_kirim_setelah_setuju_kasub = array();
$array_setuju_kasub_pengguna = array();
$array_bukan_setuju_kasub_pengguna = array();
$array_sudah_ajukan_ke_bendahara = array();
$tgl_sekarang = date('Y-m-d');

if (isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];

    $array_email_tujuan = array();


    if(isset($_GET['kode_brg_lengkap'])){
        if($_GET['kode_brg_lengkap']!=""){
            //echo "<br> get kode barang DISET dan isinya = ".$_GET['kode_brg_lengkap']."<br>";

            $query = mysqli_query($koneksi, "select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' 
and sementara.kode_brg='$_GET[kode_brg_lengkap]' and
status_acc in('Pengajuan Kasub','setuju','tidak_setuju','Permintaan Baru')");
        } else if($_GET['kode_brg_lengkap']==""){
            //echo "<br> get kode barang DISET dan isinya kosongan ";
            $query = mysqli_query($koneksi, "select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' 
and status_acc in('Pengajuan Kasub','setuju','tidak_setuju','Permintaan Baru')");
            //lanjutkan disini
        }
//        echo "<br> get kode barang ada isinya = ".$_GET['kode_brg_lengkap']."<br>";
    } else if(!isset($_GET['kode_brg_lengkap'])){
        //echo "<br> get kode barang TIDAK DISET <br>";
        $query = mysqli_query($koneksi, "select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' 
and status_acc in('Pengajuan Kasub','setuju','tidak_setuju','Permintaan Baru')");
    }
    $query_old_v_1 = mysqli_query($koneksi, "select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' and 
status_acc in('Pengajuan Kasub','setuju','tidak_setuju','Permintaan Baru')");

    $query_cek = mysqli_query($koneksi, "select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' and 
status_acc in('Pengajuan Kasub','setuju','Permintaan Baru','tidak_setuju')");



    //metode kirim email ribet 2

    while ($dt_pengajuan_kasub = mysqli_fetch_array($query_cek)) {
        if ($dt_pengajuan_kasub['status_acc'] == 'setuju') {
            array_push($array_kirim_setelah_setuju_kasub, (object)[
                "status_sekarang" => "ini sudah setuju kasub pengguna",
            ]);
        } else if ($dt_pengajuan_kasub['status_acc'] != 'setuju') {
            array_push($array_kirim_setelah_setuju_kasub, (object)[
                "status_sekarang" => "ini bukan setuju kasub pengguna",
            ]);
        }
    }

//    echo "hay:".mysqli_num_rows($query_cek)."<br>";

//    echo "sized : " . count($array_kirim_setelah_setuju_kasub) . "<br>";

    foreach ($array_kirim_setelah_setuju_kasub as $idx => $val) {
//        echo $val->status_sekarang."<br>";
        if ($val->status_sekarang == 'ini sudah setuju kasub pengguna') {
            array_push($array_setuju_kasub_pengguna, "setuju kasub pengguna");
        } else if ($val->status_sekarang == 'ini sudah bukan setuju kasub pengguna') {
            array_push($array_bukan_setuju_kasub_pengguna, "bukan setuju kasub pengguna");
        }
    }


    //echo count($array_setuju_kasub_pengguna) . " ini size setuju<br>";
    //echo count($array_bukan_setuju_kasub_pengguna) . " ini size bukan setuju<br>";

    $query_get_email_bendaharas = mysqli_query($koneksi, "select * from user where jabatan='Operator'");

    $query_cek_pengajuan_bendahara = mysqli_query($koneksi,"select * from sementara 
inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and 
tgl_permintaan='$tgl' and 
status_acc in('Pengajuan Bendahara')");

    // Lanjutkan Disini, JIKA $query_cek_pengajuan_bendahara > 0 MAKA tidak kirim ulang email,
    //echo "sudah ajukan bendahara : ".mysqli_num_rows($query_cek_pengajuan_bendahara)."<br>";

    while($dt_ajukan_bendahara = mysqli_fetch_array($query_cek_pengajuan_bendahara)){
        if($dt_ajukan_bendahara['status_acc']=="Pengajuan Bendahara"){
            array_push($array_sudah_ajukan_ke_bendahara,(object)[
                    "status_sekarang"=>"ini sudah ajukan ke bendahara",
            ]);
        }
    }


    //echo "sudah di bendahara::".count($array_sudah_ajukan_ke_bendahara)."<br>";

    if (count($array_setuju_kasub_pengguna) == 0) {
        while ($dt_get_email_bendahara = mysqli_fetch_array($query_get_email_bendaharas)) {
            $dt_email_bendahara = $dt_get_email_bendahara['email'];
            $dt_nama_lengkap_bendahara = $dt_get_email_bendahara['nama_lengkap'];
//            echo "<br>ini email bendahara " . $dt_email_bendahara . "<br>";
//            echo "ini nama lengkap bendahara " . $dt_nama_lengkap_bendahara . "<br>";

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
            $mail->SetFrom("senderforemail340@gmail.com", "Permohonan Permintaan Barang Pengguna ke Pengelola"); //set email pengirim
            $mail->Subject = "Permohonan Permintaan Barang Pengguna ke Pengelola"; //subyek email
            $mail->AddAddress($dt_email_bendahara);  // email tujuan
            $mail->MsgHTML("Halo, ".$dt_nama_lengkap_bendahara." Terdapat Permohonan Permintaan Barang Pengguna ke Pengelola dari ".$_SESSION['nama_lengkap'].", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan

            $mail->Send();

        }

    } else {
        //echo "belum kirim email";
    }





//    if (count($array_pengajuan_ke_bendahara) <= 0) {
//        echo "kirim email";
//
//        $query_get_email_bendahara = mysqli_query($koneksi, "select * from user where jabatan='Operator'");
//
//        while ($dt_get_email_bendahara = mysqli_fetch_array($query_get_email_bendahara)) {
//            $dt_email_tujuan = $dt_get_email_bendahara['email'];
//            $dt_nama_lengkap_tujuan = $dt_get_email_bendahara['nama_lengkap'];
////            echo $dt_email_tujuan."<br>";
////            echo $dt_nama_lengkap_tujuan."<br>";
//
//            //metode kirim email kirim konfirmasi ke bendahara barang
//            $mail = new PHPMailer;
//            $mail->IsSMTP();
//            $mail->SMTPSecure = "ssl";
//            $mail->Host = "smtp.gmail.com"; //host email
//
//            //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
//            //$mail->SMTPDebug = 2;
//            $mail->Port = 465;
//            $mail->SMTPAuth = true;
//            $mail->Username = "senderforemail340@gmail.com"; //user email
//            $mail->Password = "mtklbsimtazfowfi"; //password email
//            $mail->SetFrom("senderforemail340@gmail.com", "Permintaan Barang Ke Operator"); //set email pengirim
//            $mail->Subject = "Permintaan Barang Ke Operator"; //subyek email
//            $mail->AddAddress($dt_email_tujuan);  // email tujuan
//            $mail->MsgHTML("Halo, " . $dt_nama_lengkap_tujuan . " Terdapat Permintaan Barang Ke Operator dari " . $_SESSION['nama_lengkap'] . ", segera cek aplikasi SIMANTAB"); //pesan
//            $mail->Send();
//        }
//
//
//    } else if (count($array_pengajuan_ke_bendahara) > 0) {
//        echo "jangan kirim email dulu";
//    }

}

if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $aksi = $_GET['aksi'];
    $id = $_GET['id'];
    if ($aksi == 'hapus') {
        $query2 = mysqli_query($koneksi, "DELETE FROM permintaan WHERE id_permintaan='$id' ");
        if ($query2) {
            header("location:?p=detil&tgl=" . $tgl);
        } else {
            echo 'gagal';
        }
    }
}
?>

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <!--lanjutkan disini untuk perbaikan metode cara kirim email-->
                    <h3 class="text-center">Data Permintaan Barang Tanggal
                        <strong><?php echo tanggal_indo($tgl); ?></strong></h3>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapesanan_table" style="margin:10px;background-color: #486055"
                       class="btn btn-success"><i class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead style="background-color: #b6eee0; font-weight: bold">
                            <tr>
                                <th style="color: black">Nos</th>
                                <th style="color: black">Id Sementara</th>
                                <th style="color: black">Kode Barang</th>
                                <th style="color: black">Nama Barang</th>
                                <th style="color: black">Satuan</th>
                                <th style="color: black">Jumlah</th>
                                <th style="color: black">Status</th>
                                <th style="color: black">Aksi</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $array_status_acc_temporary = array();

                            //disana

                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                //disini metode post
                                while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <form method="post" action="permintaan_ke_bendahara_table.php">

                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['id_sementara']; ?></td>
                                            <input class="hidden" type="text" name="nomor_urut"
                                                   value="<?php echo $no++; ?>">
                                            <input class="hidden" type="text" name="id_sementara"
                                                   value="<?php echo $row['id_sementara']; ?>">

                                            <td><?php echo $row['kode_brg']; ?></td>
                                            <input class="hidden" type="text" name="kode_brg"
                                                   value="<?php echo $row['kode_brg']; ?>">
                                            <input class="hidden" type="text" name="id_jenis"
                                                   value="<?php echo $row['id_jenis']; ?>">

                                            <td><?php echo $row['nama_brg']; ?></td>
                                            <input class="hidden" type="text" name="nama_brg"
                                                   value="<?php echo $row['nama_brg']; ?>">

                                            <td><?php echo $row['satuan']; ?></td>
                                            <input class="hidden" type="text" name="satuan_brg"
                                                   value="<?php echo $row['satuan']; ?>">

                                            <td><?php echo $row['jumlah']; ?></td>
                                            <input class="hidden" type="text" name="jumlah_brg"
                                                   value="<?php echo $row['jumlah']; ?>">

                                            <td><?php echo ucwords($row['status_acc']); ?></td>
                                            <input class="hidden" type="text" name="status_acc_brg"
                                                   value="<?php echo $row['status_acc']; ?>">
                                            <input class="hidden" type="text" name="tgl_permintaan"
                                                   value="<?php echo $row['tgl_permintaan']; ?>">
                                            <input class="hidden" type="text" name="status"
                                                   value="<?php echo $row['status']; ?>">

                                            <td title="Ajukan Ke Bendahara Barangs">
                                                <center>
                                                    <?php if ($row['status_acc'] != 'setuju') { ?>
                                                        <input onclick=""
                                                               type="button" disabled id=""
                                                               name=""
                                                               class="btn btn-primary col-sm-offset-3 disabled"
                                                               value="Ajukan Pengelola">
                                                    <?php } else if ($row['status_acc'] == 'setuju') { ?>
                                                        <input onclick="return confirm('Kirim Permintaan Barang ke Bendahara?')"
                                                               type="submit" id="permintaan_ke_bendahara"
                                                               name="permintaan_ke_bendahara"
                                                               class="btn btn-primary col-sm-offset-3"
                                                               value="Ajukan Pengelola">
                                                    <?php } ?>

                                                </center>

                                            </td>
                                        </tr>
                                    </form>
                                <?php }
                            }
                            ?>

                            <?php


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
        NB : Setelah semua permintaan diajukan ke Bendahara, Anda dapat melihat posisi proses pada menu
            <a style="font-weight: bold" href="?p=history_permintaan_barang&pa=history_pengguna">
                History
            </a>
    </span>

    </div>


</section>

