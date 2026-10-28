<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

try {
    $stmt = $koneksi->prepare("DELETE FROM vendor WHERE idvendor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    pindah('vendor.php', 'sukses', 'Vendor berhasil dihapus.');
} catch (mysqli_sql_exception $ex) {
    // biasanya karena masih dipakai tabel lain (foreign key)
    pindah('vendor.php', 'gagal', 'Gagal hapus: data masih digunakan di tabel lain.');
}