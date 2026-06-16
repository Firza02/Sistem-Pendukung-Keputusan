<?php 
include 'part/header.php';
include 'koneksi.php';

// --- LOGIKA PHP DITARUH DI ATAS (Agar tidak error undefined variable) ---
$msg = ''; 
$msgType = ''; 
$berhasil = 0;
$gagal = 0;

// 1. LOGIKA SIMPAN MANUAL
if (isset($_POST['simpan'])) {
    $name = trim($_POST['name']);
    if(!empty($name)){
        $query = $conn->query("INSERT INTO alternatives (name) VALUES ('$name')");
        if ($query) {
            $msgType = 'success';
            $msg = "Berhasil menambahkan data manual: <b>$name</b>";
        } else {
            $msgType = 'error';
            $msg = "Gagal menambahkan data manual.";
        }
    }
}

// 2. LOGIKA UPLOAD CSV
if (isset($_POST['upload_csv'])) {
    if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != "") {
        $fileName = $_FILES['file_csv']['tmp_name'];
        $ekstensi = pathinfo($_FILES['file_csv']['name'], PATHINFO_EXTENSION);
        
        if($ekstensi == 'csv') {
            $file = fopen($fileName, "r");
            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                // Cek agar baris kosong tidak dihitung
                if(isset($column[0]) && !empty($column[0])) {
                    $name = mysqli_real_escape_string($conn, $column[0]);
                    $sql = "INSERT INTO alternatives (name) VALUES ('$name')";
                    if (mysqli_query($conn, $sql)) { 
                        $berhasil++; 
                    } else { 
                        $gagal++; 
                    }
                }
            }
            fclose($file);
            
            // Set pesan sukses
            $msgType = 'success_csv';
            $msg = "Proses Import Selesai.";
        } else {
            $msgType = 'error';
            $msg = "Format file salah! Harap upload file .csv";
        }
    }
}
?>

<style>
    .alert-box {
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 5px;
        font-size: 14px;
        border: 1px solid transparent;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    .stats-summary {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(0,0,0,0.1);
        display: flex;
        gap: 20px;
    }
</style>

<div class="spk-container spk-form-alternatif">
    <h2 class="spk-title">Tambah Alternatif</h2>

    <?php if ($msg != ''): ?>
        <?php if ($msgType == 'success_csv'): ?>
            <div class="alert-box alert-success">
                <h4 style="margin: 0 0 5px 0;">✅ Import Data Berhasil!</h4>
                <div class="stats-summary">
                    <span>Sukses Masuk: <b><?php echo $berhasil; ?></b> data</span>
                    <span style="color: <?php echo ($gagal > 0) ? 'red' : 'inherit'; ?>">Gagal: <b><?php echo $gagal; ?></b> data</span>
                </div>
                <div style="margin-top:15px;">
                    <a href="alternatif.php" style="background:#155724; color:white; padding:5px 10px; text-decoration:none; border-radius:4px; font-size:12px;">Lihat Data &rarr;</a>
                </div>
            </div>
        
        <?php elseif ($msgType == 'success'): ?>
            <div class="alert-box alert-success">
                ✅ <?php echo $msg; ?>
            </div>

        <?php else: ?>
            <div class="alert-box alert-error">
                ❌ <?php echo $msg; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <div style="margin-bottom: 30px; border-bottom: 2px dashed #ddd; padding-bottom: 20px;">
        <h3>Opsi 1: Input Manual</h3>
        <form class="spk-form" method="post" action="">
            <label class="spk-label">Nama Alternatif</label>
            <div style="margin-top:8px;">
                <input class="spk-input" type="text" name="name" placeholder="Contoh: SmartHome..." style="width:100%;">
            </div>
            <button class="spk-btn" type="submit" name="simpan" style="margin-top:10px; width:100%;">
                Simpan Manual
            </button>
        </form>
    </div>

    <div>
        <h3>Opsi 2: Upload File CSV (Massal)</h3>
        <p style="font-size: 14px; color: #666; margin-bottom: 10px;">
            *Format file harus <strong>.csv</strong>. Isi kolom pertama dengan Nama Alternatif.
        </p>

        <form class="spk-form" method="post" action="" enctype="multipart/form-data">
            <label class="spk-label">Pilih File CSV</label>
            
            <div style="margin-top:8px;">
                <input class="spk-input" type="file" name="file_csv" required style="width:100%; padding: 8px;">
            </div>

            <button class="spk-btn" type="submit" name="upload_csv" style="margin-top:18px; width:100%; background-color: #28a745; border-color: #28a745;">
                Upload & Import Data
            </button>
        </form>
    </div>

    <a href="alternatif.php"
       style="
            margin-top:20px;
            width:100%;
            display:inline-block;
            padding:12px;
            border-radius:10px;
            text-align:center;
            font-weight:600;
            text-decoration:none;
            background:#ffffff;
            color:#0a1e42;
            border:2px solid #0a1e42;
       ">
       Kembali / Batal
    </a>

</div>

<?php include 'part/footer.php'; ?>