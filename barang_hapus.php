<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

try {
    $stmt = $koneksi->prepare("DELETE FROM barang WHERE idbarang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    pindah('barang.php', 'sukses', 'Barang berhasil dihapus.');
} catch (mysqli_sql_exception $ex) {
    pindah('barang.php', 'gagal', 'Gagal hapus: barang masih digunakan di tabel transaksi.');
}
