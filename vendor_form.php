<?php
// Satu file untuk TAMBAH (tanpa ?id) dan EDIT (dengan ?id)
include 'koneksi.php';

$id = $_GET['id'] ?? null;
$data = ['nama_vendor' => '', 'badan_hukum' => ''];   // isi awal form tambah
$error = '';

// Daftar badan hukum: kode => label
$daftar_badan_hukum = [
    'P' => 'PT',
    'C' => 'CV',
    'U' => 'UD',
    'L' => 'Lainnya',
];

// --- Kalau mode EDIT: ambil data lama ---
if ($id) {
    $stmt = $koneksi->prepare("SELECT * FROM vendor WHERE idvendor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        pindah('vendor.php', 'gagal', 'Data tidak ditemukan.');
    }
}

// --- Kalau form disubmit (POST): simpan ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama        = trim($_POST['nama_vendor'] ?? '');
    $badan_hukum = trim($_POST['badan_hukum'] ?? '');

    if ($nama == '' || !array_key_exists($badan_hukum, $daftar_badan_hukum)) {
        $error = 'Nama vendor dan badan hukum wajib diisi.';
        $data['nama_vendor'] = $nama;
        $data['badan_hukum'] = $badan_hukum;
    } else {
        if ($id) {
            // UPDATE
            $stmt = $koneksi->prepare("UPDATE vendor SET nama_vendor = ?, badan_hukum = ? WHERE idvendor = ?");
            $stmt->bind_param("ssi", $nama, $badan_hukum, $id);
            $stmt->execute();
            pindah('vendor.php', 'sukses', 'Vendor berhasil diubah.');
        } else {
            // CREATE
            $stmt = $koneksi->prepare("INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, 'A')");
            $stmt->bind_param("ss", $nama, $badan_hukum);
            $stmt->execute();
            pindah('vendor.php', 'sukses', 'Vendor berhasil ditambah.');
        }
    }
}

include 'header.php';
?>
<h3><?= $id ? 'Edit' : 'Tambah' ?> Vendor</h3>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>

<form method="post" class="bg-white p-4 border rounded" style="max-width:500px">
    <div class="mb-3">
        <label class="form-label">Nama Vendor</label>
        <input type="text" name="nama_vendor" class="form-control" maxlength="100"
               value="<?= e($data['nama_vendor']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Badan Hukum</label>
        <select name="badan_hukum" class="form-select" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($daftar_badan_hukum as $kode => $label): ?>
                <option value="<?= e($kode) ?>" <?= ($data['badan_hukum'] ?? '') == $kode ? 'selected' : '' ?>>
                    <?= e($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="vendor.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>