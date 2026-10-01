<?php
require_once 'config/app.php';

$judul = 'Tentang Kami';
require_once 'includes/header.php';

$wa = 'https://wa.me/' . NO_WHATSAPP . '?text=' . rawurlencode('Halo ' . NAMA_TOKO . ', saya ingin bertanya.');
?>

<section class="tentang-hero">
    <h1>Hijab yang terasa <em>pas</em> sejak pertama dipakai</h1>
    <p>
        <?= e(NAMA_TOKO); ?> hadir untuk membantu Anda menemukan hijab yang nyaman,
        rapi, dan mudah dipadukan untuk berbagai kesempatan. Kami memilih bahan dan
        warna dengan teliti, agar tampil anggun tanpa ribet.
    </p>
</section>

<div class="nilai-grid">
    <div class="nilai">
        <h3>Nyaman seharian</h3>
        <p>Bahan ringan dan adem, dipilih agar nyaman dipakai dari pagi sampai malam.</p>
    </div>
    <div class="nilai">
        <h3>Mudah dipadukan</h3>
        <p>Warna-warna lembut yang cocok untuk kuliah, kerja, hingga acara santai.</p>
    </div>
    <div class="nilai">
        <h3>Harga bersahabat</h3>
        <p>Kualitas terjaga dengan harga yang tetap ramah di kantong.</p>
    </div>
</div>

<div class="cta-tengah">
    <a class="btn" href="<?= BASE_URL; ?>/produk.php">Lihat Koleksi</a>
    <a class="btn btn-wa" href="<?= e($wa); ?>" target="_blank" rel="noopener">Hubungi via WhatsApp</a>
</div>

<?php require_once 'includes/footer.php'; ?>