<?php
require_once '../includes/auth.php';      // hanya admin yang sudah login
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors   = [];

    if ($nama === '' || strlen($nama) > 100) {
        $errors[] = 'Nama wajib diisi (maks. 100 karakter).';
    }
    if (!preg_match('/^[a-zA-Z0-9_]{4,50}$/', $username)) {
        $errors[] = 'Username 4-50 karakter: huruf, angka, dan underscore saja.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    // Cek username belum dipakai
    if (empty($errors)) {
        $cek = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $cek->execute([$username]);
        if ($cek->fetch()) {
            $errors[] = 'Username sudah dipakai.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins  = $pdo->prepare("INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)");
        $ins->execute([$nama, $username, $hash]);
        set_flash('sukses', "Admin '$username' berhasil dibuat.");
    } else {
        set_flash('error', implode(' ', $errors));
    }

    header('Location: buat_admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Admin - <?= NAMA_TOKO; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6efe9; color: #3b2a25; padding: 30px; }
        .box { max-width: 400px; margin: 0 auto; background: #fff; padding: 28px; border-radius: 16px; }
        label { display: block; margin: 12px 0 6px; font-weight: bold; font-size: 14px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #dccfc6; border-radius: 8px; box-sizing: border-box; }
        button { margin-top: 18px; padding: 11px 20px; border: 0; border-radius: 8px; background: #a9675a; color: #fff; cursor: pointer; }
        .alert { padding: 10px 14px; border-radius: 8px; margin-bottom: 12px; font-size: 14px; }
        .alert-error  { background: #fdeaea; color: #a33; }
        .alert-sukses { background: #e9f6ec; color: #2e7d46; }
        a { color: #a9675a; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Tambah Admin Baru</h2>
        <?php tampil_flash(); ?>

        <form method="POST">
            <label>Nama</label>
            <input type="text" name="nama" required>

            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Simpan</button>
        </form>

        <p><a href="../admin/index.php">← Kembali ke dashboard</a></p>
    </div>
</body>
</html>