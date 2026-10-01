<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$total_produk   = $pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$total_stok     = $pdo->query("SELECT COALESCE(SUM(stok), 0) FROM produk")->fetchColumn();
$total_kategori = $pdo->query("SELECT COUNT(DISTINCT kategori) FROM produk")->fetchColumn();

$judul = 'Dashboard';
require_once '../includes/header_admin.php';
?>

<div class="page-head">
    <h1>Halo, <?= e($_SESSION['admin_nama']); ?> 👋</h1>
</div>

<div class="stat-grid">
    <div class="stat">
        <small>Total Produk</small>
        <strong><?= (int) $total_produk; ?></strong>
    </div>
    <div class="stat">
        <small>Total Stok</small>
        <strong><?= number_format((int) $total_stok, 0, ',', '.'); ?></strong>
    </div>
    <div class="stat">
        <small>Jumlah Kategori</small>
        <strong><?= (int) $total_kategori; ?></strong>
    </div>
</div>

<div class="aksi-cepat">
    <a class="btn" href="produk.php">Kelola Produk</a>
    <a class="btn btn-ghost" href="tambah.php">+ Tambah Produk</a>
    <a class="btn btn-ghost" href="../auth/buat_admin.php">Tambah Admin</a>
</div>

<?php require_once '../includes/footer.php'; ?>