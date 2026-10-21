<?php
include 'koneksi.php';
include 'header.php';

$hasil = $koneksi->query("
    SELECT * FROM vendor_v ORDER BY idvendor
");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Vendor</h3>
    <a href="vendor_form.php" class="btn btn-primary">+ Tambah Vendor</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Vendor</th>
            <th>Badan Hukum</th>
            <th>Status</th>
            <th width="180">Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['idvendor']) ?></td>
            <td><?= e($row['nama_vendor']) ?></td>
            <td><?= e($row['nama_badan_hukum']) ?></td>
            <td><?= e($row['status_vendor']) ?></td>
            <td>
                <a href="vendor_form.php?id=<?= e($row['idvendor']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="vendor_hapus.php?id=<?= e($row['idvendor']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>