<?php
include "header.php";
include "navbar.php";
?>
<div class="card mt-2">
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
            Tambah Data
</button>
    <div class="card-body">
    <?php
  if(isset($_GET['pesan'])){
    if($_GET['pesan']=="simpan"){?>
    <div class="alert alert-success" role="alert">
 Data Berhasil di Simpan
</div>
<?php } ?>
<?php if($_GET['pesan']=="update"){?>
    <div class="alert alert-success" role="alert">
 Data Berhasil di Update
</div>
<?php } ?>
<?php if($_GET['pesan']=="hapus"){?>
    <div class="alert alert-success" role="alert">
 Data Berhasil di Hapus
</div>
<?php } ?>
    <?php 
}
?>
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Id Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>No. Telepon</th>
            <th>Alamat</th>
            <th>Total Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php 
		include '../koneksi.php';
		$no = 1;
		$data = mysqli_query($koneksi,"SELECT * FROM pelanggan INNER JOIN penjualan ON pelanggan.PelangganID=penjualan.PelangganID");
		while($d = mysqli_fetch_array($data)){
			?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['PelangganID']; ?></td>
            <td><?php echo $d['NamaPelanggan']; ?></td>
            <td><?php echo $d['NoTelepon']; ?></td>
            <td><?php echo $d['Alamat']; ?></td>
            <td>Rp. <?php echo $d['TotalHarga']; ?></td>
            <td>
              
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
</div>
</div>
<!-- Modal tambah data-->
<div class="modal fade" id="tambah-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="proses_pembelian.php" method="post">
      <div class="modal-body">
          <div class="form-group">
            <label>Id Pelanggan</label>
            <input type="text" name="PelangganID" value="<?php echo date("dmHis") ?>"class="form-control" readonly>
</div>
          <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" name="NamaPelanggan" class="form-control">
    </div>
          <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="NoTelepon" class="form-control">
    </div>
    <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="Alamat" class="form-control">
            <input type="hidden" name="TanggalPenjualan" value="<?php echo date("Y-m-d") ?>" class="form-control">
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
</form>
    </div>
  </div>
</div>
<?php
include "footer.php";
?>