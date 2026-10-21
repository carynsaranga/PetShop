<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

try {
    $stmt = $koneksi->prepare("DELETE FROM satuan WHERE idsatuan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    pindah('satuan.php', 'sukses', 'Satuan berhasil dihapus.');
} catch (mysqli_sql_exception $ex) {
    // biasanya karena masih dipakai tabel lain (foreign key)
    pindah('satuan.php', 'gagal', 'Gagal hapus: data masih digunakan di tabel lain.');
}
