<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Hanya menerima kiriman form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: produk.php');
    exit;
}

$aksi = $_POST['aksi'] ?? '';
$id   = (int) ($_POST['id'] ?? 0);

if (!in_array($aksi, ['tambah', 'edit'], true)) {
    header('Location: produk.php');
    exit;
}

// Halaman tujuan jika validasi gagal
$kembali = ($aksi === 'edit') ? "edit.php?id=$id" : 'tambah.php';

// Fungsi kecil: simpan isian, tampilkan error, kembali ke form
function gagal($pesan, $kembali)
{
    $_SESSION['old'] = $_POST;
    set_flash('error', $pesan);
    header("Location: $kembali");
    exit;
}

// Untuk edit: pastikan produk ada, dan ambil foto lamanya
$lama = null;
if ($aksi === 'edit') {
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $lama = $stmt->fetch();

    if (!$lama) {
        set_flash('error', 'Produk tidak ditemukan.');
        header('Location: produk.php');
        exit;
    }
}

// ---------------------------------------------
// 1. Ambil data dari form
// ---------------------------------------------
$nama      = trim($_POST['nama'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');
$bahan     = trim($_POST['bahan'] ?? '');
$warna     = trim($_POST['warna'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$harga     = trim($_POST['harga'] ?? '');
$stok      = trim($_POST['stok'] ?? '');

// ---------------------------------------------
// 2. Validasi (pola $errors dari modul)
// ---------------------------------------------
$errors = [];

if ($nama === '') {
    $errors[] = 'Nama produk wajib diisi.';
} elseif (strlen($nama) > 100) {
    $errors[] = 'Nama produk maksimal 100 karakter.';
}

if (!in_array($kategori, KATEGORI, true)) {
    $errors[] = 'Kategori tidak valid.';
}

if ($bahan === '') {
    $errors[] = 'Bahan wajib diisi.';
} elseif (strlen($bahan) > 50) {
    $errors[] = 'Bahan maksimal 50 karakter.';
}

if ($warna === '') {
    $errors[] = 'Warna wajib diisi.';
} elseif (strlen($warna) > 50) {
    $errors[] = 'Warna maksimal 50 karakter.';
}

if ($deskripsi === '') {
    $errors[] = 'Deskripsi wajib diisi.';
} elseif (strlen($deskripsi) > 1000) {
    $errors[] = 'Deskripsi maksimal 1000 karakter.';
}

if (!is_numeric($harga)) {
    $errors[] = 'Harga harus berupa angka.';
} elseif ((float) $harga <= 0) {
    $errors[] = 'Harga harus lebih dari 0.';
} elseif ((float) $harga > 9999999999) {
    $errors[] = 'Harga terlalu besar.';
}

if (filter_var($stok, FILTER_VALIDATE_INT) === false) {
    $errors[] = 'Stok harus berupa bilangan bulat.';
} elseif ((int) $stok < 0) {
    $errors[] = 'Stok tidak boleh negatif.';
}

// ---------------------------------------------
// 3. Validasi upload gambar (opsional)
// ---------------------------------------------
$file = $_FILES['gambar'] ?? null;
$ada_file = ($file !== null && $file['error'] !== UPLOAD_ERR_NO_FILE);
$ext = '';

if ($ada_file) {
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        $errors[] = 'Ukuran gambar maksimal 2 MB.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Upload gambar gagal. Silakan coba lagi.';
    } else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $errors[] = 'Format gambar harus JPG, PNG, atau WEBP.';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran gambar maksimal 2 MB.';
        } elseif (@getimagesize($file['tmp_name']) === false) {
            $errors[] = 'File yang diunggah bukan gambar yang valid.';
        }
    }
}

// ---------------------------------------------
// 4. Jika ada error: kembali ke form
// ---------------------------------------------
if (!empty($errors)) {
    gagal(implode(' ', $errors), $kembali);
}

// ---------------------------------------------
// 5. Pindahkan file gambar (jika ada)
// ---------------------------------------------
$gambar_baru = null;

if ($ada_file) {
    $gambar_baru = date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $gambar_baru)) {
        gagal('Gagal menyimpan gambar. Pastikan folder uploads/produk ada.', $kembali);
    }
}

// ---------------------------------------------
// 6. Simpan ke database
// ---------------------------------------------
try {
    if ($aksi === 'tambah') {
        $stmt = $pdo->prepare(
            "INSERT INTO produk (nama, kategori, bahan, warna, deskripsi, harga, stok, gambar)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nama, $kategori, $bahan, $warna, $deskripsi, (float) $harga, (int) $stok, $gambar_baru]);

        set_flash('sukses', 'Produk berhasil ditambahkan.');

    } else { // edit
        $gambar_simpan = $gambar_baru ?? $lama['gambar'];

        $stmt = $pdo->prepare(
            "UPDATE produk
             SET nama = ?, kategori = ?, bahan = ?, warna = ?, deskripsi = ?, harga = ?, stok = ?, gambar = ?
             WHERE id = ?"
        );
        $stmt->execute([$nama, $kategori, $bahan, $warna, $deskripsi, (float) $harga, (int) $stok, $gambar_simpan, $id]);

        // Foto lama dihapus hanya setelah UPDATE berhasil
        if ($gambar_baru && !empty($lama['gambar'])) {
            $file_lama = UPLOAD_DIR . basename($lama['gambar']);
            if (is_file($file_lama)) {
                unlink($file_lama);
            }
        }

        set_flash('sukses', 'Produk berhasil diperbarui.');
    }
} catch (PDOException $e) {
    // Database gagal: buang file yang sudah terlanjur diunggah
    if ($gambar_baru && is_file(UPLOAD_DIR . $gambar_baru)) {
        unlink(UPLOAD_DIR . $gambar_baru);
    }
    gagal('Terjadi kesalahan database. Data tidak tersimpan.', $kembali);
}

header('Location: produk.php');
exit;