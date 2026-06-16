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
        font-size: 22px;
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
        height: 28px;
        background: linear-gradient(180deg, #0a1e42 0%, #3b82f6 100%);
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
    }

    /* Modern Table Styles */
    .spk-table-container {
        overflow-x: auto;
        border-radius: 12px;
        box-shadow: 0 0 0 1px #e2e8f0;
        margin-bottom: 20px;
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
        padding: 16px 18px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        white-space: nowrap;
        vertical-align: middle;
    }

    .spk-table thead th:first-child {
        border-radius: 12px 0 0 0;
        text-align: left;
    }

    .spk-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .spk-table tbody tr {
        background: white;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
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
        padding: 14px 18px;
        color: #334155;
        vertical-align: middle;
        text-align: center;
        font-weight: 500;
    }

    .spk-table tbody tr td:first-child {
        font-weight: 600;
        color: #0a1e42;
        text-align: left;
    }

    /* Total Row Styling */
    .spk-table tbody tr.total-row {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        font-weight: 700;
    }

    .spk-table tbody tr.total-row td {
        color: #0a1e42;
        border-top: 2px solid #cbd5e1;
    }

    /* Result Badge */
    .result-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .result-konsisten {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
        border: 2px solid #86efac;
    }

    .result-tidak-konsisten {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border: 2px solid #fca5a5;
    }

    /* Parameter Table Styling */
    .parameter-table {
        max-width: 700px;
        margin: 0 auto;
    }

    .parameter-table tbody tr:nth-child(odd) {
        background: #f8fafc;
    }

    .parameter-table tbody tr td:first-child {
        font-weight: 700;
        color: #0a1e42;
        text-align: center;
        width: 120px;
    }

    .parameter-table tbody tr td:nth-child(2) {
        text-align: center;
        font-weight: 700;
        color: #1e40af;
        width: 140px;
    }

    .parameter-table tbody tr td:nth-child(3) {
        text-align: left;
        color: #475569;
        font-weight: 500;
    }

    .parameter-table tbody tr:last-child {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-top: 3px solid #cbd5e1;
    }

    .parameter-table tbody tr:last-child td {
        font-weight: 700;
        color: #0a1e42;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        padding: 16px 20px;
        border-radius: 12px;
        margin: 20px 0;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .info-box-icon {
        font-size: 14px;
        color: #92400e;
        flex-shrink: 0;
        line-height: 1.6;
    }

    .info-box-text {
        font-size: 14px;
        color: #78350f;
        line-height: 1.6;
        font-weight: 500;
        flex: 1;
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
            padding: 10px 8px;
        }

        .parameter-table {
            max-width: 100%;
        }
    }
</style>

<div class="spk-container">
    <!-- Page Header -->
    <div class="spk-page-header">
        <h1 class="spk-page-title">Hasil Perhitungan AHP</h1>
        <p class="spk-page-subtitle">Proses perhitungan bobot kriteria menggunakan metode Analytical Hierarchy Process</p>
    </div>

    <?php include 'proses_ahp.php'; ?>
</div>

<?php include 'part/footer.php'; ?>