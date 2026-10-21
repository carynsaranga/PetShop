<?php
include 'koneksi.php';
include 'header.php';

// Ambil data dari VIEW role_v
$hasil = $koneksi->query("
    SELECT * FROM role_v ORDER BY idrole
");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data Role</h3>
    <a href="role_form.php" class="btn btn-primary">+ Tambah Role</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Role</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['idrole']) ?></td>
            <td><?= e($row['nama_role']) ?></td>
            <td>
                <a href="role_form.php?id=<?= e($row['idrole']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="role_hapus.php?id=<?= e($row['idrole']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>