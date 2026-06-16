<?php
include 'cek_login.php';
include 'koneksi.php';

// ===== VALIDASI =====
if (!isset($_POST['nilai']) || empty($_POST['nilai'])) {
    echo "<script>
        alert('Tidak ada data yang dikirim!');
        window.location='tambah_perbandingan.php';
    </script>";
    exit;
}

$nilai_matrix = $_POST['nilai'];
$data_to_save = [];
$berhasil = 0;

// ===== PROSES SIMPAN =====
foreach ($nilai_matrix as $i => $row) {
    foreach ($row as $j => $value) {
        if ($i == $j) continue; // diagonal selalu 1

        $value = trim($value);
        if ($value === '') continue;

        $value = (float)$value;
        if ($value <= 0) continue;

        $i = (int)$i;
        $j = (int)$j;

        // Simpan persis input user, tidak dibalik
        $key = "$i-$j";
        $data_to_save[$key] = [
            'id1' => $i,
            'id2' => $j,
            'nilai' => $value
        ];
    }
}

// ===== RESET TABLE =====
$conn->query("TRUNCATE TABLE ahp_comparisons");

// ===== INSERT =====
foreach ($data_to_save as $d) {
    $sql = "INSERT INTO ahp_comparisons (kriteria_1, kriteria_2, nilai)
            VALUES ('{$d['id1']}', '{$d['id2']}', '{$d['nilai']}')";
    if ($conn->query($sql)) {
        $berhasil++;
    }
}

// ===== FEEDBACK =====
if ($berhasil > 0) {
    echo "<script>
        alert('Berhasil menyimpan $berhasil perbandingan kriteria!');
        window.location='kriteria.php';
    </script>";
} else {
    echo "<script>
        alert('Tidak ada data yang tersimpan!');
        window.location='tambah_perbandingan.php';
    </script>";
}
?>
