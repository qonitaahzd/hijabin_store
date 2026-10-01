<?php
require_once '../config/database.php';
require_once '../config/app.php';
require_once '../includes/flash.php';

// Halaman ini hanya boleh menerima kiriman form (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi: tidak boleh kosong
if ($username === '' || $password === '') {
    set_flash('error', 'Username dan password wajib diisi.');
    header('Location: login.php');
    exit;
}

// Cari admin berdasarkan username (prepared statement)
$stmt = $pdo->prepare("SELECT id, nama, username, password FROM admin WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$admin = $stmt->fetch();

// Cocokkan password dengan hash di database
if ($admin && password_verify($password, $admin['password'])) {
    session_regenerate_id(true);   // ganti ID session demi keamanan

    $_SESSION['admin_id']       = $admin['id'];
    $_SESSION['admin_nama']     = $admin['nama'];
    $_SESSION['admin_username'] = $admin['username'];

    header('Location: ../admin/index.php');
    exit;
}

// Gagal: pesan sengaja dibuat umum
set_flash('error', 'Username atau password salah.');
header('Location: login.php');
exit;