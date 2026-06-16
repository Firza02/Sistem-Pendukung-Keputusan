<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['login'])) {
    // Simpan pesan ke session supaya bisa dibaca di auth.php
    $_SESSION['pesan'] = "Silakan login terlebih dahulu.";
    header('Location: login.php');
    exit;
}
?>
