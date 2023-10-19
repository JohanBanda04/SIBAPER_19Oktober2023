<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start();
$id  = isset($_GET['id']) ? $_GET['id'] : false;


$bendahara = $_GET['bendahara'];
$bendahara_id = $_GET['bendahara_id'];
$unit = $_GET['unit'];
$instansi = $_GET['instansi'];
$tgl= $_GET['tgl'];



?>
    <!-- Setting CSS bagian header/ kop -->
    <style type="text/css">
        table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
        table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}


    </style>
    <!-- Setting Margin header/ kop -->
    <!-- Setting CSS Tabel data yang akan ditampilkan -->
    <style type="text/css">
        .tabel2 {
            border-collapse: collapse;
            margin-left: 80px;
        }
        .tabel2 th, .tabel2 td {
            padding: 5px 5px;
            border: 1px solid #000;
        }
        .tabelatas{

            margin-left: 80px;
        }
        p{

            margin-left: 80px;
        }

        div.kanan {
            width:300px;
            float:right;
            margin-left:150px;
            margin-top:-236px;
        }

        div.kiri {
            width:300px;
            float:left;
            margin-left:-10px;
            display:inline;
        }
        div.tengah {
            width:300px;
            float:left;
            margin-left:195px;
            margin-top:2px;
            display:inline;
        }
    </style>
    <table>
        <tr>

<!--            <th rowspan="3"><img src="../gambar/lobar_logo.png" style="width:90px;height:100px" /></th>-->
            <th rowspan="3"><img src="../gambar/icon_pengayoman.jpeg" style="width:90px;height:100px" /></th>
            <td align="center" style="width: 550px; ">
                <font style="font-size: 18px">
                    KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA
                    <br>
                    REPUBLIK INDONESIA
                    <br>
                    KANTOR WILAYAH NUSA TENGGARA BARAT
                    <br>
                    <b>KANTOR IMIGRASI KELAS II TPI SUMBAWA BESAR </b>
                </font>
                <br>
                Jalan Garuda No. 131, Sumbawa Besar 84351 Telepon: (0370) 626642
                <br>
                Laman: kanimsumbawa.kemenkumham.go.id ; Surel: kanimsumbawa@kemenkumham.go.id
            </td>
<!--            <th rowspan="3"><img src="../gambar/rsam_narmada.png" style="width:95px;height:95px" /></th>-->

        </tr>
    </table>
    <hr>
    <div>
        <span style="margin-left: 190px;font-size: 18px; font-weight: bold">
            <u>BUKTI PERMINTAAN BARANG (BPP)</u>
<!--            --><?php //echo $_SESSION['username'];?>
<!--            --><?php //echo $bendahara;?><!--::-->
<!--            --><?php //echo $bendahara_id;?>
            <span style="font-weight: bold"><?php ;?></span>
        </span>
    </div>
    <br>

    <div class="isi" style="margin: 0 auto;">

        <table class="tabelatas">
            <tr>
<!--                <td style="text-align: left; width=100px;  "><b>Instansi </b></td>-->

                <?php

                $query = mysqli_query($koneksi,"select * from (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc='Selesai' 
and permintaan.status='1'");


                //metode mendapatkan nama lengkap user lagi
                $query_pengguna = mysqli_query($koneksi,"select * from (user inner join subbidang 
on user.subbidang_id=subbidang.id_subbidang) 
where username='$_SESSION[username]' and id_user='$_SESSION[user_id]'");
                while($item_pengguna = mysqli_fetch_array($query_pengguna)){
                    $nama_lengkap_pengguna = $item_pengguna['nama_lengkap'];
                    $nama_subbidang = $item_pengguna['nama_subbidang'];
                }
                ?>
                <td style="text-align: left; width=100px;  "><b>Penggunna </b></td>
                <td style="text-align: left; "><b>: <?= $nama_lengkap_pengguna; ?></b></td>
            </tr>
            <tr>
                <td style="text-align: left; width=100px;  "><b>Subbidang </b></td>
                <td style="text-align: left; "><b>: <?=  $nama_subbidang; ?></b></td>
            </tr>
            <tr>
                <td style="text-align: left; width=100px;  "><b>Pada tanggal </b></td>
                <td style="text-align: left; "><b>: <?=  tanggal_indo($tgl); ?></b></td>
            </tr>

        </table>
        <table class="tabel2">
            <thead>
            <tr>
                <td style="text-align: center; width=10px; "><b>No.</b></td>
                <td style="text-align: center; width=100px;"><b>Kode Barangg</b></td>
                <td style="text-align: center; width=150px;"><b>Nama Barang</b></td>
                <td style="text-align: center; width=80px;"><b>Satuan</b></td>
                <td style="text-align: center; width=80px;"><b>Jumlah</b></td>
            </tr>
            </thead>
            <tbody>
            <?php

//            LANJUT CEK DISINI MASIH BELUM BERES, MASIH ADA TAMPILAN DATA LAPORAN YANG KOSONGAN
//            KETIKA MELAKUKAN FILTER BERDASARKAN JENIS BARANG, halaman yg berkaitan sebelumnya
//            cetak_bpp_baru_table_v2.php (CLEAR SUDAH, karena $query_old_v1 di disfungsikan)
            if(isset($_GET['kode_brg_lengkap'])){
                if($_GET['kode_brg_lengkap']!=""){
//                    echo "kode_brg_lengkap terset serta ADA ISI : ".$_GET['kode_brg_lengkap'];

                    $queries = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.kode_brg='$_GET[kode_brg_lengkap]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
and sementara.bendahara_id='$bendahara_id' and permintaan.status='1'");

                } else if($_GET['kode_brg_lengkap']==""){
//                    echo "kode_brg_lengkap TIDAK terset serta TIDAK ADA ISI : ".$_GET['kode_brg_lengkap'];
                    $queries = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
and sementara.bendahara_id='$bendahara_id' and permintaan.status='1'");
                }
            } else if (!isset($_GET['kode_brg_lengkap'])){
//                echo "kode_brg_lengkap TIDAK terset serta TIDAK ADA ISI : ";

                $queries = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
and sementara.bendahara_id='$bendahara_id' and permintaan.status='1'");
            }

            $queries_bk = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
and bendahara_id='$bendahara_id' and permintaan.status='1'");

            $queries_old_1 = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
and sementara.bendahara_id='$bendahara_id' and permintaan.status='1'");
            $i   = 1;
            $total = 0;
            while($data=mysqli_fetch_array($queries))
            {
                ?>
                <tr>
                    <td style="text-align: center; font-size: 12px;"><?php echo $i; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
                    <td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
                </tr>
                <?php
                $i++;
                $total=$total+$data['jumlah'];
            }
            ?>
            <tr>
                <!--contoh yg diatasnya agar footer total sama rata dan sama panjang-->
                <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
                <td style="border-right-color: white; text-align: center; font-size: 12px; ">
                    <b>Total Barang</b>
                </td>
                <td style="border-right-color: white; text-align: left; font-size: 12px;"></td>
                <td style="text-align: center; font-size: 12px;"></td>
                <td style="text-align: center; font-size: 12px;"><?= $total = $total; ?></td>
            </tr>
            <?php
            ?>
            </tbody>

        </table>



    </div>

<?php

$query2_old = mysqli_query($koneksi, "SELECT jabatan,username,nik,subbidang_id FROM user WHERE username='$unit' ");
$query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$unit' ");
if ($query2){
    $data = mysqli_fetch_assoc($query2);

} else {
    echo 'gagal';
}
?>

    <div class="kiri">
        <?php
            $username = $data['username'];
            $sql = mysqli_query($koneksi,"select * from `user` where username='$username'");
            while($item = mysqli_fetch_array($sql)){
                //subbid_id
                $subbid_id = $item['subbidang_id'];
                $jabatan = $item['jabatan'];

                $q_sql = mysqli_query($koneksi,"select * from `user` where subbidang_id='$subbid_id' and jabatan='Kasub Pengguna'");
                while($itm = mysqli_fetch_array($q_sql)){
                    $nama_kasub_pengguna = $itm['nama_lengkap'];
                    $nik_kasub_pengguna = $itm['nik'];
                    $id_subbidang = $itm['subbidang_id'];

                    //echo $id_subbidang;

                    $get_subbid_sql = mysqli_query($koneksi,"select * from `subbidang` where id_subbidang='$id_subbidang' ");
                    while($item = mysqli_fetch_array($get_subbid_sql)){
                        $nama_subbid = $item['nama_subbidang'];
                    }

                }
                //die;
            }
        ?>

        <p> </p>
        <p>Diminta Oleh :<br>Kasub <?= $nama_subbid; ?> </p>
        <p></p>
        <p></p>
        <b><p><u><?php echo $nama_kasub_pengguna; ?></u><br>NIP: <?= $nik_kasub_pengguna; ?></p></b>
        <br>
        <br>
        <br>
    </div>

    <?php
        $dts_old = mysqli_query($koneksi, "SELECT permintaan.kode_brg, permintaan.operator_id, unit, nama_brg, 
jumlah, satuan, tgl_permintaan FROM permintaan 
INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg  
WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' ");

        $dts_bk = mysqli_query($koneksi, "select * from ((sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc='Selesai'
and permintaan.status='1'");

        $dts_old_3 = mysqli_query($koneksi, "select * from ((sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
 and bendahara_id='$bendahara_id' and permintaan.status='1'");

        $query_dts = mysqli_query($koneksi, "select *,sementara.bendahara_id as bendahara_id_pemberi  from ((sementara inner join permintaan 
on sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where 
sementara.tgl_permintaan='$tgl' and sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc in ('Selesai','Penerimaan Barang Dari Bendahara') 
 and sementara.bendahara_id='$bendahara_id' and permintaan.status='1'");

    $operator_id = "";

    while($data = mysqli_fetch_array($query_dts)){
        $operator_id = $data['bendahara_id_pemberi'];
    }



    ?>

    <div class="kanan">
        <p></p>
        <?php $q = mysqli_query($koneksi,"select * from user where id_user='$operator_id'");


        $row = mysqli_fetch_assoc($q);
        $operator_name = $row['nama_lengkap'];


        ?>

        <?php
        $get_jabatan_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
        $jabatan = mysqli_fetch_assoc($get_jabatan_kaur)['jabatan'];

        ?>
        <p>Dikeluarkan Oleh :<br><?php echo $jabatan; ?> </p>
        <p></p>
        <p> </p>
<!--        <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>-->
        <b><p><u><span >
                       <?php
                       /*cetak nama lengkap kaur*/
                       $get_nama_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
                       $nama_lengkap_kaur = mysqli_fetch_assoc($get_nama_kaur)['nama_lengkap'];
                       echo $nama_lengkap_kaur;
                       ?>
                    </span>
                </u>
                <br>
                <?php
                /*cetak nik kaur*/
                $get_nik_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
                $nik_kaur = mysqli_fetch_assoc($get_nik_kaur)['nik'];
                echo "NIPs : ".$nik_kaur;
                ?>
            </p>
        </b>
        <br>
        <br>
        <br>

    </div>

    <div class="tengah">
        <p></p>
<!--        <p>Disetujui Oleh :<br>Lurah </p>-->
        <?php
        include "../fungsi/koneksi.php";
            $query_get_users = mysqli_query($koneksi,"select * from user where jabatan='Kasub Operator'");

            while ($dt_kasub_operator = mysqli_fetch_array($query_get_users)){
                $nama_jabatan = $dt_kasub_operator['jabatan'];
                $nama_kasub_operator = $dt_kasub_operator['nama_lengkap'];
                $nik_kasub_operator = $dt_kasub_operator['nik'];
            }
        ?>
        <p>Disetujui Oleh :<br><?php if($nama_jabatan=="Kasub Operator"){
            echo "Kasubag Tata Usaha";
            } ?> </p>
        <p></p>
        <p> </p>
<!--        <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>-->
        <br>
        <b><p><u><?php echo $nama_kasub_operator; ?> </u><br>NIP: <?php echo $nik_kasub_operator; ?></p></b>
        <br>
        <br>
        <br>

    </div>
    <!-- Memanggil fungsi bawaan HTML2PDF untuk cetak-->
<?php
$content = ob_get_clean();
include '../assets/html2pdf_backup/html2pdf.class.php';
//include '../assets/html2pdf/Html2Pdf.php';
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>