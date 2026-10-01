<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Ambil produk berdasarkan id di URL
$id   = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    set_flash('error', 'Produk tidak ditemukan.');
    header('Location: produk.php');
    exit;
}

// Jika validasi gagal, isian terakhir pengguna menimpa data dari database
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
$f = array_merge($produk, $old);

// 89000.00 -> 89000
$f['harga'] = is_numeric($f['harga']) ? (string) (float) $f['harga'] : $f['harga'];

$judul = 'Edit Produk';
require_once '../includes/header_admin.php';
?>

<div class="page-head">
    <h1>Edit Produk</h1>
    <a class="btn btn-ghost" href="produk.php">&larr; Kembali</a>
</div>

<form action="proses_produk.php" method="POST" enctype="multipart/form-data" class="form-card">
    <input type="hidden" name="aksi" value="edit">
    <input type="hidden" name="id" value="<?= (int) $produk['id']; ?>">

    <div class="field">
        <label for="nama">Nama Produk</label>
        <input type="text" id="nama" name="nama" maxlength="100"
               value="<?= e($f['nama']); ?>" required>
    </div>

    <div class="row2">
        <div class="field">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih kategori --</option>
                <?php foreach (KATEGORI as $k): ?>
                    <option value="<?= e($k); ?>" <?= ($f['kategori'] === $k) ? 'selected' : ''; ?>>
                        <?= e($k); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label for="bahan">Bahan</label>
            <input type="text" id="bahan" name="bahan" maxlength="50"
                   value="<?= e($f['bahan']); ?>" required>
        </div>
    </div>

    <div class="row2">
        <div class="field">
            <label for="warna">Warna</label>
            <input type="text" id="warna" name="warna" maxlength="50"
                   value="<?= e($f['warna']); ?>" required>
        </div>
        <div class="field">
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" min="1" step="any"
                   value="<?= e($f['harga']); ?>" required>
        </div>
    </div>

    <div class="row2">
        <div class="field">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" min="0" step="1"
                   value="<?= e($f['stok']); ?>" required>
        </div>
        <div class="field">
            <label for="gambar">Ganti Foto</label>
            <?php if (!empty($produk['gambar']) && is_file(UPLOAD_DIR . basename($produk['gambar']))): ?>
                <div class="gambar-lama">
                    <img src="<?= UPLOAD_URL . e($produk['gambar']); ?>" alt="Foto saat ini">
                    <small>Foto saat ini</small>
                </div>
            <?php endif; ?>
            <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp">
            <span class="hint">Kosongkan jika tidak ingin mengganti foto.</span>
        </div>
    </div>

    <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" maxlength="1000" required><?= e($f['deskripsi']); ?></textarea>
        <span class="hint">Maksimal 1000 karakter.</span>
    </div>

    <div class="form-aksi">
        <button type="submit" class="btn">Simpan Perubahan</button>
        <a class="btn btn-ghost" href="produk.php">Batal</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>