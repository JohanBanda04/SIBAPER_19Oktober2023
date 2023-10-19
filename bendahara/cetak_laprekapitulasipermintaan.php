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
            margin-left: 13px;
        }

        .tabel2 th, .tabel2 td {
            padding: 5px 5px;
            border: 1px solid #000000;
        }

        div.kanan {
            width: 300px;
            float: right;
            margin-left: 210px;
            margin-top: -141px;
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
<!--            <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px"/></th>-->
<!--            <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KOTA JAKARTA <br>-->
<!--                        KELURAHAN JATINEGARA KAUM</b></font>-->
<!--                <br>Jl. TB. Badaruddin No. 1 RT.1/RW.5, Kel. Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur,-->
<!--                Daerah Khusus Ibukota Jakarta 13250 <br>Telp : (021) 4751119-->
<!--            </td>-->
            <th rowspan="3"><img src="../gambar/icon_pengayoman.jpeg" style="width:90px;height:100px" /></th>
            <td align="center" style="width: 520px;"><font style="font-size: 18px">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA  <br> <b>REPUBLIK INDONESIA</b>
                    <br><b>KANTOR WILAYAH NUSA TENGGARA BARAT</b></font>
                <br>Jalan Majapahit No. 44 Mataram Telepon : (0370) 7856244 Fax : 625341<br>Laman : ntb.kemenkumham.go.id , Email : kanwilntb@kemenkumham.go.id</td>


<!--            <th rowspan="3"><img src="../gambar/lobar_logo.png" style="width:90px;height:100px"/></th>-->
<!--            <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KABUPATEN LOBAR <br>-->
<!--                        RS. AWET MUDA NARMADA</b></font>-->
<!--                <br>Nyur Lembang, Kec. Narmada, Kabupaten Lombok Barat, Nusa Tenggara Bar. 83371 <br>Telp : (0370)-->
<!--                7561792-->
<!--            </td>-->
<!--            <th rowspan="3"><img src="../gambar/rsam_narmada.png" style="width:95px;height:95px" /></th>-->

        </tr>
    </table>
    <hr>
    <p align="center" style="font-weight: bold; font-size: 18px;"><u>BUKTI PENGELUARAN PERMINTAAN BARANG (BPP)</u></p>

    <div class="isi" style="margin: 0 auto;">
          Periode : <?= tanggal_indo($tanggala); ?> S/d <?= tanggal_indo($tanggalb); ?>
        <br><br>
        <table class="tabel2">
            <thead>
            <tr>
                <td style="text-align: center; "><b>No.</b></td>
                <td style="text-align: center; "><b>Tanggal Keluar</b></td>
                <td style="text-align: center; "><b>Nama </b></td>
                <td style="text-align: center; "><b>Subbidang </b></td>
                <td style="text-align: center; "><b>Kode Barang</b></td>
                <td style="text-align: center; "><b>Nama Barang</b></td>
                <td style="text-align: center; "><b>Satuan</b></td>
                <td style="text-align: center; "><b>Jumlah</b></td>
            </tr>
            </thead>
            <tbody>
            <?php

            $query_bk = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, 
unit, nama_brg, jumlah, satuan, tgl_keluar FROM pengeluaran 
INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg WHERE tgl_keluar 
BETWEEN '$tanggala' and '$tanggalb' ");

            $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' order by pengeluaran.tgl_keluar DESC");
            $i = 1;
            $total = 0;
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td style="text-align: center; width=10px; "><?php echo $i; ?></td>
                    <td style="text-align: center; width=70px; font-size: 12px;"><?php echo date('d/m/Y', strtotime($data['tgl_keluar'])); ?></td>
                    <td style="text-align: center; width=70px; font-size: 12px;"><?php echo $data['unit']; ?></td>

                    <?php
                        $query_get_subbidang_nama = mysqli_query($koneksi,"select * from subbidang where id_subbidang='$data[id_subbidang]'");
                        if($query_get_subbidang_nama){
                            $item = mysqli_fetch_assoc($query_get_subbidang_nama); ?>

                            <?php
                        } else {
                            echo "gagal get_subbidang_nama";
                        }
                    ?>
                    <td style="text-align: center; width=100px; font-size: 12px;"><?php echo $item['nama_subbidang']; ?></td>
                    <td style="text-align: center; width=70px; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>

                    <?php $nama_brg = strtolower($data['nama_brg'])?>
                    <td style="text-align: center; width=100px; font-size: 12px;"><?php echo ucwords($nama_brg," "); ?></td>

                    <?php $satuan_brg = strtolower($data['satuan'])?>
                    <td style="text-align: center; width=40px; font-size: 12px;"><?php echo ucwords($satuan_brg," "); ?></td>

                    <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
                </tr>
                <?php
                $i++;
                $total = $total + $data['jumlah'];
            }
            ?>
            </tbody>
        </table>
        <table class="tabel2">
            <tr>
                <td style="text-align: center; width=614px;"><b>Total Barang</b></td>


                <td style="text-align: center; width=34px;"><b><?= $total = $total; ?></b></td>
            </tr>
        </table>

    </div>

<!--    <div class="kiri">-->
<!--        <br>-->
<!--        <p>Diketahui :<br>Lurah</p>-->
<!--        <br>-->
<!--        <br>-->
<!--        <br>-->
<!--        <p><b><u>Darsito, S.Sos</u><br>NIK: 196606051986031015</b></p>-->
<!--    </div>-->
    <div class="kiri">
        <?php
            $query_get_bendahara_cetak_rekap = mysqli_query($koneksi,"select * from user where id_user='$_SESSION[user_id]'");
            if($query_get_bendahara_cetak_rekap){
                $it = mysqli_fetch_assoc($query_get_bendahara_cetak_rekap);
            } else {
                echo "gagal get_bendahara_cetak_rekap";
            }
        ?>
        <br>
        <p>Dicetak Oleh :<br><?php if($it['jabatan']=="Operator"){
            echo "Pengelola Persediaan Barang";
            } ?></p>
        <br>
        <br>
        <br>
        <p><b><u><?php echo $it['nama_lengkap'];?></u><br>NIK: <?php echo $it['nik'];?></b></p>
    </div>

    <div class="kanan">
        <?php
            $query_get_kasub_operator = mysqli_query($koneksi,"select * from user where jabatan='Kasub Operator'");
            $item = mysqli_fetch_assoc($query_get_kasub_operator);
        ?>
        <p>Disetujui Oleh :<br><?php if($item['jabatan']=="Kasub Operator"){
                echo "Kasub Pengelola";
            } ?> </p>
        <br>
        <br>
        <br>
        <p><b><u><?php echo $item['nama_lengkap'];?></u><br>NIK: <?php echo $item['nik'];?></b></p>
    </div>

    <!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
//  include '../assets/html2pdf/html2pdf.class.php';
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