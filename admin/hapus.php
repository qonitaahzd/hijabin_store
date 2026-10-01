<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Penghapusan hanya lewat POST (bukan link biasa)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: produk.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

$stmt = $pdo->prepare("SELECT gambar FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    set_flash('error', 'Produk tidak ditemukan.');
    header('Location: produk.php');
    exit;
}

// Hapus baris database
$pdo->prepare("DELETE FROM produk WHERE id = ?")->execute([$id]);

// Hapus file fotonya dari folder
if (!empty($produk['gambar'])) {
    $file = UPLOAD_DIR . basename($produk['gambar']);
    if (is_file($file)) {
        unlink($file);
    }
}

set_flash('sukses', 'Produk berhasil dihapus.');
header('Location: produk.php');
exit;