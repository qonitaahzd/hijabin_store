</main>

<?php if (!empty($publik)): ?>

<footer class="footer-publik">
    <div class="footer-publik__inner">
        <div>
            <a class="brand" href="<?= BASE_URL; ?>/index.php"><?= e(NAMA_TOKO); ?></a>
            <p>Hijab nyaman &amp; elegan untuk keseharian.</p>
        </div>
        <nav>
            <a href="<?= BASE_URL; ?>/index.php">Beranda</a>
            <a href="<?= BASE_URL; ?>/produk.php">Produk</a>
            <a href="<?= BASE_URL; ?>/tentang.php">Tentang Kami</a>
        </nav>
        <p>&copy; <?= date('Y'); ?> <?= e(NAMA_TOKO); ?></p>
    </div>
</footer>

<?php else: ?>

<footer class="admin-footer">
    &copy; <?= date('Y'); ?> <?= e(NAMA_TOKO); ?>
</footer>

<?php endif; ?>

<script src="<?= BASE_URL; ?>/assets/js/main.js"></script>
</body>
</html>