<?php  
include "../fungsi/koneksi.php";
$error = "";


?>

<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-18">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">FForm Pengaajuan Barang</h3>
                </div>
                <form method="post" id="tes"  action="simpan_pengajuansementara.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="nama_brg" class="a col-sm-3 control-label">Usernamez</label>
                            <div class="col-sm-3">
                                <input type="text" readonly value="<?= $_SESSION['username']; ?>" class="form-control" name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_brg" class=" col-sm-3 control-label">Jenis Barang</label>
                            <div class="col-sm-5">
                                <select id="jenis_brg" required="isikan dulu" class="form-control" name="id_jenis">
                                    <option value="">--Pilih Jenis Barang--</option>
                                    <?php  
                                    include "../fungsi/koneksi.php";
                                    $queryJenis = mysqli_query($koneksi, "select * from jenis_barang");
                                    if (mysqli_num_rows($queryJenis)) {
                                        while($row=mysqli_fetch_assoc($queryJenis)){
                                            if($row['jenis_brg']!="ALAT KEBERSIHAN" && $row['jenis_brg']!="PERLENGKAPAN LAINNYA"){ ?>
                                                <option value="<?= $row['id_jenis']; ?>"><?= $row['jenis_brg']; ?></option>
                                                <?php
                                            }
                                            ?>                                        
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  for="nama_brg" class="col-sm-3 control-label">Nama Barang</label>
                                <div class="col-sm-5">
                                    <select id="nama_brg" required="isikan dulu" class="form-control" name="kode_brg">
                                        <option value="">--Pilih Nama Barang--</option>                                                                  
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
<!--                                <label for="stok" class="col-sm-3 control-label">Stok Tersedia</label>-->
                                <label for="stok" class="col-sm-3 control-label">Stok Awal</label>
                                <div class="col-sm-2">
                                    <input id="stok" disabled value="----" type="text" class="form-control" name="stok">
                                </div>                                                        
                            </div>
                            <div class="form-group">
                                <label for="stok" class="col-sm-3 control-label">Stok Tersedia</label>
                                <div class="col-sm-2">
                                    <input id="stok_tersedia" disabled value="----" type="text" class="form-control" name="stok">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="satuan" class="col-sm-3 control-label">Satuan</label>
                                <div class="col-sm-4">
                                    <input id="satuan" class="form-control" name="satuan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hargabarang" class="col-sm-3 control-label">Harga Barang</label>
                                <div class="col-sm-2">
                                    <input id="hargabarang"  onkeyup="hitung();" type="text" class="form-control"
                                           name="hargabarang">
                                </div>                                          
                            </div>

                            <div class="form-group">
                                <label for="stok" class=" col-sm-3 control-label">Jumlahz</label>
                                <div class="col-sm-2">
                                    <input  id="jumlah" type="text" onkeyup="hitung();"  class="form-control" name="jumlah" required>
                                </div>
                                <span class="col-sm-5"> <?php echo $error; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="total" class="col-sm-3 control-label">Total</label>
                                <div class="col-sm-4">
                                    <input  id="total" type="text" onkeyup="hitung();"   class="form-control" name="total">
                                </div>
                            </div>

                            <div class="form-group" >
                                <input type="submit" id="simpanpengajuan"
                                       name="simpanpengajuan"
                                       class="btn btn-primary col-sm-offset-3 "
                                       value="Simpanz" >
                                &nbsp;
                                <input type="reset" class="btn btn-danger" value="Batal">                                                                              
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-sm- col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="text-center">DData Pengajuan Baru Stok Barang</h3>
                    </div>

                    <table class="table table-responsive">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th style="">
                                <center>Aksi</center>
                            </th>
                        </tr>
                        <tr>
                            <?php 
                            $sekarang  = date("Y-m-d");
                            $queryTampil_bk = mysqli_query($koneksi, "SELECT pengajuan_sementara.jumlah 
,pengajuan_sementara.satuan, pengajuan_sementara.hargabarang, pengajuan_sementara.total, 
pengajuan_sementara.unit, pengajuan_sementara.id_pengajuan_sementara, stokbarang.nama_brg 
FROM pengajuan_sementara INNER JOIN stokbarang 
ON pengajuan_sementara.kode_brg  = stokbarang.kode_brg 
WHERE tgl_pengajuan = '$sekarang' AND pengajuan_sementara.unit='$_SESSION[username]' "  );

                            $queryTampil_bk_2 = mysqli_query($koneksi, "SELECT pengajuan_sementara.jumlah 
,pengajuan_sementara.satuan, pengajuan_sementara.hargabarang, pengajuan_sementara.total, 
pengajuan_sementara.unit, pengajuan_sementara.id_pengajuan_sementara, stokbarang.nama_brg 
FROM pengajuan_sementara INNER JOIN stokbarang 
ON pengajuan_sementara.kode_brg  = stokbarang.kode_brg 
WHERE pengajuan_sementara.user_id='$_SESSION[user_id]' AND 
status_pengajuan = 'Permintaan Pengajuan Baru'"  );

                            $queryTampil = mysqli_query($koneksi, "SELECT * 
FROM pengajuan_sementara INNER JOIN stokbarang 
ON pengajuan_sementara.kode_brg  = stokbarang.kode_brg 
WHERE pengajuan_sementara.user_id='$_SESSION[user_id]' AND 
status_pengajuan = 'Permintaan Pengajuan Baru'"  );
                            $no = 1;
                            if(mysqli_num_rows($queryTampil) > 0) {
                                while($row = mysqli_fetch_assoc($queryTampil)):


                                   ?>
                                   <td><?php echo $no; ?></td>
                                   <td><?php echo $row['nama_brg']; ?></td>
                                   <td><?php echo $row['satuan'] ?></td>
                                   <td><?php echo $row['jumlah']; ?> </td>
                                   <td><?php echo $row['hargabarang']; ?> </td>
                                   <td><?php echo $row['total']; ?> </td>


                                   <td style="">
                                       <center style="">
                                           <a href="hapus_pengajuansementara.php?id=<?php echo $row['id_pengajuan_sementara']; ?>"
                                              class="btn btn-danger">
                                               Hapus
                                           </a>
                                           <form style="" action="ajukan_pengajuansementara.php" method="post">

                                               <input style="" class="hidden" type="text" name="id_pengajuan_sementara"
                                                      value="<?php echo $row['id_pengajuan_sementara']; ?>">
                                               <input style="" class="hidden" type="text" name="unit"
                                                      value="<?php echo $row['unit']; ?>">
                                               <input style="" class="hidden" type="text" name="kode_brg"
                                                      value="<?php echo $row['kode_brg']; ?>">
                                               <input style="" class="hidden" type="text" name="id_jenis"
                                                      value="<?php echo $row['id_jenis']; ?>">
                                               <input style="" class="hidden" type="text" name="jumlah"
                                                      value="<?php echo $row['jumlah']; ?>">
                                               <input style="" class="hidden" type="text" name="satuan"
                                                      value="<?php echo $row['satuan']; ?>">
                                               <input style="" class="hidden" type="text" name="hargabarang"
                                                      value="<?php echo $row['hargabarang']; ?>">
                                               <input style="" class="hidden" type="text" name="total"
                                                      value="<?php echo $row['total']; ?>">
                                               <input style="" class="hidden" type="text" name="tgl_pengajuan"
                                                      value="<?php echo $row['tgl_pengajuan']; ?>">


                                               <input onclick="return confirm('Lakukan Pengajuan?')"
                                                      type="submit" id="ajukan_pengajuansementara"
                                                      name="ajukan_pengajuansementara"
                                                      style="margin-left: 1px"
                                                      class="btn btn-info col-sm-offset-3"
                                                      value="Ajukanz">
                                           </form>
<!--                                           <a href="ajukan_pengajuansementara.php?id=--><?php //echo $row['id_pengajuan_sementara']; ?><!--"-->
<!--                                              class="btn btn-info">-->
<!--                                               Ajukan-->
<!--                                           </a>-->
                                       </center>

                                   </td>
                               </tr>
                               <?php $no++; endwhile; } else { echo "<tr><td>Tidak ada pengajuan barang </td></tr>"; } ?>

                               <tr>
                                  <?php
//                                  $query_bk = mysqli_query($koneksi, "SELECT SUM(jumlah), SUM(total)  FROM pengajuan_sementara   ");
                                  $query = mysqli_query($koneksi, "SELECT SUM(jumlah), SUM(total)  
FROM pengajuan_sementara where status_pengajuan='Permintaan Pengajuan Baru'");

                                  if(mysqli_num_rows($query) > 0) {
                                    while($row1 = mysqli_fetch_assoc($query)):

                                      ?>
                                      <th></th>
                                      <th></th>
                                      <th>Jumlah Barang :</th>
                                      <th><?= $row1['SUM(jumlah)']; ?></th>
                                      <th>Sub Total :</th>
                                      <th>Rp.<?= number_format($row1['SUM(total)']); ?> </th>


                                  </tr>


                              </table>    

                          <?php endwhile; }?>
                          <div class="box-body">   
                            <a class="hide btn btn-success" href="pesanpengajuan.php" >sBuat Pengajuan</a>
                </div>     <!--<a class="btn btn-success" href="pesanpengajuan.php" >
                Minta Barang</a> -->
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $("#jenis_brg").change(function(){
            var jenis = $(this).val();
            var dataString = 'jenis='+jenis;
            $.ajax({
                type:"POST",
                url:"getdatapengajuan.php",
                data:dataString,
                success:function(html){
                    $("#nama_brg").html(html);
                    $("#stok").val("");
                    $("#stok_tersedia").val("");
                    $("#satuan").val("");
                    $("#hargabarang").val("");
                    $("#jumlah").val("");
                    $("#total").val("");


                }
            });
        });

        $("#nama_brg").change(function(){
            var kode = $(this).val();
            var dataString = 'kode='+kode;
            $.ajax({
                type:"POST",
                url:"getkodepengajuan.php",
                data:dataString,
                dataType:'json',
                success:function(html){
                    $("#stok").val(html['stok']);
                    $("#stok_tersedia").val(html['sisa']);
                }
            });
        });

        $("#nama_brg").change(function(){
            var kode = $(this).val();
            var dataString = 'kode='+kode;
            $.ajax({
                type:"POST",
                url:"getsatuanpengajuan.php",
                data:dataString,
                success:function(html){
                    $("#satuan").val(html);        
                }
            });
        });
        $("#nama_brg").change(function(){
            var kode = $(this).val();
            var dataString = 'kode='+kode;
            $.ajax({
                type:"POST",
                url:"gethargabarang.php",
                data:dataString,
                success:function(html){
                    $("#hargabarang").val(html);        
                    $("#jumlah").val('');
                    $("#total").val('');
                }
            });
        });

    });

    var rupiah = document.getElementById("hargabarang");
    rupiah.addEventListener("keyup", function(e) {
        rupiah.value = currencyIdr(this.value, "Rp. ");
    });


    function currencyIdr(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split  = number_string.split(","),
      sisa   = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : "");
}
/* Fungsi formatRupiah */

function hitung(){

    var jumlah = Number(document.getElementById('jumlah').value);
    console.log(jumlah);
    var getharga = document.getElementById('hargabarang').value;
    var hargab = getharga.split(".").join("").split("Rp").join("");

    var  total = jumlah * hargab;
    document.getElementById('total').value = total;

}

var rupiah1 = document.getElementById("total");
rupiah1.addEventListener("keyup", function(e) {
    rupiah1.value = total(this.value, "Rp. ");
});


function total(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
  split  = number_string.split(","),
  sisa   = split[0].length % 3,
  rupiah = split[0].substr(0, sisa),
  ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
}

rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : "");
}



</script>