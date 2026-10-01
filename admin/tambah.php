<?php
require_once '../includes/auth.php';

// Isi form sebelumnya jika validasi gagal (supaya tidak mengetik ulang)
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$judul = 'Tambah Produk';
require_once '../includes/header_admin.php';
?>

<div class="page-head">
    <h1>Tambah Produk</h1>
    <a class="btn btn-ghost" href="produk.php">&larr; Kembali</a>
</div>

<form action="proses_produk.php" method="POST" enctype="multipart/form-data" class="form-card">
    <input type="hidden" name="aksi" value="tambah">

    <div class="field">
        <label for="nama">Nama Produk</label>
        <input type="text" id="nama" name="nama" maxlength="100"
               value="<?= e($old['nama'] ?? ''); ?>" required>
    </div>

    <div class="row2">
        <div class="field">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih kategori --</option>
                <?php foreach (KATEGORI as $k): ?>
                    <option value="<?= e($k); ?>" <?= (($old['kategori'] ?? '') === $k) ? 'selected' : ''; ?>>
                        <?= e($k); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label for="bahan">Bahan</label>
            <input type="text" id="bahan" name="bahan" maxlength="50"
                   placeholder="Contoh: Voal" value="<?= e($old['bahan'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="row2">
        <div class="field">
            <label for="warna">Warna</label>
            <input type="text" id="warna" name="warna" maxlength="50"
                   placeholder="Contoh: Dusty Rose" value="<?= e($old['warna'] ?? ''); ?>" required>
        </div>
        <div class="field">
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" min="1" step="any"
                   value="<?= e($old['harga'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="row2">
        <div class="field">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" min="0" step="1"
                   value="<?= e($old['stok'] ?? '0'); ?>" required>
        </div>
        <div class="field">
            <label for="gambar">Foto Produk</label>
            <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp">
            <span class="hint">Opsional. JPG, PNG, atau WEBP. Maks. 2 MB.</span>
        </div>
    </div>

    <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" maxlength="1000" required><?= e($old['deskripsi'] ?? ''); ?></textarea>
        <span class="hint">Maksimal 1000 karakter.</span>
    </div>

    <div class="form-aksi">
        <button type="submit" class="btn">Simpan Produk</button>
        <a class="btn btn-ghost" href="produk.php">Batal</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>