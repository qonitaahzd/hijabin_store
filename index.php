<?php
require_once 'config/app.php';
require_once 'config/database.php';

// 6 produk terbaru
$terbaru  = $pdo->query("SELECT * FROM produk ORDER BY id DESC LIMIT 6")->fetchAll();
$unggulan = $terbaru[0] ?? null;

// Jumlah produk per kategori: ['Pashmina' => 3, 'Instan' => 2, ...]
$jumlah = $pdo->query("SELECT kategori, COUNT(*) FROM produk GROUP BY kategori")
              ->fetchAll(PDO::FETCH_KEY_PAIR);

$judul = 'Beranda';
require_once 'includes/header.php';

$foto_unggulan = $unggulan ? url_foto($unggulan['gambar']) : null;
?>

<section class="hero">
    <div>
        <p class="hero__label">Koleksi hijab pilihan</p>
        <h1>Anggun dalam setiap <em>lipatan</em></h1>
        <p class="lead">
            Bahan nyaman, warna lembut, dan potongan yang mudah dipakai.
            Temukan hijab yang pas untuk keseharian Anda.
        </p>
        <div class="hero__aksi">
            <a class="btn" href="<?= BASE_URL; ?>/produk.php">Lihat Koleksi</a>
            <a class="btn btn-ghost" href="<?= BASE_URL; ?>/tentang.php">Tentang Kami</a>
        </div>
    </div>

    <div class="hero__visual"
         <?php if ($foto_unggulan): ?>style="background-image: url('<?= e($foto_unggulan); ?>');"<?php endif; ?>>
        <?php if ($unggulan): ?>
            <a class="hero__kartu" href="<?= BASE_URL; ?>/detail.php?id=<?= (int) $unggulan['id']; ?>">
                <?php if ($foto_unggulan): ?>
                    <img src="<?= e($foto_unggulan); ?>" alt="">
                <?php else: ?>
                    <div class="mini"></div>
                <?php endif; ?>
                <div>
                    <small>Produk terbaru</small>
                    <strong><?= e($unggulan['nama']); ?></strong>
                    <span><?= rupiah($unggulan['harga']); ?></span>
                </div>
            </a>
        <?php endif; ?>
    </div>
</section>

<div class="section-head">
    <h2>Belanja per kategori</h2>
</div>
<div class="strip-kategori">
    <?php foreach (KATEGORI as $k): ?>
        <a href="<?= BASE_URL; ?>/produk.php?kategori=<?= urlencode($k); ?>">
            <?= e($k); ?> <small>(<?= (int) ($jumlah[$k] ?? 0); ?>)</small>
        </a>
    <?php endforeach; ?>
</div>

<div class="section-head">
    <h2>Produk terbaru</h2>
    <a href="<?= BASE_URL; ?>/produk.php">Lihat semua &rarr;</a>
</div>

<?php if (empty($terbaru)): ?>
    <div class="kosong">Belum ada produk.</div>
<?php else: ?>
    <div class="grid-produk">
        <?php foreach ($terbaru as $p): ?>
            <?php kartu_produk($p); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>