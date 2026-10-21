<?php
// Satu file untuk TAMBAH (tanpa ?id) dan EDIT (dengan ?id)
include 'koneksi.php';

$id = $_GET['id'] ?? null;
$data = ['nama_satuan' => '', 'status' => 1];   // isi awal form tambah

// --- Kalau mode EDIT: ambil data lama ---
if ($id) {
    $stmt = $koneksi->prepare("SELECT * FROM satuan WHERE idsatuan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        pindah('satuan.php', 'gagal', 'Data tidak ditemukan.');
    }
}

// --- Kalau form disubmit (POST): simpan ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama   = trim($_POST['nama_satuan']);
    $status = (int)$_POST['status'];

    if ($nama == '') {
        $_SESSION['pesan'] = ['gagal', 'Nama satuan tidak boleh kosong.'];
        $data['nama_satuan'] = $nama;
        $data['status'] = $status;
    } else {
        if ($id) {
            // UPDATE
            $stmt = $koneksi->prepare("UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?");
            $stmt->bind_param("sii", $nama, $status, $id);
            $stmt->execute();
            pindah('satuan.php', 'sukses', 'Satuan berhasil diubah.');
        } else {
            // CREATE
            $stmt = $koneksi->prepare("INSERT INTO satuan (nama_satuan, status) VALUES (?, ?)");
            $stmt->bind_param("si", $nama, $status);
            $stmt->execute();
            pindah('satuan.php', 'sukses', 'Satuan berhasil ditambah.');
        }
    }
}

include 'header.php';
?>
<h3><?= $id ? 'Edit' : 'Tambah' ?> Satuan</h3>

<form method="post" class="bg-white p-4 border rounded" style="max-width:500px">
    <div class="mb-3">
        <label class="form-label">Nama Satuan</label>
        <input type="text" name="nama_satuan" class="form-control" maxlength="45"
               value="<?= e($data['nama_satuan']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="satuan.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>
