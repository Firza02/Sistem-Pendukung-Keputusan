<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Hapus semua isi tabel ahp_comparisons
    $hapus = $conn->query("DELETE FROM ahp_comparisons");

    if ($hapus) {
        header("Location: kriteria.php?hapus=berhasil");
        exit();
    } else {
        header("Location: kriteria.php?hapus=gagal");
        exit();
    }
} else {
    header("Location: kriteria.php?hapus=invalid");
    exit();
}
?>
