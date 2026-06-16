<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data alternatif berdasarkan ID
    $query = $conn->query("SELECT * FROM alternatives WHERE id_alternative = $id");
    $data = $query->fetch_assoc();

    if (!$data) {
        echo "<p>Alternatif tidak ditemukan!</p>";
        include 'part/footer.php';
        exit();
    }
} else {
    echo "<p>ID Alternatif tidak ditemukan!</p>";
    include 'part/footer.php';
    exit();
}

// Proses update jika form disubmit
if (isset($_POST['submit'])) {
    $nama = $conn->real_escape_string($_POST['name']);

    $update = $conn->query("UPDATE alternatives SET name = '$nama' WHERE id_alternative = $id");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='alternatif.php';</script>";
    } else {
        echo "<p>Gagal mengupdate data!</p>";
    }
}
?>

<div class="spk-container spk-edit">
    <h2 class="spk-title">Edit Alternatif</h2>

    <form method="POST" class="spk-form">
        
        <!-- FIELD -->
        <div class="spk-form-group" style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:8px; font-weight:600;">
                Nama Alternatif
            </label>
            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($data['name']); ?>"
                required
                class="spk-input"
                style="width:100%;">
        </div>

        <!-- BUTTON SIMPAN -->
        <button
            type="submit"
            name="submit"
            class="spk-btn"
            style="width:100%; margin-top:10px;">
            Simpan Perubahan
        </button>

        <!-- ✅ BUTTON BATAL (DI BAWAH & UKURAN SAMA) -->
        <a
            href="alternatif.php"
            style="
                margin-top:10px;
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
            Batal
        </a>

    </form>
</div>

<?php include 'part/footer.php'; ?>
