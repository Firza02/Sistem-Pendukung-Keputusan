<?php
include 'koneksi.php';

if (isset($_POST['nilai'])) {
    $conn->query("DELETE FROM ahp_comparisons");

    foreach ($_POST['nilai'] as $kriteria1 => $arr) {
        foreach ($arr as $kriteria2 => $nilai_input) {
            $kriteria1 = intval($kriteria1);
            $kriteria2 = intval($kriteria2);

            // Cek jika pecahan
            if (strpos($nilai_input, '/') !== false) {
                $parts = explode('/', $nilai_input);
                $nilai = bcdiv($parts[0], $parts[1], 12); // Lebih presisi
            } else {
                $nilai = floatval($nilai_input);
            }

            $nilai = floatval($nilai); // pastikan tipe float

            // Simpan nilai asli
            $stmt = $conn->prepare("INSERT INTO ahp_comparisons (kriteria_1, kriteria_2, nilai) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $kriteria1, $kriteria2, $nilai);
            $stmt->execute();
            $stmt->close();

            // Simpan kebalikan kalau bukan diagonal
            if ($kriteria1 != $kriteria2) {
                $nilai_kebalikan = 1 / $nilai;
                $stmt2 = $conn->prepare("INSERT INTO ahp_comparisons (kriteria_1, kriteria_2, nilai) VALUES (?, ?, ?)");
                $stmt2->bind_param("iid", $kriteria2, $kriteria1, $nilai_kebalikan);
                $stmt2->execute();
                $stmt2->close();
            }
        }
    }

    header("Location: kriteria.php?simpan=berhasil");
    exit();
} else {
    header("Location: kriteria.php?simpan=gagal");
    exit();
}

?>
