<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

$tgl_sekarang = date('Y-m-d');
$array_penyerahan_brg_ke_pengguna = array();
$array_tdk_setuju_kasub_bendahara = array();
$array_penerimaan_brg_dari_bendahara = array();
$array_tidak_setuju = array();

if (isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])) {
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    //echo $_GET['unit']."<br>".$_GET['user_id']."<br>".$_GET['tgl_permintaan']."<br>".$_GET['kode_brg_lengkap']; die;

    if(isset($_GET['kode_brg_lengkap'])){

        //lanjutkan disinii
        if($_GET['kode_brg_lengkap']!=""){
            //echo "<br> get kode barang ada isinya :".$_GET['kode_brg_lengkap']."<br>";
            $query = mysqli_query($koneksi, "select sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc, sementara.unit, sementara.user_id,sementara.kode_brg, sementara.tgl_permintaan
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan' and stokbarang.kode_brg='$_GET[kode_brg_lengkap]' 
and status_acc not in
('Permintaan Baru','Pengajuan Kasub')");

        } else if($_GET['kode_brg_lengkap']==""){
           // echo "<br> get kode barang tdk ada isissnya<br>";
            $query = mysqli_query($koneksi, "select sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc,sementara.unit, sementara.user_id, sementara.kode_brg, sementara.tgl_permintaan
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan'  
and status_acc not in
('Permintaan Baru','Pengajuan Kasub')");
        }
    } else if(!isset($_GET['kode_brg_lengkap'])){
       // echo "<br> get kode barang tdk ada isinya<br>";
    }

    $query_v1_old = mysqli_query($koneksi, "select sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan' and status_acc not in
('Permintaan Baru','Pengajuan Kasub')");

    //harus dibedakan walaupun query nya sama
    $query_pengecekan = mysqli_query($koneksi, "select sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan' and status_acc not in
('Permintaan Baru','Pengajuan Kasub')");

    // ditambahkan pada not in status 'Tidak Setuju Kasub Bendahara', agar permintaan via bendahara
    // yg tidak disetujui oleh kasub bendahara, bendahara ny tidak dikirimkan email email konfirmasi jg
    $query_pengecekan_v2 = mysqli_query($koneksi, "select sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan'  and status_acc not in
('Permintaan Baru','Pengajuan Kasub','Tidak Setuju Kasub Bendahara')");



    $query_pengelolas = mysqli_query($koneksi, "select user.email,user.nama_lengkap,
sementara.bendahara,sementara.bendahara_id,sementara.id_sementara
,stokbarang.nama_brg,stokbarang.satuan,sementara.jumlah,sementara.note_kasub_pengguna,sementara.note_bendahara,
sementara.status_acc
from ((sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) INNER JOIN user on sementara.bendahara_id=user.id_user) 
where (unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan'  and status_acc not in
('Permintaan Baru','Pengajuan Kasub','Tidak Setuju Kasub Bendahara'))");



    $jml_request = mysqli_num_rows($query_pengecekan);

    //echo "JML REQ: " . $jml_request . "<br>";

    while ($dt = mysqli_fetch_array($query_pengecekan)) {
        if ($dt['status_acc'] == "Penyerahan Barang Ke Pengguna") {
            array_push($array_penyerahan_brg_ke_pengguna, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "Tidak Setuju Kasub Bendahara") {
            array_push($array_tdk_setuju_kasub_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "Penerimaan Barang Dari Bendahara") {
            array_push($array_penerimaan_brg_dari_bendahara, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        } else if ($dt['status_acc'] == "tidak_setuju") {
            array_push($array_tidak_setuju, (object)[
                "status_sekarang" => $dt['status_acc'],
            ]);
        }

    }


    //jika ada kondisi status yg disimpan ke array lainnya lagi, maka harus diakumulasikan
    $jml_akumulasi = count($array_tdk_setuju_kasub_bendahara) + count($array_penerimaan_brg_dari_bendahara);
    $jml_akumulasi_v2 = count($array_tidak_setuju) + count($array_penerimaan_brg_dari_bendahara);
    $jml_row = mysqli_num_rows($query_pengecekan_v2);
    //echo "array_penyerahan_brg_ke_pengguna : " . count($array_penyerahan_brg_ke_pengguna) . "<br>";
    //echo "array_tdk_setuju_kasub_bendahara : " . count($array_tdk_setuju_kasub_bendahara) . "<br>";
    //echo "array_penerimaan_brg_dari_bendahara : " . count($array_penerimaan_brg_dari_bendahara) . "<br>";
    //echo "jml_akumulasi : " . $jml_akumulasi . "<br>";
    //echo "penerimaan brg dr bendahara: " . count($array_penerimaan_brg_dari_bendahara) . "<br>";
    //echo "jml_akumulasi_v2 : " . $jml_akumulasi_v2 . "<br>";

    if ($jml_akumulasi == $jml_request) {
        //echo "kirim email<br>";
        while ($val = mysqli_fetch_array($query_pengecekan_v2)) {
            $query_data_pengelola = mysqli_query($koneksi, "select * from user where id_user=$val[bendahara_id]");
            $data_pengelola = mysqli_fetch_assoc($query_data_pengelola);

            $email_pengelola = $data_pengelola['email'];
            $nama_lengkap_pengelola = $data_pengelola['nama_lengkap'];

            //echo "<br>EMAIL IDNs : " . $email_pengelola . "<br>";
            //echo "NAMA LENGKAP IDNs : " . $nama_lengkap_pengelola . "<br>";

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
            $mail->SetFrom("senderforemail340@gmail.com", "Penerimaan Barang Oleh Pemohon Barang"); //set email pengirim
            $mail->Subject = "Penerimaan Barang Oleh Pemohon Barang"; //subyek email
            $mail->AddAddress($email_pengelola);  // email tujuan
            $mail->MsgHTML("Halo, " . $nama_lengkap_pengelola . ", Terdapat Konfirmasi Penerimaan Barang Oleh Pemohon Barang dari Pemohon Barang : " . $_SESSION['nama_lengkap'] . ", pada tanggal " . tanggal_indo($tgl_sekarang) . ",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
            $mail->Send();

        }
    } else if ($jml_akumulasi_v2 == $jml_request) {
        // perhatikan disini baik baik untuk melakukan proses kirim email dengan status acc yg berbeda
        //echo "kirim email ke pengelolas <br>";
        //lanjut disini dan cek akun bela
        while($dt_pengelolas = mysqli_fetch_array($query_pengelolas)){



            $nama_lengkap_pengelolas = $dt_pengelolas['nama_lengkap'];
            $email_pengelolas = $dt_pengelolas['email'];

            echo "<br> NAMA LENGKAP BENDAHARA :".$nama_lengkap_pengelolas."<br>";
            echo "<br> EMAIL LENGKAP BENDAHARA :".$email_pengelolas."<br>";
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
            $mail->SetFrom("senderforemail340@gmail.com", "Penerimaan Barang Oleh Pemohon Barang"); //set email pengirim
            $mail->Subject = "Penerimaan Barang Oleh Pemohon Barang"; //subyek email
            $mail->AddAddress($email_pengelolas);  // email tujuan
            $mail->MsgHTML("Halo, " . $nama_lengkap_pengelolas . ", Terdapat Konfirmasi Penerimaan Barang Oleh Pemohon Barang dari Pemohon Barang : " . $_SESSION['nama_lengkap'] . ", pada tanggal " . tanggal_indo($tgl_sekarang) . ",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
            $mail->Send();
        }

    } else {
        //echo "jgn kirim emails";
    }

}


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php
                    $get_nama_pemohon = mysqli_query($koneksi, "select nama_lengkap from `user` where id_user='$_SESSION[user_id]'");

                    ?>
                    <h3 class="text-center">History Permintaan <b><?php echo mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap']; ?></b></h3><br>
                    <h4 class="text-center" style="font-weight: bold"><?php echo tanggal_indo($tgl_permintaan) ?></h4>
                </div>
                <div class="box-body">
                    <!--                    p=history_kasub&pa=history_kasub_pengguna-->
                    <a href="index.php?p=history_permintaan_barang_table&pa=history_pengguna" style="margin:10px;"
                       class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center" id="detil_history_permintaan">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengelolaa</th>
                                <th>Id Sementara</th>
                                <!--                                <th>Kode Barang</th>-->
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Note Kasub</th>
                                <th>Note Bendahara</th>
                                <th style="background-color: ">Status</th>

                            </tr>
                            </thead>


                            <tbody>

                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):


                                    if ($row['status_acc'] != null) {
                                        ?>
                                        <!--jika belum disetujui-->
                                        <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?php
                                            $get_nama_pengelola = mysqli_query($koneksi, "select nama_lengkap from `user` where id_user='$row[bendahara_id]'");
                                            echo mysqli_fetch_assoc($get_nama_pengelola)['nama_lengkap'];
                                            $row['bendahara'];
                                            ?> </td>

                                        <!--                                    --><?php //if($row['bendahara']=="" || $row['bendahara']==null){
                                        ?>
                                        <!--                                        <td> --><?php //echo $row['bendahara'];
                                        ?><!-- </td>-->
                                        <!--                                    --><?php //} else {
                                        ?>
                                        <!--                                        <td> --><? //= $row['bendahara'];
                                        ?><!-- </td>-->
                                        <!---->
                                        <!--                                    --><?php //}
                                        ?>
                                        <td> <?= $row['id_sementara']; ?> </td>
                                        <!--                                    <td> --><? //= $row['kode_brg'];
                                        ?><!-- </td>-->
                                        <td> <?= $row['nama_brg']; ?> </td>
                                        <td> <?= $row['satuan']; ?> </td>
                                        <td> <?= $row['jumlah']; ?> </td>

                                        <?php if ($row['note_kasub_pengguna'] != null) { ?>
                                            <td> <?= $row['note_kasub_pengguna']; ?> </td>
                                        <?php } else { ?>
                                            <td> -</td>
                                        <?php } ?>


                                        <?php if ($row['note_bendahara'] != null) { ?>
                                            <td> <?= $row['note_bendahara']; ?> </td>
                                        <?php } else { ?>
                                            <td> -</td>
                                        <?php } ?>


                                        <?php if ($row['status_acc'] == 'Penyerahan Barang Ke Pengguna') { ?>
                                            <td>
                                                <!--                                            <form method="post" action="terima_barang_dari_bendahara.php">-->
                                                <!--                                                <input class="hidden" type="text" name="id_sementara" value="-->
                                                <?php //echo $row['id_sementara']; ?><!--">-->
                                                <!---->
                                                <!--                                                <input onclick="return confirm('Terima Barang Dari Bendahara?')"-->
                                                <!--                                                       type="submit" id="terima_barang_dari_bendahara"-->
                                                <!--                                                       name="terima_barang_dari_bendahara"-->
                                                <!--                                                       style="background-color: #1b860c"-->
                                                <!--                                                       class="btn btn-primary col-sm-offset-3"-->
                                                <!--                                                       value="Terima Barang Dari Bendahara">-->
                                                <!---->
                                                <!--                                            </form>-->
                                                <!--Set tombol ditengah-->
                                                <div class="col-md-2" style="width: 80%">
                                                    <!--                                                <a href="index.php?p=tambahmaterial-m2" class=" btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Stok</a><br>-->
                                                    <center>
                                                        <!--                                                    <a href="index.php?p=terima_barang_dari_bendahara_new&id_sementara=-->
                                                        <?php //echo $row['id_sementara'];?><!--"-->
                                                        <!--                                                           class="btn btn-info">-->
                                                        <!--                                                        <i class="fa fa-envelope-open"></i> Terima Barang-->
                                                        <!--                                                    </a>-->

                                                        <!--penggunaan metode post terbaru lagi disini-->
                                                        <!--                                                    <form method="post" action="penerimaan_barang_dari_bendahara.php">-->
                                                        <form method="post"
                                                              action="penerimaan_barang_dari_bendahara_table.php">

                                                            <input class="hidden" type="text" name="unit"
                                                                   value="<?php echo $row['unit']; ?>">
                                                            <input class="hidden" type="text" name="user_id"
                                                                   value="<?php echo $row['user_id']; ?>">
                                                            <input class="hidden" type="text" name="kode_brg"
                                                                   value="<?php echo $row['kode_brg']; ?>">
                                                            <input class="hidden" type="text" name="jumlah"
                                                                   value="<?php echo $row['jumlah']; ?>">
                                                            <input class="hidden" type="text" name="id_sementara"
                                                                   value="<?php echo $row['id_sementara']; ?>">
                                                            <input class="hidden" type="text" name="tgl_permintaan"
                                                                   value="<?php echo $row['tgl_permintaan']; ?>">
                                                            <input class="hidden" type="text" name="bendahara_id"
                                                                   value="<?php echo $row['bendahara_id']; ?>">
                                                            <input onclick="return confirm('Sudah Terima Barang Bro?')"
                                                                   type="submit" id="penerimaan_barang_dari_bendahara"
                                                                   name="penerimaan_barang_dari_bendahara"
                                                                   style=""
                                                                   class="btn btn-warning col-sm-offset-3"
                                                                   value="Teerima Barang">
                                                        </form>
                                                    </center>

                                                </div>
                                            </td>

                                        <?php } else {
                                            if ($row['status_acc'] == 'Penerimaan Barang Dari Bendahara') { ?>
                                                <td style="color: red; font-weight: bold"> Barang Sudah Diterima</td>
                                            <?php } else { ?>
                                                <td style="color: red; font-weight: bold"> <?php if ($row['status_acc'] == "tidak_setuju") {
                                                        echo ucwords(str_replace("_", " ", $row['status_acc']));
                                                    } else {
                                                        echo ucwords($row['status_acc']);
                                                    } ?> </td>
                                            <?php }
                                            ?>
                                            <!--                                        <td style="color: red; font-weight: bold"> --><? //=$row['status_acc']?><!-- </td>-->
                                            <?php
                                        } ?>


                                    <?php } ?>

                                    </tr>

                                    <?php $no++;

                                endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";
                            } ?>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                $("#setujui").click(function () {
                                    document.getElementById('setujui').style.visibility = "hidden";
                                });
                            });

                            function showStuff(id, text, btn) {
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                document.getElementById(text).style.display = 'none';
                                // hide the link
                                btn.style.display = 'none';
                            }

                            function klikLah(id, btn) {
                                const buttons = document.getElementById('a_setujui');
                                const sembunyi = document.getElementById('sembunyi');
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                // document.getElementById(text).style.display = 'none';
                                // hide the link
                                // btn.style.display = 'none';
                                buttons.style.display = 'none';
                                sembunyi.style.visibility = "visible";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" !src="">
        hiddenTidakDisetujui = function (id) {
            $(this).css('visibility', 'hidden');
            alert(id);
        };
        kirimNote = function (id) {
            alert(id);
        };
    </script>

    <script>

        $(function () {
            $("#detil_history_permintaan").DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                    "sEmptyTable": "Tidak ada data di database"
                }
            });
        });
    </script>

</section>