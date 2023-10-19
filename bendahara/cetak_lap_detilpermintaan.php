<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start();
$id = isset($_GET['id']) ? $_GET['id'] : false;

$tanggala = $_POST['tanggala'];
$tanggalb = $_POST['tanggalb'];
$unit = $_POST['unit'];
$user_id = $_POST['user_id'];
$kode_brg_lengkap = $_POST['kode_brg_lengkap'];

//echo "kode_brg_lengkap = ".$kode_brg_lengkap."<br>";
$query_get_nama_lengkap = mysqli_query($koneksi,"select * from user where id_user='$user_id'");
while($it = mysqli_fetch_array($query_get_nama_lengkap) ){
    $nama_lengkap = $it['nama_lengkap'];
}

//echo $tanggala."::";
//echo $tanggalb."::";
//echo $unit."::";
//echo $user_id."::";


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
            margin-left: 10px;
        }

        .tabel2 th, .tabel2 td {
            padding: 5px 5px;
            border: 1px solid #000000;
        }

        .tabelatas {

            margin-left: 20px;
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
            <!--            <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px"/></th>-->
            <!--            <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KOTA JAKARTA <br>-->
            <!--                        KELURAHAN JATINEGARA KAUM</b></font>-->
            <!--                <br>Jl. TB. Badaruddin No. 1 RT.1/RW.5, Kel. Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur,-->
            <!--                Daerah Khusus Ibukota Jakarta 13250 <br>Telp : (021) 4751119-->
            <!--            </td>-->

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


            <!--            <th rowspan="3"><img src="../gambar/lobar_logo.png" style="width:90px;height:100px"/></th>-->
            <!--            <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KABUPATEN LOBAR <br>-->
            <!--                        RS. AWET MUDA NARMADA</b></font>-->
            <!--                <br>Nyur Lembang, Kec. Narmada, Kabupaten Lombok Barat, Nusa Tenggara Bar. 83371 <br>Telp : (0370)-->
            <!--                7561792-->
            <!--            </td>-->
            <!--            <th rowspan="3"><img src="../gambar/rsam_narmada.png" style="width:95px;height:95px"/></th>-->

        </tr>
    </table>
    <hr>
    <p align="center" style="font-weight: bold; font-size: 18px;"><u>BUKTI PENGELUARAN PERMINTAAN BARANG (BPP)</u></p>

    <div class="isi" style="margin: 0 auto;">

        <?php

        $query2 = mysqli_query($koneksi, "SELECT jabatan FROM user WHERE username='$unit' ");
        if ($query2) {
            $data = mysqli_fetch_assoc($query2);

        } else {
            echo 'gagal';
        }

        ?>
        <table class="tabelatas">
            <tr>
                <td style="text-align: left; width=80px;  "><b>Periode </b></td>
                <td style="text-align: left; "><b>: <?= tanggal_indo($tanggala); ?> -
                        S/d <?= tanggal_indo($tanggalb); ?></b></td>
            </tr>
            <tr>
                <td style="text-align: left; width=80px;  "><b>Penggunaa </b></td>
                <?php
                //metode mendapatkan nama lengkap user
                    $query_get_user_bk = mysqli_query($koneksi,"select * from user where id_user='$user_id'");
                    $query_get_user = mysqli_query($koneksi,"select * from (user inner join 
subbidang on user.subbidang_id=subbidang.id_subbidang) where user.id_user='$user_id'");
                    if($query_get_user){
                        $itm = mysqli_fetch_assoc($query_get_user);
                    } else {
                        echo "gagal get user";
                    }
                ?>
                <td style="text-align: left; "><b>: <?= $itm['nama_lengkap'] ?></b></td>
            </tr>
            <tr>
                <td style="text-align: left; width=80px;  "><b>Subbag </b></td>
                <td style="text-align: left; "><b>: <?= $itm['nama_subbidang'] ?></b></td>
            </tr>

        </table>
        <br>
        <table class="tabel2">
            <thead>
            <tr>
                <td style="text-align: center; "><b>No.</b></td>
                <td style="text-align: center; "><b>Tanggal Keluar</b></td>
                <td style="text-align: center; "><b>Pengelola</b></td>

                <td style="text-align: center; "><b>Kode Barang</b></td>
                <td style="text-align: center; "><b>Nama Barang</b></td>
                <td style="text-align: center; "><b>Satuan</b></td>
                <td style="text-align: center; "><b>Jumlah</b></td>
            </tr>
            </thead>
            <tbody>
            <?php

            $query_bk = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, jumlah, 
satuan, tgl_keluar FROM pengeluaran INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg 
WHERE unit='$unit' AND tgl_keluar BETWEEN '$tanggala' and '$tanggalb' ");

            if(isset($_POST['kode_brg_lengkap'])){
               if($_POST['kode_brg_lengkap']!=""){
                   //cetak berdasarkan jenis barang BERHASIL SUKSES II
//                   echo "kode brg lengkap terset dan ada ISI YGY";
                   $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' and permintaan.unit='$unit' and permintaan.kode_brg='$_POST[kode_brg_lengkap]'
and permintaan.user_id='$user_id'");
               } else if($_POST['kode_brg_lengkap']==""){
//                   echo "kode brg lengkap terset dan TIDAK ADA ISI YGY";
                   $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' and permintaan.unit='$unit' 
and permintaan.user_id='$user_id'");
               }
            } else if(!isset($_POST['kode_brg_lengkap'])){
//                echo "kode brg lengkap TIDAK terset dan TIDAK ADA ISI YGY";
                $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' and permintaan.unit='$unit' 
and permintaan.user_id='$user_id'");
            }
            $query_old_v1 = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' and permintaan.unit='$unit'
and permintaan.user_id='$user_id'");

            $i = 1;
            $total = 0;
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td style="text-align: center; width=10px; "><?php echo $i; ?></td>
                    <td style="text-align: center; width=100px; font-size: 12px;"><?php echo date('d/m/Y', strtotime($data['tgl_keluar'])); ?></td>

                    <td style="text-align: center; width=60px; font-size: 12px;">
                        <?php
                        $get_nama_pengelola = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$data[bendahara_id]'");
                        echo mysqli_fetch_assoc($get_nama_pengelola)['nama_lengkap'];
                        //echo $data['bendahara_id'];

                        ?>
                    </td>
                    <td style="text-align: center; width=125px; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
                    <td style="text-align: left; width=150px; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
                    <td style="text-align: center; width=70px; font-size: 12px;"><?php echo $data['satuan']; ?></td>

                    <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
                </tr>
                <?php
                $i++;
                $total = $total + $data['jumlah'];
            }?>
            <tr>
                <td style="border-right-color:white; text-align: center; width=10px; "></td>
                <td style="border-right-color:white; text-align: center; width=100px; font-size: 12px;"><b>Total</b></td>

                <td style="border-right-color:white; text-align: center; width=60px; font-size: 12px;"></td>
                <td style="border-right-color:white; text-align: center; width=125px; font-size: 12px;"></td>
                <td style="border-right-color:white; text-align: left; width=150px; font-size: 12px;"></td>
                <td style="text-align: center; width=70px; font-size: 12px;"></td>

                <td style="text-align: center; font-size: 12px;"><?php echo $total; ?></td>
            </tr>
            <?php
            ?>
            </tbody>
        </table>



    </div>
<?php

$query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE jabatan='$unit' ");
if ($query2) {
    $data = mysqli_fetch_assoc($query2);

} else {
    echo 'gagal';
}
?>


    <div class="kiri">
        <?php
            $query_get_subbidang_id = mysqli_query($koneksi,"select * from user inner join subbidang 
on user.subbidang_id=subbidang.id_subbidang where id_user='$user_id'");
            if($query_get_subbidang_id){
                $result = mysqli_fetch_assoc($query_get_subbidang_id);

                $query_get_kasub = mysqli_query($koneksi,"select * from user where 
subbidang_id='$result[subbidang_id]' and jabatan='Kasub Pengguna'");

                if($query_get_kasub){
                    $res = mysqli_fetch_assoc($query_get_kasub);
                } else {
                    echo "gagal get_kasub";
                }
            } else {
                echo "gagal get_subbidang_id";
            }
        ?>
        <br>
        <p>Diminta Oleh :<br>Kasub <?php echo $result['nama_subbidang'];?></p>
        <br>
        <br>
        <br>
        <p><b><u><?php echo $res['nama_lengkap'];?></u><br><?php echo "NIP : ".$res['nik'];?></b></p>
    </div>

    <div class="kanan">
        <?php
        $query_get_kasub_operator = mysqli_query($koneksi,"select * from user where 
 jabatan='Kasub Operator'");
        if($query_get_kasub_operator){
            $dt_res = mysqli_fetch_assoc($query_get_kasub_operator);
        } else {
            echo "gagal get_kasub_operator";
        }

        $get_jabatan_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
        $jabatan = mysqli_fetch_assoc($get_jabatan_kaur)['jabatan'];

        ?>
        <p>Disetujui Oleh :<br>
            <?php
            /*cetak jabatan kaur*/
            echo $jabatan;
            ?> </p>
        <br>
        <br>
        <br>
        <p><b><u>
                    <?php
                    /*cetak nama lengkap kaur*/
                    $get_nama_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
                    $nama_lengkap_kaur = mysqli_fetch_assoc($get_nama_kaur)['nama_lengkap'];
                    echo $nama_lengkap_kaur;
                    ?>
                </u>
                <br>
                <?php
                /*cetak nik kaur*/
                $get_nik_kaur = mysqli_query($koneksi,"select * from `user` where jabatan='Kaur Umum'");
                $nik_kaur = mysqli_fetch_assoc($get_nik_kaur)['nik'];
                echo "NIP : ".$nik_kaur;
                ?>
            </b>
        </p>
    </div>

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