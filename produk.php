<?php
require_once 'config/app.php';
require_once 'config/database.php';

// 1. Ambil kata kunci & kategori dari URL
$keyword  = (isset($_GET['keyword']) && is_string($_GET['keyword'])) ? trim($_GET['keyword']) : '';
$kategori = (isset($_GET['kategori']) && is_string($_GET['kategori'])
             && in_array($_GET['kategori'], KATEGORI, true)) ? $_GET['kategori'] : '';

// 2. Susun kondisi WHERE
$where  = " WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $where   .= " AND nama LIKE ?";
    $params[] = "%$keyword%";
}
if ($kategori !== '') {
    $where   .= " AND kategori = ?";
    $params[] = $kategori;
}

// 3. Hitung total data & halaman
$per_page = 9;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM produk" . $where);
$stmt->execute($params);
$total       = (int) $stmt->fetchColumn();
$total_pages = max(1, (int) ceil($total / $per_page));

// 4. Halaman aktif (dijaga agar tidak keluar batas)
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page   = min(max($page, 1), $total_pages);
$offset = ($page - 1) * $per_page;

// 5. Ambil data halaman ini
$stmt = $pdo->prepare("SELECT * FROM produk" . $where . " ORDER BY id DESC LIMIT ? OFFSET ?");
foreach ($params as $i => $nilai) {
    $stmt->bindValue($i + 1, $nilai);
}
$stmt->bindValue(count($params) + 1, $per_page, PDO::PARAM_INT);
$stmt->bindValue(count($params) + 2, $offset,   PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll();

// Pembuat link pagination (keyword & kategori ikut terbawa)
$link = function ($p) use ($keyword, $kategori) {
    $q = array_filter(
        ['keyword' => $keyword, 'kategori' => $kategori, 'page' => $p > 1 ? $p : ''],
        fn($v) => $v !== ''
    );
    return 'produk.php' . ($q ? '?' . http_build_query($q) : '');
};

$judul = 'Produk';
require_once 'includes/header.php';
?>

<div class="page-head">
    <h1>Semua Produk</h1>
</div>

<form method="GET" class="filter-bar">
    <input type="text" name="keyword" placeholder="Cari hijab..." value="<?= e($keyword); ?>">
    <select name="kategori">
        <option value="">Semua kategori</option>
        <?php foreach (KATEGORI as $k): ?>
            <option value="<?= e($k); ?>" <?= $kategori === $k ? 'selected' : ''; ?>><?= e($k); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn">Cari</button>
    <a href="produk.php" class="btn btn-ghost">Reset</a>
</form>

<?php if (empty($data)): ?>
    <div class="kosong">Produk tidak ditemukan. Coba kata kunci atau kategori lain.</div>
<?php else: ?>
    <div class="grid-produk">
        <?php foreach ($data as $p): ?>
            <?php kartu_produk($p); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="<?= e($link($page - 1)); ?>">&laquo; Prev</a>
        <?php else: ?>
            <span class="mati">&laquo; Prev</span>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <?php if ($p === $page): ?>
                <span class="aktif"><?= $p; ?></span>
            <?php else: ?>
                <a href="<?= e($link($p)); ?>"><?= $p; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="<?= e($link($page + 1)); ?>">Next &raquo;</a>
        <?php else: ?>
            <span class="mati">Next &raquo;</span>
        <?php endif; ?>
    </div>
<?php endif; ?>

<p class="info-hasil">Menampilkan <?= count($data); ?> dari <?= $total; ?> produk</p>

<?php require_once 'includes/footer.php'; ?>