<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini!');
        window.location.href = 'index.php';
    </script>";
    exit;
}

// Ambil perbandingan yang sudah ada (hanya satu arah dari DB)
$existing = [];
$qExist = $conn->query("SELECT kriteria_1, kriteria_2, nilai FROM ahp_comparisons");
while ($r = $qExist->fetch_assoc()) {
    $id1 = $r['kriteria_1'];
    $id2 = $r['kriteria_2'];
    $val = (float)$r['nilai'];
    $existing[$id1][$id2] = $val;
}

// Ambil daftar kriteria
$kriteria = [];
$qk = $conn->query("SELECT id_criteria, criteria FROM criterias ORDER BY id_criteria ASC");
while ($row = $qk->fetch_assoc()) {
    $kriteria[] = $row;
}
?>


<style>
/* ===== GLOBAL STYLE (SAMA DG TAMBAH KRITERIA) ===== */
.spk-container {
    padding: 40px;
    max-width: 1200px;
    margin: auto;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.spk-title {
    font-size: 28px;
    font-weight: 700;
    color: #0a1e42;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 3px solid #0a1e42;
    display: flex;
    align-items: center;
    gap: 12px;
}

.spk-title::before {
    content: "📊";
    font-size: 30px;
}

/* ===== INFO BOX (PETUNJUK) ===== */
.spk-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 2px solid #60a5fa;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 25px;
}

.spk-info strong {
    display: block;
    color: #1e3a8a;
    margin-bottom: 6px;
}

.spk-info ul {
    padding-left: 18px;
    color: #1e40af;
    font-size: 14px;
}

/* ===== CARD ===== */
.spk-card {
    background: white;
    padding: 35px;
    border-radius: 20px;
    border-left: 6px solid #0a1e42 !important;
    box-shadow: 
        0 4px 20px rgba(0,0,0,0.08),
        0 0 0 1px rgba(0,0,0,0.05);
}

/* ===== TABLE ===== */
.spk-table-wrapper {
    overflow-x: auto;
}

.spk-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.spk-table th,
.spk-table td {
    border: 2px solid #e2e8f0;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.spk-table thead th {
    background: #ffffffff;
    color: white;
    font-weight: 600;
}

/* 👉 HEADER BARIS KIRI (NAMA KRITERIA) — PUTIH */
.spk-table tbody th {
    background: #ffffff;
    color: #ffffff;
    font-weight: 600;
}

/* ZEBRA ROW (BIAR GA CAPEK LIAT) */
.spk-table tbody tr:nth-child(even) {
    background: #f8fafc;
}

.spk-table tbody tr:hover {
    background: #eef4ff;
}

/* ===== INPUT ===== */
.spk-input {
    width: 70px;
    padding: 8px;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    text-align: center;
    font-size: 13px;
}

.spk-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

.spk-input[readonly] {
    background: #e5e7eb;
    font-weight: bold;
}

/* ===== BUTTONS ===== */
.spk-actions {
    margin-top: 30px;
    padding-top: 25px;
    border-top: 2px solid #f1f5f9;
    display: flex;
    gap: 14px;
}

.spk-btn {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(10,30,66,0.3);
}

.spk-btn:hover {
    box-shadow: 0 6px 16px rgba(10,30,66,0.4);
}

.spk-btn-cancel {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    background: white;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.spk-btn-cancel:hover {
    background: #f8fafc;
}
</style>

<div class="spk-container">
    <h2 class="spk-title">Perbandingan Kriteria (AHP)</h2>

    <!-- ✅ PETUNJUK PENGISIAN -->
    <div class="spk-info">
        <strong>Petunjuk Pengisian:</strong>
        <ul>
            <li>Isi nilai tingkat kepentingan antar kriteria (nilai AHP 1–9).</li>
            <li>Jika kriteria baris lebih penting dari kolom, isi nilai > 1.</li>
            <li>Jika kriteria baris kurang penting dari kolom, isi nilai < 1 (contoh: 0.33, 0.5).</li>
            <li>Nilai diagonal (kriteria dengan dirinya sendiri) otomatis bernilai <b>1</b>.</li>
        </ul>
    </div>

     <div class="spk-card">
        <form action="simpan_edit_perbandingan.php" method="post">
            <div class="spk-table-wrapper">
                <table class="spk-table">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <?php foreach ($kriteria as $k): ?>
                                <th><?= htmlspecialchars($k['criteria']) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kriteria as $a): ?>
                            <tr>
                                <th><?= htmlspecialchars($a['criteria']) ?></th>
                                <?php foreach ($kriteria as $b): ?>
                                    <td>
                                        <?php if ($a['id_criteria'] == $b['id_criteria']): ?>
                                            <input type="text" value="1" readonly class="spk-input">
                                        <?php else: ?>
                                            <?php
                                            // Ambil nilai existing, kalau belum ada set default 0
                                            $val = 0;
                                            if (isset($existing[$a['id_criteria']][$b['id_criteria']])) {
                                                $val = $existing[$a['id_criteria']][$b['id_criteria']];
                                            } elseif (isset($existing[$b['id_criteria']][$a['id_criteria']])) {
                                                $val = 1 / $existing[$b['id_criteria']][$a['id_criteria']];
                                            }
                                            ?>
                                            <input type="number"
                                                step="any"
                                                min="0.0001"
                                                name="nilai[<?= $a['id_criteria'] ?>][<?= $b['id_criteria'] ?>]"
                                                class="spk-input"
                                                value="<?= htmlspecialchars(round($val, 4)) ?>"
                                                placeholder="-">
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <div class="spk-actions">
                <button type="submit" class="spk-btn">Simpan Perbandingan</button>
                <a href="kriteria.php" class="spk-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include 'part/footer.php'; ?>