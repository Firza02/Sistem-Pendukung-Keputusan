<?php include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php'; ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .spk-dashboard {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Header Section */
    .spk-header-section {
        text-align: center;
        margin-bottom: 50px;
    }

    .spk-dashboard-title {
        font-size: 36px;
        font-weight: 700;
        color: #0a1e42;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .spk-subtitle {
        font-size: 16px;
        color: #64748b;
        font-weight: 400;
    }

    /* Welcome Banner */
    .spk-welcome-banner {
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
        padding: 25px 40px;
        border-radius: 16px;
        margin-bottom: 40px;
        box-shadow: 0 8px 24px rgba(10, 30, 66, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .spk-welcome-banner .icon {
        font-size: 32px;
    }

    .spk-welcome-banner .text {
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    /* Group Info Card */
    .spk-group-card {
        background: white;
        border-radius: 16px;
        padding: 35px 40px;
        margin-bottom: 50px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .spk-group-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .spk-group-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #ebebebff 0%, #ffffffff 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .spk-group-title {
        font-size: 24px;
        font-weight: 700;
        color: #0a1e42;
        line-height: 48px; /* SAMA PERSIS DENGAN HEIGHT ICON (48px) */
        margin: 0;
    }

    .spk-members-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .spk-member-item {
        padding: 15px 20px;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 3px solid #0a1e42;
        transition: all 0.3s ease;
    }

    .spk-member-item:hover {
        background: #f1f5f9;
        transform: translateX(5px);
    }

    .spk-member-name {
        font-weight: 600;
        color: #0a1e42;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .spk-member-nim {
        font-size: 14px;
        color: #64748b;
    }

    /* Cards Section */
    .spk-cards-section {
        margin-top: 50px;
    }

    .spk-section-title {
        font-size: 22px;
        font-weight: 700;
        color: #0a1e42;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .spk-section-title::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(180deg, #0a1e42 0%, #1e3a5f 100%);
        border-radius: 2px;
    }

    .spk-dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .spk-card {
        background: white;
        padding: 28px 24px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        text-decoration: none;
        color: #334155;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .spk-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #0a1e42;
        transition: width 0.3s ease;
    }

    .spk-card:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .spk-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(10, 30, 66, 0.15);
        border-color: #0a1e42;
    }

    .spk-card-content {
        position: relative;
        z-index: 1;
    }

    .spk-card-icon {
        font-size: 32px;
        margin-bottom: 12px;
        display: block;
    }

    .spk-card-title {
        font-size: 17px;
        font-weight: 600;
        color: #0a1e42;
        margin-bottom: 6px;
        display: block;
    }

    .spk-card-count {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    /* Color Variations for Cards */
    .spk-card:nth-child(1)::before { background: #0a1e42; }
    .spk-card:nth-child(2)::before { background: #1e3a5f; }
    .spk-card:nth-child(3)::before { background: #2d5382; }
    .spk-card:nth-child(4)::before { background: #0a1e42; }
    .spk-card:nth-child(5)::before { background: #1e3a5f; }

    /* Responsive Design */
    @media (max-width: 768px) {
        .spk-dashboard {
            padding: 20px 15px;
        }

        .spk-dashboard-title {
            font-size: 28px;
        }

        .spk-welcome-banner {
            padding: 20px 25px;
            flex-direction: column;
            text-align: center;
        }

        .spk-welcome-banner .text {
            font-size: 18px;
        }

        .spk-group-card {
            padding: 25px 20px;
        }

        .spk-group-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .spk-members-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .spk-dashboard-cards {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .spk-card {
            padding: 20px 18px;
        }

        .spk-card-icon {
            font-size: 28px;
        }

        .spk-card-title {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .spk-dashboard-title {
            font-size: 24px;
        }

        .spk-welcome-banner .icon {
            font-size: 28px;
        }

        .spk-welcome-banner .text {
            font-size: 16px;
        }

        .spk-group-title {
            font-size: 20px;
        }
    }
</style>


<div class="spk-dashboard">
    <!-- Header Section -->
    <div class="spk-header-section">
        <h1 class="spk-dashboard-title">Dashboard SPK</h1>
        <p class="spk-subtitle">Sistem Pendukung Keputusan Metode AHP - SAW </p>
    </div>

    <!-- Welcome Banner -->
    <div class="spk-welcome-banner">
        <span class="icon">👋</span>
        <span class="text">Selamat Datang di Sistem Pendukung Keputusan</span>
    </div>

    <!-- Group Info Card -->
    <div class="spk-group-card">
        <div class="spk-group-header">
            <div class="spk-group-icon">👥</div>
            <h2 class="spk-group-title">Kelompok 12</h2>
        </div>
        
        <div class="spk-members-grid">
            <div class="spk-member-item">
                <div class="spk-member-name">Muhammad Firza Pahlevi</div>
                <div class="spk-member-nim">22082010094</div>
            </div>
            
            <div class="spk-member-item">
                <div class="spk-member-name">Zahrah Aliyah Rachman</div>
                <div class="spk-member-nim">22082010103</div>
            </div>
            
            <div class="spk-member-item">
                <div class="spk-member-name">Aliyyah Nabilah Farahdita</div>
                <div class="spk-member-nim">22082010122</div>
            </div>
            
            <div class="spk-member-item">
                <div class="spk-member-name">Fahryan Putra Ramadi</div>
                <div class="spk-member-nim">22082010189</div>
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="spk-cards-section">
        <h3 class="spk-section-title">Menu Navigasi</h3>
        
        <div class="spk-dashboard-cards">
            <a href="kriteria.php" class="spk-card">
                <div class="spk-card-content">
                    <span class="spk-card-icon">📊</span>
                    <strong class="spk-card-title">Data Kriteria</strong>
                    <span class="spk-card-count">5 Kriteria tersedia</span>
                </div>
            </a>
            
            <a href="alternatif.php" class="spk-card">
                <div class="spk-card-content">
                    <span class="spk-card-icon">🎯</span>
                    <strong class="spk-card-title">Data Alternatif</strong>
                    <span class="spk-card-count">50 Alternatif tersedia</span>
                </div>
            </a>
            
            <a href="perhitungan.php" class="spk-card">
                <div class="spk-card-content">
                    <span class="spk-card-icon">🔢</span>
                    <strong class="spk-card-title">Data Perhitungan AHP</strong>
                    <span class="spk-card-count">Proses perhitungan AHP</span>
                </div>
            </a>
            <a href="perhitungan_saw.php" class="spk-card">
            <div class="spk-card-content">
                <span class="spk-card-icon">📈</span>
                <strong class="spk-card-title">Perhitungan SAW</strong>
                <span class="spk-card-count">Proses perhitungan SAW</span>
            </div>
        </a>

        <!-- Card baru: Nilai -->
        <a href="nilai.php" class="spk-card">
            <div class="spk-card-content">
                <span class="spk-card-icon">💹</span>
                <strong class="spk-card-title">Nilai</strong>
                <span class="spk-card-count">Lihat nilai alternatif</span>
            </div>
        </a>
            <a href="hasil.php" class="spk-card">
                <div class="spk-card-content">
                    <span class="spk-card-icon">🏆</span>
                    <strong class="spk-card-title">Hasil Akhir</strong>
                    <span class="spk-card-count">50 Hasil ranking</span>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include 'part/footer.php'; ?>