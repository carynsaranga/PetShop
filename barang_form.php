<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;
$data = ['jenis' => '', 'nama' => '', 'idsatuan' => '', 'status' => 1, 'harga' => ''];

// --- Mode EDIT: ambil data lama ---
if ($id) {
    $stmt = $koneksi->prepare("SELECT * FROM barang WHERE idbarang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        pindah('barang.php', 'gagal', 'Data tidak ditemukan.');
    }
}

// --- Form disubmit ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis    = trim($_POST['jenis']);
    $nama     = trim($_POST['nama']);
    $idsatuan = (int)$_POST['idsatuan'];
    $status   = (int)$_POST['status'];
    $harga    = (int)$_POST['harga'];

    if ($jenis == '' || $nama == '' || $idsatuan == 0) {
        $_SESSION['pesan'] = ['gagal', 'Jenis, nama, dan satuan wajib diisi.'];
        $data = ['jenis' => $jenis, 'nama' => $nama, 'idsatuan' => $idsatuan, 'status' => $status, 'harga' => $harga];
    } else {
        if ($id) {
            // UPDATE
            $stmt = $koneksi->prepare("UPDATE barang SET jenis=?, nama=?, idsatuan=?, status=?, harga=? WHERE idbarang=?");
            $stmt->bind_param("ssiiii", $jenis, $nama, $idsatuan, $status, $harga, $id);
            $stmt->execute();
            pindah('barang.php', 'sukses', 'Barang berhasil diubah.');
        } else {
            // CREATE
            $stmt = $koneksi->prepare("INSERT INTO barang (jenis, nama, idsatuan, status, harga) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiii", $jenis, $nama, $idsatuan, $status, $harga);
            $stmt->execute();
            pindah('barang.php', 'sukses', 'Barang berhasil ditambah.');
        }
    }
}

// data untuk dropdown satuan
$daftar_satuan = $koneksi->query("SELECT idsatuan, nama_satuan FROM satuan ORDER BY nama_satuan");

include 'header.php';
?>
<h3><?= $id ? 'Edit' : 'Tambah' ?> Barang</h3>

<form method="post" class="bg-white p-4 border rounded" style="max-width:500px">
    <div class="mb-3">
        <label class="form-label">Jenis (1 karakter)</label>
        <input type="text" name="jenis" class="form-control" maxlength="1"
               value="<?= e($data['jenis']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Barang</label>
        <input type="text" name="nama" class="form-control" maxlength="45"
               value="<?= e($data['nama']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Satuan</label>
        <select name="idsatuan" class="form-select" required>
            <option value="">-- pilih satuan --</option>
            <?php while ($s = $daftar_satuan->fetch_assoc()) { ?>
                <option value="<?= e($s['idsatuan']) ?>" <?= $data['idsatuan'] == $s['idsatuan'] ? 'selected' : '' ?>>
                    <?= e($s['nama_satuan']) ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="harga" class="form-control" min="0"
               value="<?= e($data['harga']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="barang.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>
