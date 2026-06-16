<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

// Ambil nama alternatif
$alternatif = [];
$result = $conn->query("SELECT id_alternative, name FROM alternatives");
while ($row = $result->fetch_assoc()) {
    $alternatif[$row['id_alternative']] = $row['name'];
}

// Ambil skor final SAW
$skor = [];
$tanggal = [];
$result = $conn->query("SELECT * FROM saw_results");
while ($row = $result->fetch_assoc()) {
    $skor[$row['id_alternative']] = $row['final_score'];
    $tanggal[$row['id_alternative']] = $row['created_at'];
}

// Urutkan dari skor tertinggi ke rendah
arsort($skor);

// Hitung ranking
$peringkat = [];
$ranking = 1;
foreach ($skor as $id_alternative => $nilai) {
    $peringkat[$id_alternative] = $ranking++;
}
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
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .spk-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }

    /* Winner Box */
    .winner-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #f59e0b;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 20px;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }

    .winner-icon {
        font-size: 36px;
        flex-shrink: 0;
    }

    .winner-content {
        flex: 0 1 auto;
        max-width: 600px;
    }

    .winner-title {
        font-size: 13px;
        font-weight: 600;
        color: #78350f;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .winner-name {
        font-size: 22px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 4px;
    }

    .winner-score {
        font-size: 14px;
        color: #78350f;
        font-weight: 600;
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
    }

    .spk-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .spk-table tbody tr {
        background: white;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .spk-table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
        padding: 16px 18px;
        color: #334155;
        vertical-align: middle;
        text-align: center;
        font-weight: 500;
    }

    .spk-table tbody tr td:first-child {
        font-weight: 600;
        color: #0a1e42;
    }

    .spk-table tbody tr td:nth-child(2) {
        text-align: left;
        font-weight: 600;
        color: #1e293b;
        font-size: 15px;
    }

    /* Ranking Badge */
    .ranking-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        min-width: 40px;
    }

    .ranking-1 {
        background: linear-gradient(135deg, #fde68a 0%, #fbbf24 100%);
        color: #78350f;
        border: 2px solid #f59e0b;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .ranking-2 {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        border: 2px solid #94a3b8;
        box-shadow: 0 2px 8px rgba(148, 163, 184, 0.3);
    }

    .ranking-3 {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #7c2d12;
        border: 2px solid #f97316;
        box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
    }

    .ranking-other {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border: 2px solid #cbd5e1;
    }

    /* Highlight Top 3 */
    .spk-table tbody tr.rank-1 {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }

    .spk-table tbody tr.rank-2 {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    }

    .spk-table tbody tr.rank-3 {
        background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
    }

    /* Score Highlight */
    .score-value {
        font-weight: 700;
        color: #1e40af;
        font-size: 15px;
    }

    /* PDF Specific Styles */
    .pdf-header {
        text-align: center;
        padding: 30px 20px;
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .pdf-header h1 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .pdf-header p {
        font-size: 13px;
        opacity: 0.9;
    }

    .pdf-winner-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 3px solid #f59e0b;
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .pdf-winner-icon {
        font-size: 42px;
        flex-shrink: 0;
    }

    .pdf-winner-content {
        flex: 1;
    }

    .pdf-winner-title {
        font-size: 12px;
        font-weight: 700;
        color: #78350f;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .pdf-winner-name {
        font-size: 22px;
        font-weight: 800;
        color: #92400e;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .pdf-winner-score {
        font-size: 14px;
        color: #78350f;
        font-weight: 700;
    }

    .pdf-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
        font-size: 11px;
        color: #64748b;
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

        .winner-name {
            font-size: 20px;
        }

        .spk-table {
            font-size: 12px;
        }

        .spk-table thead th,
        .spk-table tbody td {
            padding: 12px 10px;
        }

        .spk-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        
        #hasil-table, #hasil-table * {
            visibility: visible;
        }
        
        #hasil-table {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .spk-table-container {
            box-shadow: none;
            border: 1px solid #333;
        }

        .spk-table thead {
            background: #0a1e42 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .spk-table tbody tr.rank-1 {
            background: #fef3c7 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .spk-table tbody tr.rank-2 {
            background: #f1f5f9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .spk-table tbody tr.rank-3 {
            background: #ffedd5 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .ranking-badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div class="spk-container">
    <!-- Page Header -->
    <div class="spk-page-header">
        <h1 class="spk-page-title">Hasil Akhir Perangkingan</h1>
        <p class="spk-page-subtitle">Hasil akhir perangkingan alternatif berdasarkan metode AHP-SAW</p>
    </div>

    <!-- Winner Announcement -->
    <?php
    $pemenangId = array_key_first($skor);
    $pemenangNama = $alternatif[$pemenangId];
    $pemenangSkor = $skor[$pemenangId];
    ?>
    <div class="winner-box">
        <div class="winner-icon">🏆</div>
        <div class="winner-content">
            <div class="winner-title">Alternatif Terbaik</div>
            <div class="winner-name"><?= htmlspecialchars($pemenangNama) ?></div>
            <div class="winner-score">Skor Akhir: <?= round($pemenangSkor, 4) ?></div>
        </div>
    </div>

    <!-- Hasil Tabel -->
    <div class="spk-card-wrapper">
        <div class="spk-section-header">
            <h2 class="spk-section-title">Tabel Hasil Perangkingan</h2>
            <button onclick="downloadPDF()" class="spk-btn">
                <span>📄 Unduh PDF</span>
            </button>
        </div>

        <div id="hasil-table">
            <div class="spk-table-container">
                <table class="spk-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alternatif</th>
                            <th>Skor Akhir</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($skor as $id_alternative => $nilai) :
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
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($alternatif[$id_alternative]) ?></td>
                                <td><span class="score-value"><?= round($nilai, 4) ?></span></td>
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
    </div>
</div>

<?php include 'part/footer.php'; ?>

<!-- Library html2pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadPDF() {
        // Create clean PDF structure
        const wrapper = document.createElement('div');
        wrapper.style.cssText = 'padding: 30px; background: white; font-family: Arial, sans-serif;';
        
        // Header
        const header = document.createElement('div');
        header.style.cssText = 'text-align: center; margin-bottom: 30px; padding: 20px; background: #0a1e42; border-radius: 8px;';
        header.innerHTML = `
            <h1 style="font-size: 24px; color: #ffffff; margin-bottom: 5px; font-weight: bold;">HASIL AKHIR PERANGKINGAN</h1>
            <p style="font-size: 12px; color: #ffffff; margin: 0; opacity: 0.9;">Metode AHP-SAW</p>
            <p style="font-size: 11px; color: #ffffff; margin: 5px 0 0 0; opacity: 0.9;">Tanggal: ${new Date().toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            })}</p>
        `;
        
        // Winner section
        const winner = document.createElement('div');
        winner.style.cssText = 'background: #fffbeb; border: 2px solid #f59e0b; border-radius: 8px; padding: 20px; margin-bottom: 25px;';
        winner.innerHTML = `
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="font-size: 40px;">🏆</div>
                <div>
                    <div style="font-size: 11px; color: #78350f; font-weight: bold; margin-bottom: 5px; text-transform: uppercase;">Alternatif Terbaik</div>
                    <div style="font-size: 18px; color: #92400e; font-weight: bold; margin-bottom: 3px;"><?= htmlspecialchars($pemenangNama) ?></div>
                    <div style="font-size: 13px; color: #78350f; font-weight: 600;">Skor Akhir: <?= round($pemenangSkor, 4) ?></div>
                </div>
            </div>
        `;
        
        // Table
        const tableWrapper = document.createElement('div');
        tableWrapper.style.cssText = 'margin: 20px 0;';
        
        const tableTitle = document.createElement('h2');
        tableTitle.style.cssText = 'font-size: 16px; color: #0a1e42; margin-bottom: 15px; font-weight: bold;';
        tableTitle.textContent = 'Tabel Perangkingan';
        
        const table = document.createElement('table');
        table.style.cssText = 'width: 100%; border-collapse: collapse; font-size: 11px;';
        
        // Table header
        table.innerHTML = `
            <thead>
                <tr style="background: #0a1e42; color: white;">
                    <th style="padding: 12px 8px; text-align: center; border: 1px solid #0a1e42; font-weight: bold; background: #0a1e42;">No</th>
                    <th style="padding: 12px 8px; text-align: left; border: 1px solid #0a1e42; font-weight: bold; background: #0a1e42;">Nama Alternatif</th>
                    <th style="padding: 12px 8px; text-align: center; border: 1px solid #0a1e42; font-weight: bold; background: #0a1e42;">Skor Akhir</th>
                    <th style="padding: 12px 8px; text-align: center; border: 1px solid #0a1e42; font-weight: bold; background: #0a1e42;">Ranking</th>
                </tr>
            </thead>
        `;
        
        const tbody = document.createElement('tbody');
        
        <?php
        $no = 1;
        foreach ($skor as $id_alternative => $nilai) :
            $rank = $peringkat[$id_alternative];
            $bgColor = '#ffffff';
            if ($rank == 1) $bgColor = '#fef3c7';
            elseif ($rank == 2) $bgColor = '#f1f5f9';
            elseif ($rank == 3) $bgColor = '#ffedd5';
            
            $rankBg = '#f1f5f9';
            $rankColor = '#475569';
            if ($rank == 1) {
                $rankBg = '#fde68a';
                $rankColor = '#78350f';
            } elseif ($rank == 2) {
                $rankBg = '#e2e8f0';
                $rankColor = '#1e293b';
            } elseif ($rank == 3) {
                $rankBg = '#fed7aa';
                $rankColor = '#7c2d12';
            }
        ?>
        
        const row<?= $no ?> = document.createElement('tr');
        row<?= $no ?>.style.cssText = 'background: <?= $bgColor ?>;';
        row<?= $no ?>.innerHTML = `
            <td style="padding: 10px 8px; text-align: center; border: 1px solid #e2e8f0; font-weight: 600;"><?= $no ?></td>
            <td style="padding: 10px 8px; text-align: left; border: 1px solid #e2e8f0; font-weight: 600;"><?= htmlspecialchars($alternatif[$id_alternative]) ?></td>
            <td style="padding: 10px 8px; text-align: center; border: 1px solid #e2e8f0; font-weight: bold; color: #1e40af;"><?= round($nilai, 4) ?></td>
            <td style="padding: 10px 8px; text-align: center; border: 1px solid #e2e8f0;">
                <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; background: <?= $rankBg ?>; color: <?= $rankColor ?>; font-weight: bold; font-size: 11px;"><?= $rank ?></span>
            </td>
        `;
        tbody.appendChild(row<?= $no ?>);
        
        <?php 
            $no++;
        endforeach; 
        ?>
        
        table.appendChild(tbody);
        tableWrapper.appendChild(tableTitle);
        tableWrapper.appendChild(table);
        
        // Footer
        const footer = document.createElement('div');
        footer.style.cssText = 'text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #64748b;';
        footer.innerHTML = `
            <p style="margin: 0; font-weight: bold;">Sistem Pendukung Keputusan</p>
            <p style="margin: 5px 0 0 0;">Dokumen ini dibuat secara otomatis oleh sistem</p>
        `;
        
        // Assemble
        wrapper.appendChild(header);
        wrapper.appendChild(winner);
        wrapper.appendChild(tableWrapper);
        wrapper.appendChild(footer);
        
        // PDF options
        const opt = {
            margin: 0.5,
            filename: 'Hasil_Perangkingan_' + new Date().toISOString().slice(0,10) + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(wrapper).save();
    }
</script>