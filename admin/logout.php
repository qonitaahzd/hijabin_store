<?php
require_once '../config/app.php';
require_once '../includes/flash.php';

// Hapus data login
unset($_SESSION['admin_id'], $_SESSION['admin_nama'], $_SESSION['admin_username']);
session_regenerate_id(true);

set_flash('sukses', 'Anda telah keluar.');
header('Location: ' . BASE_URL . '/auth/login.php');
exit;