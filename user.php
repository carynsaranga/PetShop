<?php
include 'koneksi.php';
include 'header.php';

// Ambil data dari VIEW user_v (password tidak ikut diambil)
$hasil = $koneksi->query("
    SELECT * FROM user_v ORDER BY iduser
");
?>
<div class="d-flex justify-content-between mb-3">
    <h3>Data User</h3>
    <a href="user_form.php" class="btn btn-primary">+ Tambah User</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th width="180">Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $hasil->fetch_assoc()) { ?>
        <tr>
            <td><?= e($row['iduser']) ?></td>
            <td><?= e($row['username']) ?></td>
            <td><?= e($row['nama_role']) ?></td>
            <td>
                <a href="user_form.php?id=<?= e($row['iduser']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="user_hapus.php?id=<?= e($row['iduser']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>