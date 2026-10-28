<?php
// Satu file untuk TAMBAH (tanpa ?id) dan EDIT (dengan ?id)
include 'koneksi.php';

$id = $_GET['id'] ?? null;
$data = ['nama_vendor' => '', 'badan_hukum' => '', 'status' => ''];   // isi awal form tambah
$error = '';

// Daftar pilihan: kode => label
$daftar_badan_hukum = [
    'P' => 'PT',
    'C' => 'CV',
    'U' => 'UD',
    'L' => 'Lainnya',
];

$daftar_status = [
    'A' => 'Aktif',
    'N' => 'Nonaktif',
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
    $status      = trim($_POST['status'] ?? '');

    // status boleh kosong, tapi kalau diisi harus kode yang valid
    $status_valid = ($status === '' || array_key_exists($status, $daftar_status));

    if ($nama == '' || !array_key_exists($badan_hukum, $daftar_badan_hukum) || !$status_valid) {
        $error = 'Nama vendor dan badan hukum wajib diisi dengan benar.';
        $data['nama_vendor'] = $nama;
        $data['badan_hukum'] = $badan_hukum;
        $data['status']      = $status;
    } else {
        // status kosong disimpan sebagai NULL
        $status_db = ($status === '') ? null : $status;

        if ($id) {
            // UPDATE
            $stmt = $koneksi->prepare("UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?");
            $stmt->bind_param("sssi", $nama, $badan_hukum, $status_db, $id);
            $stmt->execute();
            pindah('vendor.php', 'sukses', 'Vendor berhasil diubah.');
        } else {
            // CREATE
            $stmt = $koneksi->prepare("INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $badan_hukum, $status_db);
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
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="" <?= ($data['status'] ?? '') === '' ? 'selected' : '' ?>>-- Belum diatur --</option>
            <?php foreach ($daftar_status as $kode => $label): ?>
                <option value="<?= e($kode) ?>" <?= ($data['status'] ?? '') === $kode ? 'selected' : '' ?>>
                    <?= e($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="vendor.php" class="btn btn-secondary">Batal</a>
</form>
<?php include 'footer.php'; ?>