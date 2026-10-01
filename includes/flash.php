<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simpan pesan. $tipe: 'sukses' atau 'error'
function set_flash($tipe, $pesan)
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

// Tampilkan pesan satu kali, lalu hapus
function tampil_flash()
{
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo '<div class="alert alert-' . htmlspecialchars($f['tipe']) . '">'
           . htmlspecialchars($f['pesan']) . '</div>';
        unset($_SESSION['flash']);
    }
}