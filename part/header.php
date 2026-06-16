<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK AHP & SAW</title>
    <link rel="stylesheet" href="assets/general_css/style.css">
</head>
<?php
$page = basename($_SERVER['PHP_SELF'], ".php");
?>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .spk-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0a1e42 0%, #1e3a5f 30%, #2d4a7c 60%, #1e3a5f 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 
                8px 0 40px rgba(10, 30, 66, 0.5),
                inset -2px 0 20px rgba(255, 255, 255, 0.05),
                inset 0 0 100px rgba(255, 255, 255, 0.02);
            z-index: 1000;
            overflow-y: auto;
            border-right: 2px solid rgba(255, 255, 255, 0.1);
        }

        .spk-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.3) 20%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0.3) 80%,
                transparent 100%
            );
            filter: blur(1px);
        }

        .spk-sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .spk-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .spk-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .spk-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .spk-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Brand Section */
        .spk-brand {
            padding: 45px 20px 40px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.15);
            text-align: center;
            background: 
                radial-gradient(circle at center, rgba(255, 255, 255, 0.08) 0%, transparent 70%),
                rgba(255, 255, 255, 0.02);
            position: relative;
            backdrop-filter: blur(10px);
        }

        .spk-brand::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(100, 200, 255, 0.5) 50%, 
                transparent 100%
            );
            filter: blur(2px);
        }

        .spk-brand::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 70%;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.6) 50%, 
                transparent 100%
            );
        }

        .spk-brand-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
        }

        .spk-brand-icon {
            width: 80px;
            height: 80px;
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.1) 100%),
                linear-gradient(225deg, rgba(100, 200, 255, 0.2) 0%, transparent 100%);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            backdrop-filter: blur(20px);
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.5),
                inset 0 2px 1px rgba(255, 255, 255, 0.4),
                inset 0 -2px 1px rgba(0, 0, 0, 0.3),
                0 0 30px rgba(100, 200, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.25);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .spk-brand-icon::before {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(135deg, rgba(100, 200, 255, 0.4), rgba(255, 255, 255, 0.2), transparent);
            border-radius: 24px;
            opacity: 0;
            transition: opacity 0.4s ease;
            filter: blur(4px);
        }

        .spk-brand-icon::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4) 0%, transparent 60%);
            border-radius: 22px;
            opacity: 0.5;
        }

        .spk-brand-icon:hover {
            transform: scale(1.1) translateY(-5px) rotate(5deg);
            box-shadow: 
                0 20px 50px rgba(0, 0, 0, 0.6),
                inset 0 2px 1px rgba(255, 255, 255, 0.5),
                inset 0 -2px 1px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(100, 200, 255, 0.5);
        }

        .spk-brand-icon:hover::before {
            opacity: 1;
        }

        .spk-brand-text h1 {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            text-shadow: 
                0 3px 15px rgba(0, 0, 0, 0.4),
                0 0 30px rgba(255, 255, 255, 0.2),
                0 1px 3px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        .spk-brand-text p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 1px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
        }

        /* Navigation */
        .spk-nav {
            padding: 25px 0;
        }

        .spk-nav-list {
            list-style: none;
            padding: 0 20px;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .spk-nav-item {
            width: 100%;
        }

        .spk-nav-link {
            display: block;
            padding: 17px 22px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: 16px;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            letter-spacing: 0.4px;
            margin-right: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid transparent;
        }

        .spk-nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, 
                #60a5fa 0%, 
                #3b82f6 25%,
                #2563eb 50%, 
                #3b82f6 75%,
                #60a5fa 100%
            );
            border-radius: 0 5px 5px 0;
            transform: translateX(-5px);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0);
            filter: blur(0.5px);
        }

        .spk-nav-link::after {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            transition: left 0.6s ease;
        }

        .spk-nav-link:hover::after {
            left: 100%;
        }

        .spk-nav-link:hover {
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.08) 100%),
                rgba(255, 255, 255, 0.05);
            color: white;
            padding-left: 34px;
            box-shadow: 
                0 5px 20px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.15),
                inset 0 -2px 4px rgba(0, 0, 0, 0.1);
            transform: translateX(4px) scale(1.02);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .spk-nav-link:hover::before {
            transform: translateX(0);
            box-shadow: 
                0 0 25px rgba(59, 130, 246, 0.8),
                2px 0 15px rgba(59, 130, 246, 0.5);
        }

        .spk-nav-link.active {
            background: 
                linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%),
                linear-gradient(to right, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            color: #0a1e42;
            font-weight: 600;
            box-shadow: 
                0 10px 35px rgba(0, 0, 0, 0.4),
                inset 0 2px 2px rgba(255, 255, 255, 0.9),
                inset 0 -2px 2px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(10, 30, 66, 0.1),
                0 0 40px rgba(59, 130, 246, 0.2);
            padding-left: 34px;
            transform: translateX(5px) scale(1.02);
            border: 1px solid rgba(255, 255, 255, 0.4);
            letter-spacing: 0.5px;
        }

        .spk-nav-link.active::before {
            transform: translateX(0);
            background: 
                linear-gradient(180deg, #0a1e42 0%, #1e3a5f 25%, #2d4a7c 50%, #1e3a5f 75%, #0a1e42 100%);
            box-shadow: 
                3px 0 15px rgba(10, 30, 66, 0.6),
                0 0 30px rgba(10, 30, 66, 0.4),
                inset 0 0 10px rgba(255, 255, 255, 0.1);
            width: 5px;
        }

        .spk-nav-link.active::after {
            display: none;
        }

        .spk-nav-link.active:hover {
            transform: translateX(7px) scale(1.04);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.5),
                inset 0 2px 2px rgba(255, 255, 255, 1),
                inset 0 -2px 2px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(10, 30, 66, 0.2),
                0 0 50px rgba(59, 130, 246, 0.3);
        }

        /* Main Content Area */
        .spk-content-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
        }

        .spk-main {
            padding: 40px;
            min-height: 100vh;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .spk-sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }

            .spk-content-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .spk-brand {
                padding: 20px;
            }

            .spk-brand-text h1 {
                font-size: 16px;
            }

            .spk-brand-text p {
                font-size: 11px;
            }

            .spk-nav {
                padding: 15px 0;
            }

            .spk-nav-list {
                padding: 0 12px;
            }

            .spk-nav-link {
                padding: 12px 16px;
                font-size: 13px;
            }
        }
    </style>

    <!-- Sidebar -->
    <aside class="spk-sidebar">
        <div class="spk-brand">
            <div class="spk-brand-content">
                <div class="spk-brand-icon">📊</div>
                <div class="spk-brand-text">
                    <h1>SPK AHP & SAW</h1>
                    <p>Decision Support System</p>
                </div>
            </div>
        </div>

        <nav class="spk-nav">
            <ul class="spk-nav-list">
                <li class="spk-nav-item">
                    <a href="index.php" class="spk-nav-link <?= ($page == 'index') ? 'active' : '' ?>">Beranda</a>
                </li>
                <li class="spk-nav-item">
                    <a href="kriteria.php" class="spk-nav-link <?= ($page == 'kriteria') ? 'active' : '' ?>">Kriteria</a>
                </li>
                <li class="spk-nav-item">
                    <a href="alternatif.php" class="spk-nav-link <?= ($page == 'alternatif') ? 'active' : '' ?>">Alternatif</a>
                </li>
                <li class="spk-nav-item">
                    <a href="nilai.php" class="spk-nav-link <?= ($page == 'nilai') ? 'active' : '' ?>">Nilai</a>
                </li>
                <li class="spk-nav-item">
                    <a href="perhitungan.php" class="spk-nav-link <?= ($page == 'perhitungan') ? 'active' : '' ?>">Perhitungan AHP</a>
                </li>
                <li class="spk-nav-item">
                    <a href="perhitungan_saw.php" class="spk-nav-link <?= ($page == 'perhitungan_saw') ? 'active' : '' ?>">Perhitungan SAW</a>
                </li>
                <li class="spk-nav-item">
                    <a href="hasil.php" class="spk-nav-link <?= ($page == 'hasil') ? 'active' : '' ?>">Hasil</a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="spk-content-wrapper">
        <main class="spk-main">