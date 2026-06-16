<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .spk-container {
        padding: 40px;
        max-width: 100%;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: transparent;
        min-height: 100vh;
    }

    /* Page Header */
    .spk-page-header {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 50%, #2d4a7c 100%);
        color: white;
        padding: 30px 40px;
        border-radius: 20px;
        margin-bottom: 40px;
        box-shadow: 
            0 10px 40px rgba(10, 30, 66, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .spk-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .spk-page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 1;
    }

    .spk-page-subtitle {
        font-size: 14px;
        opacity: 0.9;
        font-weight: 400;
        position: relative;
        z-index: 1;
    }

    /* Card Wrapper */
    .spk-card-wrapper {
        background: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 35px;
        box-shadow: 
            0 4px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }

    .spk-card-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #0a1e42 0%, #3b82f6 50%, #0a1e42 100%);
    }

    .spk-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 20px;
    }

    .spk-section-title {
        font-size: 24px;
        font-weight: 700;
        color: #0a1e42;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .spk-section-title::before {
        content: '';
        width: 6px;
        height: 30px;
        background: linear-gradient(180deg, #0a1e42 0%, #3b82f6 100%);
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
    }

    /* Action Buttons */
    .spk-action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .spk-btn {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        box-shadow: 
            0 4px 15px rgba(10, 30, 66, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .spk-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .spk-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .spk-btn:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 8px 25px rgba(10, 30, 66, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .spk-btn::after {
        content: '+';
        font-size: 20px;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }

    /* Modern Table Styles */
    .spk-table-container {
        overflow-x: auto;
        border-radius: 12px;
        box-shadow: 0 0 0 1px #e2e8f0;
    }

    .spk-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }

    .spk-table thead {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
    }

    .spk-table thead th {
        padding: 18px 20px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        white-space: nowrap;
    }

    .spk-table thead th:first-child {
        border-radius: 12px 0 0 0;
    }

    .spk-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .spk-table tbody tr {
        background: white;
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .spk-table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        transform: scale(1.01);
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    .spk-table tbody tr:last-child {
        border-bottom: none;
    }

    .spk-table tbody tr:last-child td:first-child {
        border-radius: 0 0 0 12px;
    }

    .spk-table tbody tr:last-child td:last-child {
        border-radius: 0 0 12px 0;
    }

    .spk-table tbody td {
        padding: 18px 20px;
        color: #334155;
        vertical-align: top;
        text-align: center;

    }

    .spk-table tbody tr td:first-child {
        font-weight: 700;
        color: #0a1e42;
        font-size: 15px;
        text-align: center;
    }

    .spk-table tbody tr td:nth-child(2) {
        text-align: left;
    }

    .spk-table tbody tr td:nth-child(4) {
        text-align: left;
    }

    /* Subkriteria Styling */
    .subkriteria-list {
        line-height: 2;
        color: #475569;
    }

    .subkriteria-item {
        padding: 6px 0;
        display: block;
        position: relative;
        padding-left: 16px;
    }

    .subkriteria-item::before {
        content: '▸';
        position: absolute;
        left: 0;
        color: #3b82f6;
        font-weight: bold;
    }

    /* Badge for Attribute */
    .attribute-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .attribute-benefit {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
        border: 1px solid #86efac;
    }

    .attribute-cost {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* Action Buttons in Table */
    .spk-btn-edit,
    .spk-btn-delete {
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .spk-btn-edit {
        background: linear-gradient(135deg, #0b2042ff 0%, #0b2042ff 100%);
        color: white;
    }

    .spk-btn-edit:hover {
        background: linear-gradient(135deg, #1d2a45ff 0%, #1d2a45ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .spk-btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .spk-btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Matrix Table Specific Styles */
    .matrix-table thead th {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .matrix-table tbody td {
        text-align: center;
        font-weight: 600;
        color: #334155;
        border: 1px solid #e2e8f0;
        font-size: 15px;
        vertical-align: middle;
        
    }

    .matrix-table tbody tr td:first-child {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        text-align: left;
        font-weight: 700;
        color: #0a1e42;
        font-size: 14px;
        
    }

    .matrix-table .total-row {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%) !important;
        font-weight: 700;
        color: white !important;
    }

    .matrix-table .total-row td {
        border-top: 3px solid #10274dff;
        color: #0a1e42 !important;
        font-size: 15px;
    }

    /* Delete Button at Bottom */
    .spk-action-bottom {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 2px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    .spk-btn-delete-all {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        box-shadow: 
            0 4px 15px rgba(220, 38, 38, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .spk-btn-delete-all::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: 0;
    }

    .spk-btn-delete-all:hover::before {
        width: 300px;
        height: 300px;
    }

    .spk-btn-delete-all:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 8px 25px rgba(220, 38, 38, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .spk-btn-delete-all span {
        position: relative;
        z-index: 1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .spk-container {
            padding: 20px;
        }

        .spk-page-header {
            padding: 30px 25px;
        }

        .spk-page-title {
            font-size: 28px;
        }

        .spk-card-wrapper {
            padding: 25px;
        }

        .spk-section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .spk-table {
            font-size: 12px;
        }

        .spk-table thead th,
        .spk-table tbody td {
            padding: 12px 10px;
        }

        .spk-action-buttons {
            width: 100%;
            flex-direction: column;
        }

        .spk-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="spk-container">
    <!-- Page Header -->
    <div class="spk-page-header">
        <h1 class="spk-page-title">Data Kriteria</h1>
        <p class="spk-page-subtitle">Kelola kriteria dan perbandingan berpasangan untuk metode AHP</p>
    </div>

    <!-- Tabel Data Kriteria -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Daftar Kriteria</h2>
            <div class="spk-action-buttons">
                <a href="tambah_kriteria.php" class="spk-btn">Tambah Kriteria</a>
            </div>
        </div>
        
        <div class="spk-table-container">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Atribut</th>
                        <th>Subkriteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = $conn->query("SELECT id_criteria, criteria, attribute FROM criterias");

                    while ($row = $query->fetch_assoc()) {
                        $id_criteria = $row['id_criteria'];

                        // Ambil subkriteria
                        $subQuery = $conn->query("SELECT name, value FROM sub_criterias WHERE id_criteria = '$id_criteria'");
                        $subkriteriaList = '';
                        if ($subQuery->num_rows > 0) {
                            $subkriteriaList = '<div class="subkriteria-list">';
                            while ($sub = $subQuery->fetch_assoc()) {
                                $subkriteriaList .= '<span class="subkriteria-item">' . htmlspecialchars($sub['name']) . ' (' . $sub['value'] . ')</span>';
                            }
                            $subkriteriaList .= '</div>';
                        } else {
                            $subkriteriaList = '<i style="color: #94a3b8;">Tidak ada subkriteria</i>';
                        }

                        // Badge untuk atribut
                        $attributeClass = strtolower($row['attribute']) == 'benefit' ? 'attribute-benefit' : 'attribute-cost';
                        $attributeBadge = '<span class="attribute-badge ' . $attributeClass . '">' . htmlspecialchars($row['attribute']) . '</span>';

                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td><strong>" . htmlspecialchars($row['criteria']) . "</strong></td>
                                <td>" . $attributeBadge . "</td>
                                <td>" . $subkriteriaList . "</td>
                                <td>
                                    <a href='edit_kriteria.php?id=" . $id_criteria . "' class='spk-btn-edit'>Edit</a>
                                    <a href='hapus_kriteria.php?id=" . $id_criteria . "' class='spk-btn-delete' onclick=\"return confirm('Yakin ingin menghapus kriteria ini?');\">Hapus</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Matriks Perbandingan -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Matriks Perbandingan Berpasangan</h2>
            <div class="spk-action-buttons">
                <a href="tambah_perbandingan.php" class="spk-btn">Edit Perbandingan</a>
            </div>
        </div>

        <?php
        // Ambil semua kriteria
        $kriteriaQuery = $conn->query("SELECT id_criteria, criteria FROM criterias");
        $kriteriaList = [];
        while ($k = $kriteriaQuery->fetch_assoc()) {
            $kriteriaList[$k['id_criteria']] = $k['criteria'];
        }

        // Ambil semua nilai perbandingan
        $nilaiPerbandingan = [];
        $queryPerbandingan = $conn->query("SELECT * FROM ahp_comparisons");
        while ($row = $queryPerbandingan->fetch_assoc()) {
            $nilaiPerbandingan[$row['kriteria_1']][$row['kriteria_2']] = $row['nilai'];
        }
        ?>

        <div class="spk-table-container">
            <table class="spk-table matrix-table">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <?php foreach ($kriteriaList as $id => $nama) : ?>
                            <th><?= htmlspecialchars($nama) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalKolom = array_fill_keys(array_keys($kriteriaList), '0');

                    foreach ($kriteriaList as $id1 => $nama1) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($nama1) . "</td>";

                        foreach ($kriteriaList as $id2 => $nama2) {
                            if ($id1 == $id2) {
                                $nilai = 1.0;
                            } elseif (isset($nilaiPerbandingan[$id1][$id2])) {
                                $nilai = (float) $nilaiPerbandingan[$id1][$id2];
                            } elseif (isset($nilaiPerbandingan[$id2][$id1])) {
                                $nilai = 1 / (float) $nilaiPerbandingan[$id2][$id1];
                            } else {
                                $nilai = 0;
                            }
                            echo "<td>" . number_format($nilai, 2) . "</td>";

                            $totalKolom[$id2] = bcadd($totalKolom[$id2], $nilai, 12);
                        }
                        echo "</tr>";
                    }

                    // Total kolom
                    if (count($kriteriaList) > 0) {
                        echo "<tr class='total-row'>";
                        echo "<td>Total</td>";
                        foreach ($totalKolom as $total) {
                            echo "<td>" . number_format($total) . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Action Button at Bottom -->
        <div class="spk-action-bottom">
            <a href="hapus_perbandingan.php" class="spk-btn-delete-all" onclick="return confirm('Yakin ingin menghapus semua nilai perbandingan?');">
                <span>Hapus Semua Perbandingan</span>
            </a>
        </div>
    </div>
</div>

<?php include 'part/footer.php'; ?>