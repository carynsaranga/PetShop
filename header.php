<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Shop Anabul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Pet Shop Anabul</a>
        <div class="navbar-nav">
            <a class="nav-link" href="satuan.php">Satuan</a>
            <a class="nav-link" href="barang.php">Barang</a>
            <!-- menu tabel lain nanti ditambah di sini -->
        </div>
    </div>
</nav>
<div class="container">
<?php
// tampilkan pesan sukses / gagal (sekali saja)
if (isset($_SESSION['pesan'])) {
    $tipe = $_SESSION['pesan'][0] == 'sukses' ? 'success' : 'danger';
    echo '<div class="alert alert-' . $tipe . '">' . e($_SESSION['pesan'][1]) . '</div>';
    unset($_SESSION['pesan']);
}
?>
