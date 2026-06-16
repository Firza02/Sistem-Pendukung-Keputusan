<?php

// Ambil data kriteria
$kriteria = [];
$result = $conn->query("SELECT id_criteria, criteria, attribute FROM criterias");
while ($row = $result->fetch_assoc()) {
    $kriteria[$row['id_criteria']] = [
        'nama' => $row['criteria'],
        'attribute' => $row['attribute']
    ];
}

// Ambil data alternatif
$alternatif = [];
$result = $conn->query("SELECT id_alternative, name FROM alternatives");
while ($row = $result->fetch_assoc()) {
    $alternatif[$row['id_alternative']] = $row['name'];
}

// Ambil data evaluasi
$evaluasi = [];
$result = $conn->query("SELECT * FROM evaluations");
while ($row = $result->fetch_assoc()) {
    $evaluasi[$row['id_alternative']][$row['id_criteria']] = $row['value'];
}

// Ambil bobot AHP
$bobot = [];
$result = $conn->query("SELECT id_criteria, weight FROM ahp_weights");
while ($row = $result->fetch_assoc()) {
    $bobot[$row['id_criteria']] = $row['weight'];
}

// Cari nilai max dan min
// cari nilai max & min
$nilaiMaxMin = [];
foreach ($kriteria as $id_kriteria => $data) {
    $nilai = [];
    foreach ($alternatif as $id_alternative => $nama) {

        if (!isset($evaluasi[$id_alternative][$id_kriteria])) {
            // lewati alternatif yang belum punya nilai
            continue;
        }

        $nilai[] = $evaluasi[$id_alternative][$id_kriteria];
    }

    if (empty($nilai)) {
        // kalau masih kosong, paksa 1 biar tidak division by zero
        $nilaiMaxMin[$id_kriteria] = ['max' => 1, 'min' => 1];
    } else {
        $nilaiMaxMin[$id_kriteria] = [
            'max' => max($nilai),
            'min' => min($nilai)
        ];
    }
}


// Normalisasi
$normalisasi = [];
foreach ($alternatif as $id_alternative => $nama) {
    foreach ($kriteria as $id_kriteria => $data) {

        if (!isset($evaluasi[$id_alternative][$id_kriteria])) {
            // kalau belum dinilai, kasih 0 saja
            $normalisasi[$id_alternative][$id_kriteria] = 0;
            continue;
        }

        if ($data['attribute'] == 'benefit') {
            $den = $nilaiMaxMin[$id_kriteria]['max'] ?: 1; // kalau 0, ganti 1
            $normalisasi[$id_alternative][$id_kriteria] =
                $evaluasi[$id_alternative][$id_kriteria] / $den;
        } else {
            $den = $evaluasi[$id_alternative][$id_kriteria] ?: 1;
            $normalisasi[$id_alternative][$id_kriteria] =
                $nilaiMaxMin[$id_kriteria]['min'] / $den;
        }
    }
}
// Hitung nilai normalisasi * bobot
$nilai_terbobot = [];
foreach ($alternatif as $id_alternative => $nama) {
    foreach ($kriteria as $id_kriteria => $data) {
        $nilai_terbobot[$id_alternative][$id_kriteria] = $normalisasi[$id_alternative][$id_kriteria] * $bobot[$id_kriteria];
    }
}

// Hitung total skor
$skor = [];
foreach ($alternatif as $id_alternative => $nama) {
    $total = 0;
    foreach ($kriteria as $id_kriteria => $data) {
        $total += $nilai_terbobot[$id_alternative][$id_kriteria];
    }
    $skor[$id_alternative] = $total;
}

// Ranking
arsort($skor);
$peringkat = [];
$ranking = 1;
foreach ($skor as $id_alternative => $total) {
    $peringkat[$id_alternative] = $ranking++;
}

// Simpan hasil ke tabel saw_results
$dateNow = date('Y-m-d H:i:s');
$conn->query("DELETE FROM saw_results");

$stmt = $conn->prepare("INSERT INTO saw_results (id_alternative, final_score, created_at) VALUES (?, ?, ?)");
foreach ($skor as $id_alternative => $total) {
    $stmt->bind_param("ids", $id_alternative, $total, $dateNow);
    $stmt->execute();
}
$stmt->close();

// Ambil pemenang (ranking 1)
$pemenangId = array_key_first($skor);
$pemenangNama = $alternatif[$pemenangId];
$pemenangSkor = $skor[$pemenangId];
?>

<!-- Matriks Normalisasi -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Matriks Normalisasi</h2>
    </div>

    <div class="info-box">
        <span class="info-box-icon">💡Normalisasi dilakukan dengan rumus: <strong>Benefit:</strong> Rij = Xij / Max(Xij) | <strong>Cost:</strong> Rij = Min(Xij) / Xij</span>
    </div>

    <div class="spk-table-container">
        <table class="spk-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <?php foreach ($kriteria as $k) : ?>
                        <th><?= htmlspecialchars($k['nama']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alternatif as $id_alternative => $nama) : ?>
                    <tr>
                        <td><?= htmlspecialchars($nama) ?></td>
                        <?php foreach ($kriteria as $id_kriteria => $k) : ?>
                            <td><?= round($normalisasi[$id_alternative][$id_kriteria], 2) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Perankingan -->
<div class="spk-card-wrapper">
    <div class="spk-section-header">
        <h2 class="spk-section-title">Perangkingan (Normalisasi × Bobot)</h2>
    </div>

    <div class="info-box">
        <span class="info-box-icon">📊 Nilai akhir dihitung dengan mengalikan nilai normalisasi dengan bobot kriteria dari AHP, kemudian dijumlahkan.
        </span>
    </div>

    <div class="spk-table-container">
        <table class="spk-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <?php foreach ($kriteria as $k) : ?>
                        <th><?= htmlspecialchars($k['nama']) ?></th>
                    <?php endforeach; ?>
                    <th>Total Skor</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($skor as $id_alternative => $total) :
                    $rank = $peringkat[$id_alternative];
                    $rankClass = '';
                    if ($rank == 1) $rankClass = 'rank-1';
                    elseif ($rank == 2) $rankClass = 'rank-2';
                    elseif ($rank == 3) $rankClass = 'rank-3';

                    $badgeClass = 'ranking-other';
                    if ($rank == 1) $badgeClass = 'ranking-1';
                    elseif ($rank == 2) $badgeClass = 'ranking-2';
                    elseif ($rank == 3) $badgeClass = 'ranking-3';
                ?>
                    <tr class="<?= $rankClass ?>">
                        <td><?= htmlspecialchars($alternatif[$id_alternative]) ?></td>
                        <?php foreach ($kriteria as $id_kriteria => $k) : ?>
                            <td><?= round($nilai_terbobot[$id_alternative][$id_kriteria], 4) ?></td>
                        <?php endforeach; ?>
                        <td class="total-score"><?= round($total, 4) ?></td>
                        <td>
                            <span class="ranking-badge <?= $badgeClass ?>">
                                <?= $rank ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Summary Info -->
<div class="info-box" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-left-color: #16a34a;">
    <span class="info-box-icon" style="color: #166534;">✅ <strong>Perhitungan Selesai!</strong> Alternatif terbaik adalah <strong><?= htmlspecialchars($pemenangNama) ?></strong> dengan total skor <strong><?= round($pemenangSkor, 4) ?></strong>
    </span>
</div>