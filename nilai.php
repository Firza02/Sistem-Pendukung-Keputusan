<?php
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

    /* Modern Table Styles */
    .spk-table-container {
        overflow-x: auto;
        border-radius: 12px;
        box-shadow: 0 0 0 1px #e2e8f0;
        margin-bottom: 30px;
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
        vertical-align: middle;
    }

    .spk-table thead th:first-child {
        border-radius: 12px 0 0 0;
        text-align: left;
        min-width: 200px;
        max-width: 200px;
        width: 200px;
    }

    .spk-table thead th:not(:first-child) {
        min-width: 220px;
        max-width: 220px;
        width: 220px;
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
        transform: scale(1.005);
        box-shadow: 
            0 2px 10px rgba(0, 0, 0, 0.05),
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
        vertical-align: middle;
        text-align: center;
    }

    .spk-table tbody tr td:first-child {
        font-weight: 600;
        color: #0a1e42;
        font-size: 15px;
        text-align: left;
        min-width: 200px;
        max-width: 200px;
        width: 200px;
    }

    .spk-table tbody td:not(:first-child) {
        min-width: 220px;
        max-width: 220px;
        width: 220px;
    }

    /* Select Dropdown Styling */
    .spk-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
        outline: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .spk-select:hover {
        border-color: #94a3b8;
        background: white;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .spk-select:focus {
        border-color: #0a1e42;
        background: white;
        box-shadow: 
            0 0 0 4px rgba(10, 30, 66, 0.1),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .spk-select option {
        padding: 10px;
    }

    /* Read-only Value Display */
    .spk-value-display {
        display: inline-block;
        padding: 10px 20px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 10px;
        font-weight: 600;
        color: #334155;
        font-size: 14px;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Action Buttons Section */
    .spk-action-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding: 25px 0;
        margin-top: 10px;
        border-top: 2px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .spk-action-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Button Styles */
    .spk-btn {
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        position: relative;
    }

    .spk-btn span {
        position: relative;
        z-index: 1;
    }

    .spk-btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .spk-btn-danger {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .spk-btn-success {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    /* Info Banner */
    .spk-info-banner {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .spk-info-icon {
        font-size: 14px;
        color: #1e40af;
        flex-shrink: 0;
        line-height: 1.6;
    }

    .spk-info-text {
        font-size: 14px;
        color: #1e3a8a;
        line-height: 1.6;
        font-weight: 500;
        flex: 1;
        margin: 0;
        padding: 0;
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
            font-size: 24px;
        }

        .spk-card-wrapper {
            padding: 25px;
        }

        .spk-table {
            font-size: 12px;
        }

        .spk-table thead th,
        .spk-table tbody td {
            padding: 12px 10px;
        }

        .spk-action-section {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .spk-action-group {
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
        <h1 class="spk-page-title">Penilaian Alternatif</h1>
        <p class="spk-page-subtitle">Input nilai alternatif terhadap setiap kriteria yang telah ditentukan</p>
    </div>

    <!-- Form Penilaian -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Form Input Penilaian</h2>
        </div>

        <div class="spk-info-banner">
            <span class="spk-info-icon">ℹ️  Pilih nilai subkriteria untuk setiap alternatif. Pastikan semua kolom terisi sebelum menyimpan.</span>
        </div>

        <form method="post" action="">
            <div class="spk-table-container">
                <table class="spk-table">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            <?php
                            $kriteria = $conn->query("SELECT * FROM criterias");
                            $kriteriaArray = [];
                            while ($k = $kriteria->fetch_assoc()) {
                                $kriteriaArray[] = $k;
                                echo "<th>" . htmlspecialchars($k['criteria']) . "</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $alternatif = $conn->query("SELECT * FROM alternatives");
                        while ($a = $alternatif->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($a['name']) . "</td>";

                            foreach ($kriteriaArray as $k) {
                                $subs = $conn->query("SELECT * FROM sub_criterias WHERE id_criteria = '{$k['id_criteria']}' ORDER BY value DESC");

                                $cek = $conn->query("SELECT value FROM evaluations WHERE id_alternative = '{$a['id_alternative']}' AND id_criteria = '{$k['id_criteria']}'");
                                $selectedValue = ($cek->num_rows > 0) ? $cek->fetch_assoc()['value'] : '';

                                echo "<td>
                                    <select name='nilai[{$a['id_alternative']}][{$k['id_criteria']}]' class='spk-select' required>
                                        <option value=''>-- Pilih --</option>";
                                while ($s = $subs->fetch_assoc()) {
                                    $selected = ($s['value'] == $selectedValue) ? 'selected' : '';
                                    echo "<option value='{$s['value']}' $selected>" . htmlspecialchars($s['name']) . " ({$s['value']})</option>";
                                }
                                echo "</select>
                                </td>";
                            }

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="spk-action-section">
                <button type="submit" name="simpan" class="spk-btn spk-btn-primary">
                    <span>Simpan Penilaian</span>
                </button>
                <a href="perhitungan_saw.php" class="spk-btn spk-btn-success">
                    <span>Hitung Sekarang</span>
                </a>
                <button type="submit" name="hapus" class="spk-btn spk-btn-danger" onclick="return confirm('Yakin ingin menghapus semua penilaian?')">
                    <span>Hapus Semua</span>
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST['hapus'])) {
            $conn->query("DELETE FROM evaluations");
            echo "<script>
                alert('Semua penilaian berhasil dihapus.');
                window.location.href='nilai.php';
            </script>";
        }

        if (isset($_POST['simpan'])) {
            $nilai = $_POST['nilai'];

            foreach ($nilai as $id_alternative => $kriteria_nilai) {
                foreach ($kriteria_nilai as $id_criteria => $value) {
                    $cek = $conn->query("SELECT * FROM evaluations WHERE id_alternative = '$id_alternative' AND id_criteria = '$id_criteria'");
                    if ($cek->num_rows > 0) {
                        $conn->query("UPDATE evaluations SET value = '$value' WHERE id_alternative = '$id_alternative' AND id_criteria = '$id_criteria'");
                    } else {
                        $conn->query("INSERT INTO evaluations (id_alternative, id_criteria, value) VALUES ('$id_alternative', '$id_criteria', '$value')");
                    }
                }
            }

            echo "<script>
                alert('Penilaian berhasil disimpan.');
                window.location.href='nilai.php';
            </script>";
        }
        ?>
    </div>

    <!-- Tabel Data Tersimpan -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Data Penilaian Tersimpan</h2>
        </div>

        <div class="spk-table-container">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        <?php
                        foreach ($kriteriaArray as $k) {
                            echo "<th>" . htmlspecialchars($k['criteria']) . "</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $alternatif = $conn->query("SELECT * FROM alternatives");
                    while ($a = $alternatif->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($a['name']) . "</td>";

                        foreach ($kriteriaArray as $k) {
                            $cek = $conn->query("SELECT value FROM evaluations WHERE id_alternative = '{$a['id_alternative']}' AND id_criteria = '{$k['id_criteria']}'");
                            $val = ($cek->num_rows > 0) ? $cek->fetch_assoc()['value'] : '-';
                            echo "<td><span class='spk-value-display'>" . htmlspecialchars($val) . "</span></td>";
                        }

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'part/footer.php'; ?>