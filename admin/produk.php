<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// 1. Ambil kata kunci & kategori dari URL
$keyword  = (isset($_GET['keyword'])  && is_string($_GET['keyword']))  ? trim($_GET['keyword']) : '';
$kategori = (isset($_GET['kategori']) && is_string($_GET['kategori'])) ? $_GET['kategori'] : '';

// 2. Susun kondisi WHERE secara bertahap
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

// 3. Hitung total data sesuai pencarian & filter
$per_page = 5;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM produk" . $where);
$stmt->execute($params);
$total       = (int) $stmt->fetchColumn();
$total_pages = max(1, (int) ceil($total / $per_page));

// 4. Tentukan halaman aktif (dijaga agar tidak keluar batas)
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page   = min(max($page, 1), $total_pages);
$offset = ($page - 1) * $per_page;

// 5. Ambil data untuk halaman ini
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
    return '?' . http_build_query(['keyword' => $keyword, 'kategori' => $kategori, 'page' => $p]);
};

$judul = 'Kelola Produk';
require_once '../includes/header_admin.php';
?>

<div class="page-head">
    <h1>Kelola Produk</h1>
    <a class="btn" href="tambah.php">+ Tambah Produk</a>
</div>

<form method="GET" class="filter-bar">
    <input type="text" name="keyword" placeholder="Cari nama produk..." value="<?= e($keyword); ?>">
    <select name="kategori">
        <option value="">Semua kategori</option>
        <?php foreach (KATEGORI as $k): ?>
            <option value="<?= e($k); ?>" <?= $kategori === $k ? 'selected' : ''; ?>><?= e($k); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn">Cari</button>
    <a href="produk.php" class="btn btn-ghost">Reset</a>
</form>

<div class="tabel-wrap">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($data)): ?>
            <tr><td colspan="7" class="kosong">Tidak ada produk ditemukan.</td></tr>
        <?php endif; ?>

        <?php foreach ($data as $i => $p): ?>
            <tr>
                <td><?= $offset + $i + 1; ?></td>
                <td>
                    <?php if (!empty($p['gambar']) && is_file(UPLOAD_DIR . basename($p['gambar']))): ?>
                        <img class="thumb" src="<?= UPLOAD_URL . e($p['gambar']); ?>" alt="<?= e($p['nama']); ?>">
                    <?php else: ?>
                        <div class="thumb-kosong">Tanpa foto</div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?= e($p['nama']); ?></strong><br>
                    <small><?= e($p['bahan']); ?> &middot; <?= e($p['warna']); ?></small>
                </td>
                <td><span class="badge"><?= e($p['kategori']); ?></span></td>
                <td class="nowrap"><?= rupiah($p['harga']); ?></td>
                <td>
                    <?php if ((int) $p['stok'] === 0): ?>
                        <span class="badge badge-habis">Habis</span>
                    <?php else: ?>
                        <?= (int) $p['stok']; ?>
                    <?php endif; ?>
                </td>
                <td class="nowrap">
                    <a class="btn btn-ghost btn-kecil" href="edit.php?id=<?= (int) $p['id']; ?>">Edit</a>
                    <form action="hapus.php" method="POST" class="inline"
                          onsubmit="return confirm('Yakin hapus produk ini? Tindakan ini tidak bisa dibatalkan.');">
                        <input type="hidden" name="id" value="<?= (int) $p['id']; ?>">
                        <button type="submit" class="btn btn-kecil btn-hapus">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

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

<?php require_once '../includes/footer.php'; ?>