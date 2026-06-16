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
        vertical-align: middle;
        text-align: center;
    }

    .spk-table tbody tr td:first-child {
        font-weight: 600;
        color: #0a1e42;
        font-size: 15px;
        text-align: center;
    }

    .spk-table tbody tr td:nth-child(2) {
        text-align: left;
        font-weight: 500;
        color: #1e293b;
        font-size: 15px;
    }

    /* Action Buttons in Table */
    .spk-table-action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        align-items: center;
    }

    .spk-btn-edit,
    .spk-btn-delete {
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .spk-btn-edit {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        color: white;
    }

    .spk-btn-edit:hover {
        background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(71, 85, 105, 0.4);
    }

    .spk-btn-delete {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
        color: white;
    }

    .spk-btn-delete:hover {
        background: linear-gradient(135deg, #be123c 0%, #9f1239 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state-text {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .empty-state-subtext {
        font-size: 14px;
        opacity: 0.7;
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

        .spk-table-action-buttons {
            flex-direction: column;
            gap: 6px;
        }

        .spk-btn-edit,
        .spk-btn-delete {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="spk-container">
    <!-- Page Header -->
    <div class="spk-page-header">
        <h1 class="spk-page-title">Data Alternatif</h1>
        <p class="spk-page-subtitle">Kelola data alternatif untuk proses perhitungan metode AHP</p>
    </div>

    <!-- Tabel Data Alternatif -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Daftar Alternatif</h2>
            <div class="spk-action-buttons">
                <a href="tambah_alternatif.php" class="spk-btn">Tambah Alternatif</a>
            </div>
        </div>
        
        <div class="spk-table-container">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alternatif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $conn->query("SELECT * FROM alternatives");
                    
                    if ($query->num_rows > 0) {
                        $no = 1;
                        while ($row = $query->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>
                                        <div class='spk-table-action-buttons'>
                                            <a href='edit_alternatif.php?id=" . $row['id_alternative'] . "' class='spk-btn-edit'>Edit</a>
                                            <a href='hapus_alternatif.php?id=" . $row['id_alternative'] . "' class='spk-btn-delete' onclick=\"return confirm('Yakin ingin menghapus alternatif ini?');\">Hapus</a>
                                        </div>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='3'>
                                    <div class='empty-state'>
                                        <div class='empty-state-icon'>📋</div>
                                        <div class='empty-state-text'>Belum Ada Data Alternatif</div>
                                        <div class='empty-state-subtext'>Silakan tambahkan alternatif baru dengan klik tombol di atas</div>
                                    </div>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'part/footer.php'; ?>