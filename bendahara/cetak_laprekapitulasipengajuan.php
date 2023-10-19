<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start();
$id = isset($_GET['id']) ? $_GET['id'] : false;


$tanggala = $_POST['tanggala'];
$tanggalb = $_POST['tanggalb'];


?>
    <!-- Setting CSS bagian header/ kop -->
    <style type="text/css">
        table.page_header {
            width: 1020px;
            border: none;
            background-color: #DDDDFF;
            border-bottom: solid 1mm #AAAADD;
            padding: 2mm
        }

        table.page_footer {
            width: 1020px;
            border: none;
            background-color: #DDDDFF;
            border-top: solid 1mm #AAAADD;
            padding: 2mm
        }


    </style>
    <!-- Setting Margin header/ kop -->
    <!-- Setting CSS Tabel data yang akan ditampilkan -->
    <style type="text/css">
        .tabel2 {
            border-collapse: collapse;
            margin-left: 20px;
        }

        .tabel2 th, .tabel2 td {
            padding: 5px 5px;
            border: 1px solid #000;
        }

        div.tengah {
            position: absolute;
            bottom: 100px;
            right: 330px;

        }

        div.kanan {
            width: 300px;
            float: right;
            margin-left: 210px;
            margin-top: -235px;
        }

        div.kiri {
            width: 300px;
            float: left;
            margin-left: 20px;
            display: inline;
        }

    </style>
    <table>
        <tr>

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

        </tr>
    </table>
    <hr>
    <p align="center" style="font-weight: bold; font-size: 18px;"><u>REKAPITULASI BUKTI PENGAJUAN PERMINTAAN BARANG (BPP)</u></p>

    <div class="isi" style="margin: 0 auto;">
        Periodee :<?= tanggal_indo($tanggala); ?> S/d <?= tanggal_indo($tanggalb); ?>
        <br>
        <br>
        <table class="tabel2">
            <thead>
            <tr>
                <td style="text-align: center; width=10px; font-size: 12px;"><b>No.</b></td>
                <td style="text-align: center; width=70px; font-size: 12px;"><b>Kode Barang</b></td>
                <td style="text-align: center; width=50px; font-size: 12px;"><b>Tgl Pengajuan</b></td>
                <td style="text-align: center; width=105px;font-size: 12px;"><b>Nama Barang</b></td>
                <td style="text-align: center; width=50px; font-size: 12px;"><b>Satuan</b></td>
                <td style="text-align: center; width=30px; font-size: 12px;"><b>Harga Barang</b></td>
                <td style="text-align: center; width=60px; font-size: 12px;"><b>Jumlah </b></td>
                <td style="text-align: center; width=70px; font-size: 12px;"><b>Total</b></td>
            </tr>
            </thead>
            <tbody>
            <?php
            include "../fungsi/koneksi.php";


            // hati hati tertipu dengan query ORDER BY
            $query_backup_1 = mysqli_query($koneksi, "SELECT  pengajuan.tgl_pengajuan, 
pengajuan.id_pengajuan, pengajuan.unit, pengajuan.kode_brg, pengajuan.jumlah, pengajuan.hargabarang, 
pengajuan.total, pengajuan.status, stokbarang.nama_brg, stokbarang.satuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg 
WHERE status=1 ORDER BY tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb'");

            $query_backup_2 = mysqli_query($koneksi, "SELECT  pengajuan.tgl_pengajuan, 
pengajuan.id_pengajuan, pengajuan.unit, pengajuan.kode_brg, pengajuan.jumlah, pengajuan.hargabarang, 
pengajuan.total, pengajuan.status, stokbarang.nama_brg, stokbarang.satuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg 
WHERE status=1 and tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb'");

            $query_backup_3 = mysqli_query($koneksi, "SELECT  pengajuan.tgl_pengajuan, 
pengajuan.id_pengajuan, pengajuan.unit, pengajuan.kode_brg, pengajuan.jumlah, pengajuan.hargabarang, 
pengajuan.total, pengajuan.status, stokbarang.nama_brg, stokbarang.satuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg 
WHERE status='1' and tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb' order by tgl_pengajuan desc");

            $query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, 
pengajuan.jumlah,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, 
tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE tgl_pengajuan BETWEEN '$tanggala' and '$tanggalb' order by tgl_pengajuan desc");


            $i = 1;
            $tot_barang = 0;
            $tot_harga = 0;
            while ($data = mysqli_fetch_array($query)) {
                ?>

                <tr>
                    <td style="text-align: center; font-size: 12px;"><?php echo $i; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo tanggal_indo($data['tgl_pengajuan']); ?></td>
                    <td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['hargabarang']);  ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
                    <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['total']); ?></td>

                </tr>
                <?php
                $i++;
                $tot_barang += $data['jumlah'];
                $tot_harga += $data['total'];
            }

            ?>
            <tr>
                <?php

                $query2 = mysqli_query($koneksi, "SELECT SUM(jumlah), SUM(hargabarang), SUM(total) FROM pengajuan WHERE 
status=1 and tgl_pengajuan BETWEEN '$tanggala' AND '$tanggalb' order by tgl_pengajuan");
                $data2 = mysqli_fetch_assoc($query2);

                ?>
                <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
                <td style="border-right-color: white; text-align: center; font-size: 12px;"><b>Total</b></td>
                <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
                <td style="border-right-color: white; text-align: left; font-size: 12px;"></td>
                <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
                <td style="text-align: center; font-size: 12px;"></td>
                <td style="text-align: center; font-size: 12px;"><b><?= $tot_barang; ?></b></td>
                <td style="text-align: center; font-size: 12px;"><b>Rp.<?= number_format($tot_harga); ?></b></td>

            </tr>
            <?php
            ?>
            </tbody>
        </table>


    </div>

    <?php
        $query_get_nama_operator_cetak = mysqli_query($koneksi,"select * from user where 
subbidang_id=(select user.subbidang_id from (user inner join subbidang on user.subbidang_id=subbidang.id_subbidang)
where id_user='$_SESSION[user_id]') and username='$_SESSION[username]'");

        while($dt = mysqli_fetch_array($query_get_nama_operator_cetak)){
            ?>
            <div class="kiri">
                <p></p>
                <p>Dicetak Oleh :<br><?php if($dt['jabatan']=="Operator"){
                        echo "Pengelola Persediaan Barang";
                    } ?> </p>
                <p></p>
                <p></p>
<!--                <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>-->
                <b><p><u><?php echo $dt['nama_lengkap'];?></u><br><?php echo "NIP : ".$dt['nik'];?></p></b>
                <br>
                <br>
                <br>
            </div>
            <?php
        }
    ?>


    <!--metode penggunaan subquery-->
    <?php
        $query_get_nama_kasub_operator = mysqli_query($koneksi,"select * from user where 
subbidang_id=(select user.subbidang_id from 
(user inner join subbidang on user.subbidang_id=subbidang.id_subbidang)
where id_user='$_SESSION[user_id]') and jabatan='Kasub Operator'");

        while($dt = mysqli_fetch_array($query_get_nama_kasub_operator)){ ?>

            <div class="kanan">
                <p></p>
                <p>Disetujui Oleh :<br><?php if($dt['jabatan']=="Kasub Operator"){
                    echo "Kasub Pengelola";
                    } ?> </p>
                <p></p>
                <p></p>
<!--                <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>-->
                <b><p><u><?php echo $dt['nama_lengkap'];?></u><br><?php echo "NIP : ".$dt['nik']?></p></b>
                <br>
                <br>
                <br>

            </div>
        <?php
        }
    ?>


    <!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
include '../assets/html2pdf_backup/html2pdf.class.php';
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>