<?php
include 'koneksi.php';
include 'header.php';

// JOIN supaya yang tampil nama satuan bukan angka ID
$hasil = $koneksi->query("
    SELECT * FROM barang_v ORDERBY idbarang
");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Barang</h3>
    <a href="barang_form.php" class="btn btn-primary">+ Tambah Barang</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Jenis</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Status</th>
            <th width="180">Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['idbarang']) ?></td>
            <td><?= e($row['jenis']) ?></td>
            <td><?= e($row['nama_barang']) ?></td>
            <td><?= e($row['nama_satuan']) ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= e($row['status_barang']) ?></td>
            <td>
                <a href="barang_form.php?id=<?= e($row['idbarang']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="barang_hapus.php?id=<?= e($row['idbarang']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
