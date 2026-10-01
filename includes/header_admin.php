<?php
// $judul diisi oleh halaman yang memanggil file ini
$judul   = $judul ?? 'Admin';
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
<body class="admin">

<header class="admin-nav">
    <div class="admin-nav__inner">
        <a class="brand" href="<?= BASE_URL; ?>/admin/index.php">
            <?= e(NAMA_TOKO); ?> <span>Admin</span>
        </a>
        <nav>
            <a href="<?= BASE_URL; ?>/admin/index.php"
               class="<?= $halaman === 'index.php' ? 'aktif' : ''; ?>">Dashboard</a>
            <a href="<?= BASE_URL; ?>/admin/produk.php"
               class="<?= in_array($halaman, ['produk.php', 'tambah.php', 'edit.php']) ? 'aktif' : ''; ?>">Produk</a>
            <a href="<?= BASE_URL; ?>/index.php" target="_blank">Lihat Toko</a>
            <a href="<?= BASE_URL; ?>/admin/logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="container">
<?php tampil_flash(); ?>