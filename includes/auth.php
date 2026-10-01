<?php

require_once __DIR__ . '/flash.php';
require_once __DIR__ . '/../config/app.php';

if (!isset($_SESSION['admin_id'])) {
    set_flash('error', 'Silakan login terlebih dahulu.');
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}