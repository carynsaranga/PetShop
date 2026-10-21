<?php

session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // supaya error bisa ditangkap try/catch

$koneksi = new mysqli("localhost", "root", "473223", "proyek_pbd");
$koneksi->set_charset("utf8mb4");

// fungsi kecil untuk nampilin teks dengan aman di HTML
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// fungsi untuk menyimpan pesan (sukses/gagal) lalu pindah halaman
function pindah($halaman, $tipe = '', $isi = '') {
    if ($tipe != '') {
        $_SESSION['pesan'] = [$tipe, $isi];
    }
    header("Location: $halaman");
    exit;
}
