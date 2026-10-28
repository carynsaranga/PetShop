<?php
include 'koneksi.php';
include 'header.php';

// Ambil data dari VIEW marginpenjualan_v (perhatikan: tanpa underscore di tengah)
$hasil = $koneksi->query("
    SELECT * FROM marginpenjualan_v ORDER BY idmargin_penjualan
");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Margin Penjualan</h3>
    <a href="margin_form.php" class="btn btn-primary">+ Tambah Margin</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Persen</th>
            <th>Status</th>
            <th>Dibuat Oleh</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>
            <th width="180">Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['idmargin_penjualan']) ?></td>
            <td><?= e($row['persen']) ?>%</td>
            <td><?= e($row['status_margin']) ?></td>
            <td><?= e($row['dibuat_oleh']) ?></td>
            <td><?= e($row['created_at']) ?></td>
            <td><?= e($row['updated_at']) ?></td>
            <td>
                <a href="margin_form.php?id=<?= e($row['idmargin_penjualan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="margin_hapus.php?id=<?= e($row['idmargin_penjualan']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>