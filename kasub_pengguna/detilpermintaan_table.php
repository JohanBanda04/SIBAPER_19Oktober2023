<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

//echo $_SESSION['subbidang_id'];die;
$array_konfirmasi_pemohon = array();

$array_pengajuan_kasub = array();
$array_kasub_tidak_setuju = array();
$array_kasub_setuju = array();
$tgl_sekarang = date('Y-m-d');
if (isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])) {
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    if(isset($_GET['kode_brg_lengkap'])){
        if($_GET['kode_brg_lengkap']!=""){
            echo "<br> get kode barang DISET dan isinya = ".$_GET['kode_brg_lengkap']."<br>";


            $query = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' and sementara.kode_brg='$_GET[kode_brg_lengkap]'
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub','tidak_setuju','setuju')");
        } else if($_GET['kode_brg_lengkap']==""){
            //echo "<br> get kode barang DISET dan tidak ada isisnya = ".$_GET['kode_brg_lengkap']."<br>";

            $query = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub','tidak_setuju','setuju')");
        }
    } else if(!isset($_GET['kode_brg_lengkap'])){
        //echo "<br> get kode barang TIDAK DISET dan tidak ada isisnya <br>";
        $query = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub','tidak_setuju','setuju')");
    }

//    echo $user_id.'-';
//    echo $unit.'-';
//    echo $tgl_permintaan;

//    $query = mysqli_query($koneksi,"select * from sementara");
}

$query_get_email_tujuan_bk1 = mysqli_query($koneksi, "SELECT 
user.email,user.nama_lengkap ,sementara.id_subbidang,
sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) inner join user on 
sementara.user_id=user.id_user)
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' limit 1");

$query_get_email_tujuan = mysqli_query($koneksi, "select user.id_user, user.username, user.nama_lengkap,
user.email,user.subbidang_id, user.jabatan_detail from user where subbidang_id='13' 
and jabatan='Kasub Operator'");

$dt_get_email_tujuan = mysqli_fetch_assoc($query_get_email_tujuan);
$dt_email_tujuan = $dt_get_email_tujuan['email'];
$dt_nama_lengkap_tujuan = $dt_get_email_tujuan['nama_lengkap'];
$dt_jabatan_detail_tujuan = $dt_get_email_tujuan['jabatan_detail'];
$dt_subbidang_id_tujuan = $dt_get_email_tujuan['subbidang_id'];



$query_get_nama_subbidang_tujuan = mysqli_query($koneksi,"SELECT * from subbidang where id_subbidang='$dt_subbidang_id_tujuan'");
$dt_get_nama_subbidang_tujuan = mysqli_fetch_assoc($query_get_nama_subbidang_tujuan);
$dt_nama_subbidang_tujuan = $dt_get_nama_subbidang_tujuan['nama_subbidang'];

/*cuky*/
//echo $dt_email_tujuan."<br>";
//echo $dt_nama_lengkap_tujuan."<br>";
//echo $dt_subbidang_id_tujuan."<br>";
//echo $dt_nama_subbidang_tujuan."<br>";
//echo $dt_jabatan_detail_tujuan; die;


$query_get_email_pengirim = mysqli_query($koneksi,"select user.id_user, user.username, user.nama_lengkap,
user.email, user.subbidang_id, user.jabatan_detail from user where subbidang_id='$_SESSION[subbidang_id]' 
and jabatan='$_SESSION[jabatan]'");

$dt_get_email_pengirim = mysqli_fetch_assoc($query_get_email_pengirim);
$dt_email_pengirim = $dt_get_email_pengirim['email'];
$dt_nama_lengkap_pengirim = $dt_get_email_pengirim['nama_lengkap'];
$dt_jabatan_detail_pengirim = $dt_get_email_pengirim['jabatan_detail'];
$dt_subbidang_id_pengirim = $dt_get_email_pengirim['subbidang_id'];



$query_get_nama_subbidang = mysqli_query($koneksi,"SELECT * from subbidang where id_subbidang='$dt_subbidang_id_pengirim'");
$dt_get_nama_subbidang_pengirim = mysqli_fetch_assoc($query_get_nama_subbidang);
$dt_nama_subbidang_pengirim = $dt_get_nama_subbidang_pengirim['nama_subbidang'];

/*cukys*/
//echo $dt_email_pengirim."<br>";
//echo $dt_nama_lengkap_pengirim."<br>";
//echo $dt_subbidang_id_pengirim."<br>";
//echo $dt_nama_subbidang_pengirim."<br>";
//echo $dt_jabatan_detail_pengirim; die;


$query_bk = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' AND user_id='$user_id' AND 
        status_acc='Pengajuan Kasub'");

$query_old_v1 = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub','tidak_setuju','setuju')");

$query_cek_pengajuan_kasub = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub')");

$query_cek_tidak_setuju_kasub = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('tidak_setuju')");

$query_cek_setuju_kasub = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('setuju')");

//$query_get_email_pemohon_bk1 = mysqli_query($koneksi, "select * from user where id_user='$user_id'");
//$dt_get_email_pemohon_bk2 = mysqli_fetch_assoc($query_get_email_pemohon);

$query_get_email_kasub_operator = mysqli_query($koneksi, "				select user.id_user, user.username,
				user.nama_lengkap,user.email from user where subbidang_id='13' 
				and jabatan='Kasub Operator'");
$dt_get_email_kasub_operator = mysqli_fetch_assoc($query_get_email_kasub_operator);


$dt_email_tujuan = $dt_get_email_kasub_operator ['email'];
$dt_nama_lengkap_tujuan = $dt_get_email_kasub_operator ['nama_lengkap'];
if(mysqli_num_rows($query_cek_pengajuan_kasub) > 0){
    //echo "ada data pengajuan kasub <br>";
    while($dt_cek_pengajuan_kasub = mysqli_fetch_array($query_cek_pengajuan_kasub)){
        array_push($array_pengajuan_kasub,(object)[
                "status_sekarang"=>"Ini Pengajuan Kasub",
        ]);
    }
} else if(mysqli_num_rows($query_cek_pengajuan_kasub) <= 0){
    //echo "tidak ada data pengajuan kasub <br>";
    while($dt_cek_pengajuan_kasub = mysqli_fetch_array($query_cek_pengajuan_kasub)){
        array_push($array_pengajuan_kasub,(object)[
            "status_sekarang"=>"Ini Bukan Pengajuan Kasub",
        ]);
    }
}

//echo count($array_pengajuan_kasub)." ini size pengajuan kasub<br>";
// metode kirim email ribet
if(count($array_pengajuan_kasub) == 0){
    //echo "kirim email setelah dari status Pengajuan Kasub ";
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
    $mail->SetFrom("senderforemail340@gmail.com", "Permintaan Barang ".$dt_jabatan_detail_pengirim." ".$dt_nama_subbidang_pengirim); //set email pengirim
    $mail->Subject = "Permintaan Barang ".$dt_jabatan_detail_pengirim." ".$dt_nama_subbidang_pengirim; //subyek email
    $mail->AddAddress($dt_email_tujuan);  // email tujuan
    $mail->MsgHTML("Halo, ".$dt_jabatan_detail_tujuan." ".$dt_nama_subbidang_tujuan." terdapat Permintaan Barang dari "
        .$dt_jabatan_detail_pengirim." ".$dt_nama_subbidang_pengirim.
        ", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda");
    $mail->Send();
} else {
    //echo "jangan kirim email dulu dari status Pengajuan Kasub";
}





?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Konfirmasi PPermintaan <?php echo ucwords($unit); ?></h3><br>
                    <center>
                        <span style="font-weight: bold; font-size: 25px"><?php echo tanggal_indo($tgl_permintaan); ?></span>
                    </center>
                </div>
                <div class="box-body">
                    <!--/index.php?p=datapermintaan_table&pas=permintaanbarang-->
                    <a href="index.php?p=datapermintaan_table&pas=permintaanbarang" style="margin:10px;"
                       class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center" id="detilpermintaan_table_kasub_pengguna">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Ids Sementara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>


                            <tbody>

                            <!--                            <tr>-->
                            <?php
                            $array_status_acc_temporary = array();
                            ?>

                            <?php
                            $no = 1;


                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <!--                                                                    <tr>-->
                                    <?php
                                    if ($row['status_acc'] != null) {
                                        ?>
                                        <tr>
                                        <!--jika belum disetujui-->
                                        <td> <?= $no; ?> </td>
                                        <td> <?= $row['id_sementara']; ?> </td>
                                        <td> <?= $row['kode_brg']; ?> </td>
                                        <td> <?= $row['nama_brg']; ?> </td>
                                        <td> <?= $row['satuan']; ?> </td>
                                        <td> <?= $row['jumlah']; ?> </td>
                                        <td> <?= $row['status_acc'] ?> </td>

                                        <td>

                                            <?php


                                            $_SESSION['acc_kasub_temp'] = $row['acc_kasub'];

                                            ?>


                                            <?php
                                            if ($row['status_acc'] != 'Pengajuan Kasub') { ?>
                                                <a id="a_setujui_fake" class=""
                                                   href="#">
                                        <span id="span_setujui_fake" data-placement='top' data-toggle='tooltip'
                                              title='Setujui'>
                                            <button id="button_setujui_fake"
                                                    class="btn btn-success disabled">
                                                Setujui
                                            </button>

                                        </span>
                                                </a>

                                                <a id="a_tidaksetuju_fake"
                                                   href="#">
                                        <span id="span_tidaksetujui_fake" data-placement='top' data-toggle='tooltip'
                                              title='Tidak Setuju'>
                                            <button id="tidaksetuju_fake"
                                                    class="btn btn-danger disabled">
                                                Tidak Setuju
                                            </button>

                                        </span>
                                                </a>
                                            <?php } else if ($row['status_acc'] == 'Pengajuan Kasub') { ?>
                                                <!--                                                <a id="a_setujui" class=""-->
                                                <!--                                                   href="setuju.php?id_sementara=--><?//= $row['id_sementara']; ?><!--&unit=--><?//= $unit; ?><!--&tgl=--><?//= $tgl; ?><!--&status_acc=setuju">-->

                                                <a id="a_setujui" class=""
                                                   href="setuju_table.php?id_sementara=<?php echo $row['id_sementara']; ?>&user_id=<?php echo $row['user_id'] ?>&unit=<?php echo $row['unit']; ?>&tgl_permintaan=<?php echo $row['tgl_permintaan']; ?>">
                                        <span id="span_setujui" data-placement='top' data-toggle='tooltip'
                                              title='Setujui'>
                                            <button id="button_setujui"
                                                    class="btn btn-success  ">
                                                Setujuiiz
                                            </button>

                                        </span>
                                                </a>


                                                <a id="a_tidak_setujui" class=""
                                                   href="index.php?p=alasan_tidak_setuju_table&id_sementara=<?php echo $row['id_sementara']; ?>">
                                        <span id="alasan_tidak_setuju" data-placement='top' data-toggle='tooltip'
                                              title='Alasan Tidak Setuju'>
                                            <!--tr nya dibenahi tata letak nya-->
                                            <button id="alasan_tidak_setuju"
                                                    class="btn btn-danger  ">
                                                Tidak Setuju
                                            </button>

                                        </span>
                                                </a>

                                                <!--                                                <a id="a_tidaksetuju[--><?//= $row['id_sementara']; ?><!--]"-->
                                                <!--                                                   href="tidaksetuju.php?id_sementara=--><?//= $row['id_sementara']; ?><!--&unit=--><?//= $unit; ?><!--&tgl=--><?//= $tgl; ?><!--&status_acc=tidak_setuju">-->
                                                <!--                                        <span data-placement='top' data-toggle='tooltip' title='Tidak Setuju'>-->
                                                <!--                                            <button id="tidaksetuju"-->
                                                <!--                                                    class="btn btn-danger  ">-->
                                                <!--                                                Tidak Setuju-->
                                                <!--                                            </button>-->
                                                <!---->
                                                <!--                                        </span>-->
                                                <!--                                                </a>-->
                                                <div class="alasan hidden">
                                                    <input type="text" placeholder="Alasan"
                                                           id="alasan_tidak_setuju[<?= $row['id_sementara'] ?>]"
                                                           name="alasan_tidak_setuju[]">
                                                    <button id="btn_alasan[<?= $row['id_sementara'] ?>]"
                                                            onclick="kirimNote(<?= $row['id_sementara'] ?>)">Update
                                                    </button>
                                                </div>
                                            <?php }
                                            ?>


                                            <?php
                                            $id_sementara = "";
                                            $tgl_permintaan = "";
                                            ?>


                                        </td>

                                    <?php }
                                    ?>

                                    <?php
                                    //disana

                                    ?>

                                    </tr>

                                    <?php $no++;

                                }
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
</section>

<script>

    $(function () {
        $("#detilpermintaan_table_kasub_pengguna").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>

