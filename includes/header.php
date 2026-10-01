<?php
require_once __DIR__ . '/../config/app.php';

$publik  = true;   // penanda untuk footer.php
$judul   = $judul ?? 'Beranda';
$halaman = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul); ?> - <?= e(NAMA_TOKO); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
</head>
<body class="publik">

<header class="nav-publik">
    <div class="nav-publik__inner">
        <a class="brand" href="<?= BASE_URL; ?>/index.php"><?= e(NAMA_TOKO); ?></a>
        <nav>
            <a href="<?= BASE_URL; ?>/index.php"
               class="<?= $halaman === 'index.php' ? 'aktif' : ''; ?>">Beranda</a>
            <a href="<?= BASE_URL; ?>/produk.php"
               class="<?= in_array($halaman, ['produk.php', 'detail.php']) ? 'aktif' : ''; ?>">Produk</a>
            <a href="<?= BASE_URL; ?>/tentang.php"
               class="<?= $halaman === 'tentang.php' ? 'aktif' : ''; ?>">Tentang Kami</a>
        </nav>
    </div>
</header>

<main class="container">
