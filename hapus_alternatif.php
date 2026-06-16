<?php
include 'koneksi.php';

// Cek apakah ada ID yang dikirimkan lewat URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // pastikan ID aman

    // Hapus evaluasi yang terkait (jika ada relasi ke tabel evaluations)
    $conn->query("DELETE FROM evaluations WHERE id_alternative = $id");

    // Hapus dari tabel alternatives
    $hapus = $conn->query("DELETE FROM alternatives WHERE id_alternative = $id");

    if ($hapus) {
        echo "<script>
            alert('Alternatif berhasil dihapus.');
            window.location.href = 'alternatif.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus alternatif.');
            window.location.href = 'alternatif.php';
        </script>";
    }
} else {
    // Kalau tidak ada ID, langsung balik ke halaman alternatif
    header('Location: alternatif.php');
    exit();
}
?>
