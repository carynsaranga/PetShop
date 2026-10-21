<?php
include 'koneksi.php';
include 'header.php';

$hasil = $koneksi->query("SELECT * FROM satuan_v ORDER BY idsatuan");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Satuan</h3>
    <a href="satuan_form.php" class="btn btn-primary">+ Tambah Satuan</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Satuan</th>
            <th>Status</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['idsatuan']) ?></td>
            <td><?= e($row['nama_satuan']) ?></td>
            <td><?= e($row['status_satuan']) ?></td>
            <td>
                <a href="satuan_form.php?id=<?= e($row['idsatuan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="satuan_hapus.php?id=<?= e($row['idsatuan']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
