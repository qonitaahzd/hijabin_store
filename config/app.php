<?php

define('NAMA_TOKO', 'Hijabin Store');

// BASE_URL dihitung otomatis
$root = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
$proj = str_replace('\\', '/', realpath(__DIR__ . '/..'));
define('BASE_URL', rtrim(str_replace($root, '', $proj), '/'));

// Folder penyimpanan foto (path di server) dan alamat URL-nya
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/produk/');
define('UPLOAD_URL', BASE_URL . '/uploads/produk/');

// Daftar kategori: dipakai di dropdown form dan filter
const KATEGORI = ['Pashmina', 'Segi Empat', 'Instan', 'Inner', 'Khimar'];

// Mengamankan teks sebelum dicetak ke HTML
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// 89000 -> Rp 89.000
function rupiah($angka)
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

// Nomor WhatsApp toko: awali 62, tanpa + dan tanpa 0 di depan
define('NO_WHATSAPP', '6285185422410');

// Alamat URL foto produk, atau null jika fotonya tidak ada
function url_foto($gambar)
{
    if (!empty($gambar) && is_file(UPLOAD_DIR . basename($gambar))) {
        return UPLOAD_URL . rawurlencode(basename($gambar));
    }
    return null;
}

// Produk dianggap "Baru" jika dibuat dalam 30 hari terakhir
function produk_baru($created_at)
{
    return strtotime($created_at) >= strtotime('-30 days');
}

// Kartu produk: dipakai di beranda dan katalog
function kartu_produk($p)
{
    $foto  = url_foto($p['gambar']);
    $habis = ((int) $p['stok'] === 0);
    ?>
    <a class="card" href="<?= BASE_URL; ?>/detail.php?id=<?= (int) $p['id']; ?>">
        <div class="card__img">
            <?php if ($foto): ?>
                <img src="<?= e($foto); ?>" alt="<?= e($p['nama']); ?>" loading="lazy">
            <?php else: ?>
                <div class="card__kosong"><?= e(NAMA_TOKO); ?></div>
            <?php endif; ?>
            <div class="card__badges">
                <?php if (produk_baru($p['created_at'])): ?><span class="tag">Baru</span><?php endif; ?>
                <?php if ($habis): ?><span class="tag tag-habis">Habis</span><?php endif; ?>
            </div>
        </div>
        <div class="card__body">
            <span class="card__kat"><?= e($p['kategori']); ?></span>
            <h3><?= e($p['nama']); ?></h3>
            <p class="card__meta"><?= e($p['bahan']); ?> &middot; <?= e($p['warna']); ?></p>
            <strong class="card__harga"><?= rupiah($p['harga']); ?></strong>
        </div>
    </a>
    <?php
}