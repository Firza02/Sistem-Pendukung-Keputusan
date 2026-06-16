<?php

// Ambil kriteria
$kriteria = [];
$result = $conn->query("SELECT id_criteria, criteria FROM criterias");
while ($row = $result->fetch_assoc()) {
    $kriteria[$row['id_criteria']] = $row['criteria'];
}

$missingComparisons = []; // untuk catat pasangan yang belum ada

// Ambil nilai perbandingan
$perbandingan = [];
foreach ($kriteria as $id1 => $nama1) {
    foreach ($kriteria as $id2 => $nama2) {
        if ($id1 == $id2) {
            $perbandingan[$id1][$id2] = 1;
        } else {
            $query = $conn->query("SELECT nilai FROM ahp_comparisons WHERE kriteria_1 = '$id1' AND kriteria_2 = '$id2'");
            if ($query->num_rows > 0) {
                $row = $query->fetch_assoc();
                $perbandingan[$id1][$id2] = (float) $row['nilai'];
            } else {
                $query = $conn->query("SELECT nilai FROM ahp_comparisons WHERE kriteria_1 = '$id2' AND kriteria_2 = '$id1'");
                if ($query->num_rows > 0) {
                    $row = $query->fetch_assoc();
                    $perbandingan[$id1][$id2] = 1 / (float) $row['nilai'];
                } else {
                    $perbandingan[$id1][$id2] = null; // tandai belum diisi
                    $missingComparisons[] = [$nama1, $nama2];
                }
            }
        }
    }
}
if (!empty($missingComparisons)) {
    echo '<div class="info-box" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left: 4px solid #dc2626; margin-bottom:20px;">
            <span class="info-box-icon" style="color:#991b1b;">⚠️</span>
            <p class="info-box-text" style="color:#7f1d1d;">Ada kriteria baru yang belum diisi perbandingan:<br>';
    foreach ($missingComparisons as $pair) {
        echo '- ' . htmlspecialchars($pair[0]) . ' vs ' . htmlspecialchars($pair[1]) . '<br>';
    }
    echo 'Silakan lengkapi perbandingan ini sebelum melanjutkan perhitungan.</p>
          </div>';
}
// Hitung total kolom
$totalKolom = array_fill_keys(array_keys($kriteria), 0);
foreach ($kriteria as $id2 => $nama2) {
    foreach ($kriteria as $id1 => $nama1) {
        $totalKolom[$id2] += $perbandingan[$id1][$id2];
    }
}

// Matriks Normalisasi
$normalisasi = [];
foreach ($kriteria as $id1 => $nama1) {
    foreach ($kriteria as $id2 => $nama2) {
        $normalisasi[$id1][$id2] = $perbandingan[$id1][$id2] / $totalKolom[$id2];
    }
}

// Jumlah baris normalisasi & Prioritas
$jumlahBaris = [];
$prioritas = [];
foreach ($kriteria as $id1 => $nama1) {
    $jumlahBaris[$id1] = array_sum($normalisasi[$id1]);
    $prioritas[$id1] = $jumlahBaris[$id1] / count($kriteria);
}

// Hitung Eigen Value
$eigenValue = [];
foreach ($kriteria as $id1 => $nama1) {
    $eigenValue[$id1] = 0;
    foreach ($kriteria as $id2 => $nama2) {
        $eigenValue[$id1] += $perbandingan[$id1][$id2] * $prioritas[$id2];
    }
}

// Lambda Ratio
$lambdaRatio = [];
foreach ($kriteria as $id => $nama) {
    if ($prioritas[$id] > 0) {
        $lambdaRatio[$id] = $eigenValue[$id] / $prioritas[$id];
    } else {
        $lambdaRatio[$id] = 0;
    }
}

// Hitung Lambda Max
$lambdaValues = [];
foreach ($kriteria as $id1 => $nama1) {
    if ($prioritas[$id1] != 0) {
        $lambdaValues[] = $eigenValue[$id1] / $prioritas[$id1];
    }
}
$lambdaMax = array_sum($lambdaValues) / count($lambdaValues);

// Hitung CI dan CR
$n = count($kriteria);
$CI = ($lambdaMax - $n) / ($n - 1);
$RI = [
    1 => 0.00,
    2 => 0.00,
    3 => 0.58,
    4 => 0.90,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.45,
    10 => 1.49
];
$CR = ($RI[$n] != 0) ? $CI / $RI[$n] : 0;
$hasilKonsistensi = ($CR <= 0.10) ? "Konsisten" : "Tidak Konsisten";

// Simpan bobot ke database
foreach ($prioritas as $id => $weight) {
    $stmt = $conn->prepare("INSERT INTO ahp_weights (id_criteria, weight) VALUES (?, ?) ON DUPLICATE KEY UPDATE weight = VALUES(weight)");
    $stmt->bind_param("id", $id, $weight);
    $stmt->execute();
}
?>

<!-- Matriks Perbandingan Berpasangan -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Matriks Perbandingan Berpasangan</h2>
    </div>

    <div class="spk-table-container">
        <table class="spk-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <?php foreach ($kriteria as $nama) : ?>
                        <th><?= htmlspecialchars($nama) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kriteria as $id1 => $nama1) : ?>
                    <tr>
                        <td><?= htmlspecialchars($nama1) ?></td>
                        <?php foreach ($kriteria as $id2 => $nama2) : ?>
                            <td><?= round($perbandingan[$id1][$id2], 2) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>Total</td>
                    <?php foreach ($kriteria as $id => $nama) : ?>
                        <td><?= round($totalKolom[$id]) ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Matriks Normalisasi -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Matriks Normalisasi</h2>
    </div>

    <div class="info-box">
        <span class="info-box-icon">💡Matriks normalisasi diperoleh dengan membagi setiap elemen matriks perbandingan dengan total kolomnya.
        </span>
    </div>

    <div class="spk-table-container">
        <table class="spk-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <?php foreach ($kriteria as $nama) : ?>
                        <th><?= htmlspecialchars($nama) ?></th>
                    <?php endforeach; ?>
                    <th>Jumlah</th>
                    <th>Bobot Kriteria</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kriteria as $id1 => $nama1) : ?>
                    <tr>
                        <td><?= htmlspecialchars($nama1) ?></td>
                        <?php foreach ($kriteria as $id2 => $nama2) : ?>
                            <td><?= round($normalisasi[$id1][$id2], 3) ?></td>
                        <?php endforeach; ?>
                        <td><?= round($jumlahBaris[$id1], 3) ?></td>
                        <td><strong><?= round($prioritas[$id1], 3) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Perhitungan Lambda -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Perhitungan Lambda (λᵢ)</h2>
    </div>

    <div class="spk-table-container">
        <table class="spk-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <?php foreach ($kriteria as $nama) : ?>
                        <th>a(<?= htmlspecialchars($nama) ?>) × w(<?= htmlspecialchars($nama) ?>)</th>
                    <?php endforeach; ?>
                    <th>λᵢ</th>
                    <th>Eigen Value (λᵢ/wᵢ)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kriteria as $id1 => $nama1) : ?>
                    <tr>
                        <td><?= htmlspecialchars($nama1) ?></td>
                        <?php
                        $lambda_i = 0;
                        foreach ($kriteria as $id2 => $nama2) :
                            $aij = $perbandingan[$id1][$id2];
                            $wj  = $prioritas[$id2];
                            $hasil = $aij * $wj;
                            $lambda_i += $hasil;
                        ?>
                            <td><?= round($hasil, 3) ?></td>
                        <?php endforeach; ?>
                        <td><?= round($lambda_i, 4) ?></td>
                        <td><?= round($lambda_i / $prioritas[$id1], 4) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Consistency Check -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Uji Konsistensi (Consistency Check)</h2>
    </div>

    <div class="spk-table-container">
        <table class="spk-table parameter-table">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Nilai</th>
                    <th>Keterangan / Rumus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>λ max</td>
                    <td><?= round($lambdaMax, 4) ?></td>
                    <td>λ max = Rata-rata Eigen Value (λᵢ / wᵢ)</td>
                </tr>
                <tr>
                    <td>CI</td>
                    <td><?= round($CI, 4) ?></td>
                    <td>CI = (λ max − n) / (n − 1)</td>
                </tr>
                <tr>
                    <td>RI</td>
                    <td><?= $RI[$n] ?></td>
                    <td>RI = Indeks Acak Saaty untuk n = <?= $n ?></td>
                </tr>
                <tr>
                    <td>CR</td>
                    <td><?= round($CR, 4) ?></td>
                    <td>CR = CI / RI</td>
                </tr>
                <tr>
                    <td>Hasil</td>
                    <td>
                        <span class="result-badge <?= ($CR <= 0.10) ? 'result-konsisten' : 'result-tidak-konsisten' ?>">
                            <?= $hasilKonsistensi ?>
                        </span>
                    </td>
                    <td>
                        <?= ($CR <= 0.10)
                            ? "Konsisten karena CR ≤ 0,10"
                            : "Tidak konsisten karena CR > 0,10"; ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php if ($CR > 0.10) : ?>
        <div class="info-box" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left-color: #dc2626;">
            <span class="info-box-icon" style="color: #991b1b;">⚠️</span>
            <p class="info-box-text" style="color: #7f1d1d;">
                <strong>Perhatian!</strong> Hasil perhitungan tidak konsisten. Silakan periksa kembali nilai perbandingan berpasangan Anda.
            </p>
        </div>

    <?php else : ?>
        <div class="info-box" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-left-color: #16a34a;">
            <span class="info-box-icon" style="color: #166534;">✅ <strong>Selamat!</strong> Hasil perhitungan konsisten. Anda dapat melanjutkan ke proses perangkingan alternatif.
            </span>
        </div>
    <?php endif; ?>
</div>