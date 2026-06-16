<?php
include 'koneksi.php'; // Pastikan koneksi sudah benar

// Ambil semua kriteria
$criterias = [];
$result = $conn->query("SELECT id_criteria AS id, criteria AS name FROM criterias ORDER BY id_criteria ASC");
while ($row = $result->fetch_assoc()) {
    $criterias[] = $row;
}

// Misal: kita tetapkan bobot sementara (contoh manual, nanti bisa kamu setting dinamis)
$priorities = [
    1 => 0.4, // Harga
    2 => 0.3, // Merek
    3 => 0.2, // Konsumsi BB
    4 => 0.1  // 125CC
];

// Jika mau otomatis dari database ahp_weights:
$check = $conn->query("SELECT id_criteria, weight FROM ahp_weights");
if ($check->num_rows > 0) {
    $priorities = [];
    while ($row = $check->fetch_assoc()) {
        $priorities[$row['id_criteria']] = $row['weight'];
    }
}

// Hapus data pairwise sebelumnya
$conn->query("DELETE FROM ahp_comparisons");

// Rekonstruksi matrix perbandingan baru berdasarkan bobot
foreach ($criterias as $c1) {
    foreach ($criterias as $c2) {
        $id1 = $c1['id'];
        $id2 = $c2['id'];
        
        if ($id1 == $id2) {
            $nilai = 1;
        } else {
            $nilai = $priorities[$id1] / $priorities[$id2];
        }

        // Simpan ke database ahp_comparisons
        $conn->query("INSERT INTO ahp_comparisons (kriteria_1, kriteria_2, nilai) VALUES ('$id1', '$id2', '$nilai')");
    }
}

echo "Matrix pairwise sudah diperbaiki otomatis berdasarkan bobot prioritas!";
?>
