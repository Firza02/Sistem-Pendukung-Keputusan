<?php
include 'koneksi.php';

// Ambil semua kriteria
$kriteria = $conn->query("SELECT * FROM criterias ORDER BY id_criteria ASC");
$kriteria_arr = [];
while ($row = $kriteria->fetch_assoc()) {
    $kriteria_arr[] = $row;
}

// Membuat matriks kosong
$matriks = [];
foreach ($kriteria_arr as $k1) {
    foreach ($kriteria_arr as $k2) {
        if ($k1['id_criteria'] == $k2['id_criteria']) {
            $matriks[$k1['id_criteria']][$k2['id_criteria']] = 1;
        } else {
            // Ambil langsung nilai dari ahp_comparisons
            $query = $conn->query("SELECT nilai FROM ahp_comparisons 
                WHERE kriteria_1 = {$k1['id_criteria']} AND kriteria_2 = {$k2['id_criteria']} 
                LIMIT 1");

            if ($query->num_rows > 0) {
                $row = $query->fetch_assoc();
                $matriks[$k1['id_criteria']][$k2['id_criteria']] = $row['nilai'];
            } else {
                // Tidak ada data? Lebih baik error
                die("Perbandingan antara {$k1['criteria']} dan {$k2['criteria']} belum diinput!");
            }
        }
    }
}
?>

<h2>Matriks Perbandingan AHP</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Kriteria</th>
            <?php foreach ($kriteria_arr as $k) : ?>
                <th><?= htmlspecialchars($k['criteria']) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($kriteria_arr as $k1) : ?>
            <tr>
                <td><?= htmlspecialchars($k1['criteria']) ?></td>
                <?php foreach ($kriteria_arr as $k2) : ?>
                    <td><?= round($matriks[$k1['id_criteria']][$k2['id_criteria']], 4) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
