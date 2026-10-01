<?php
require_once '../config/app.php';
require_once '../includes/flash.php';

// Kalau sudah login, tidak perlu melihat form login lagi
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - <?= NAMA_TOKO; ?></title>
    <style>
        /* Gaya sementara, nanti dipindah ke assets/css/style.css di Tahap 5 */
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            background: #f6efe9; font-family: Arial, sans-serif; color: #3b2a25;
        }
        .login-box {
            width: 100%; max-width: 380px; background: #fff;
            padding: 36px 32px; border-radius: 20px;
            box-shadow: 0 10px 30px rgba(92, 61, 46, .12);
        }
        h1 { margin: 0 0 4px; font-family: Georgia, serif; font-size: 28px; }
        .sub { margin: 0 0 24px; color: #8a7268; font-size: 14px; }
        label { display: block; margin: 14px 0 6px; font-size: 14px; font-weight: bold; }
        input {
            width: 100%; padding: 12px 14px; border: 1px solid #dccfc6;
            border-radius: 10px; font-size: 15px;
        }
        input:focus { outline: none; border-color: #c48b7b; }
        button {
            width: 100%; margin-top: 22px; padding: 13px; border: 0;
            border-radius: 10px; background: #a9675a; color: #fff;
            font-size: 15px; font-weight: bold; cursor: pointer;
        }
        button:hover { background: #8f5246; }
        .alert { padding: 10px 14px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; }
        .alert-error  { background: #fdeaea; color: #a33; }
        .alert-sukses { background: #e9f6ec; color: #2e7d46; }
        .kembali { display: block; margin-top: 18px; text-align: center; font-size: 13px; color: #8a7268; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1><?= NAMA_TOKO; ?></h1>
        <p class="sub">Masuk ke panel admin</p>

        <?php tampil_flash(); ?>

        <form action="proses_login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autofocus required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>

        <a class="kembali" href="<?= BASE_URL; ?>/index.php">← Kembali ke toko</a>
    </div>
</body>
</html>