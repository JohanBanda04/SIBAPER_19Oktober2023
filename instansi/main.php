<section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-12" >
          <!-- small box -->
          <div class="small-box bg-blue" style="border-radius: 25px">
            <div class="inner">
                <?php
                include "../fungsi/koneksi.php";
                include "../fungsi/fungsi.php";
                    $query_get_jml_data_permintaan = mysqli_query($koneksi,"select tgl_permintaan, count(*) as 
jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

                $dt = mysqli_fetch_array($query_get_jml_data_permintaan)
                ?>
              <p><font size="5px"><b>Data Permintaan : <?php echo $dt['jumlah_permintaan']??'0' ?></b></font></p>
              <p>Data Permintaan Barang</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
<!--            <a href="index.php?p=datapesanan" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>-->
            <a href="index.php?p=datapesanan_table&pa=Permintaan" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

          <!--ori yang disembunyikan-->
		<div class="hide col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green" style="border-radius: 25px">
            <div class="inner">
              <p><font size="5px"><b>Data Stok Barang</b></font></p>
              <p>Data Stok Barang</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="index.php?p=material" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

          <div class="col-lg-4 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-green" style="border-radius: 25px">
                  <div class="inner">
                      <p><font size="5px"><b>History Permintaan Barang</b></font></p>
                      <p>History Permintaan Barang</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="index.php?p=history_permintaan_barang_table&pa=history_pengguna" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px ">Info Lebih Lanjut <i
                              class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>

          <div class="col-lg-4 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-orange-active" style="border-radius: 25px">
                  <div class="inner">
                      <p><font size="5px"><b>Cetak BPP Barang</b></font></p>
                      <p>Cetak BPP Barang</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="index.php?p=cetak_bpp_baru_table_v2&pa=Cetak" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px ">Info Lebih Lanjut <i
                              class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>
		
		<div class="hide col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red" style="border-radius: 25px">
            <div class="inner">
              <p><font size="5px"><b>Tata Tertib</b></font></p>
              <p>Tata Tertib Permintaan Barang</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="" class="small-box-footer" data-toggle="modal" data-target="#myModal">
                Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </section>
	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><b>Tata Tertib Permintaan Barang</b></h4>
				</div>
				<!-- body modal -->
				<div class="modal-body">
			         <p>1. Pemohon Barang menginput data permintaan barang di form permintaan barang.</p>
            <p>2. Permintaan Pemohon Barang di konfirmasi oleh Bendahara.</p>
            <p>3. Setelah di konfirmasi, kemudian Pemohon Barang mencetak Bukti Permintaan Barang dan kemudian membawa Bukti yang telah di sah kan oleh Kepala Sub Bidang / Kepala Bidang Kepala Intansi Dan Ke Bendahara Barang untuk dilakukan proses pengeluaran barang.</p>
				</div>
				<!-- footer modal -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>