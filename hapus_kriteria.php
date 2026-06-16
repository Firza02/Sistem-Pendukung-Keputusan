<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_criteria = intval($_GET['id']);

    // Cek apakah kriteria ada
    $cek = $conn->query("SELECT * FROM criterias WHERE id_criteria = $id_criteria");

    if ($cek->num_rows > 0) {
        // Hapus subkriteria dulu (opsional, jika tidak pakai ON DELETE CASCADE)
        $conn->query("DELETE FROM sub_criterias WHERE id_criteria = $id_criteria");

        // Hapus kriteria
        $delete = $conn->query("DELETE FROM criterias WHERE id_criteria = $id_criteria");

        if ($delete) {
            header("Location: kriteria.php?msg=hapus_berhasil");
            exit();
        } else {
            echo "<p class='spk-error'>Gagal menghapus kriteria.</p>";
        }
    } else {
        echo "<p class='spk-error'>Kriteria tidak ditemukan.</p>";
    }
} else {
    echo "<p class='spk-error'>ID kriteria tidak valid.</p>";
}
?>
