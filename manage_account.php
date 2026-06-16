<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

// Ambil id user dari session
$id_user = $_SESSION['id_user'];

$error = '';
$success = '';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek password lama
    $query = $conn->query("SELECT password FROM users WHERE id_user = '$id_user'");
    $user = $query->fetch_assoc();

    if (!$user || !password_verify($password_lama, $user['password'])) {
        $error = "Password lama salah!";
    } else {
        // Cek konfirmasi password baru
        if ($password_baru !== $konfirmasi_password) {
            $error = "Konfirmasi password tidak cocok!";
        } else {
            // Update password baru (dihash)
            $hashedPassword = password_hash($password_baru, PASSWORD_DEFAULT);
            $update = $conn->query("UPDATE users SET password = '$hashedPassword' WHERE id_user = '$id_user'");

            if ($update) {
                $success = "Password berhasil diubah!";
            } else {
                $error = "Gagal mengubah password, coba lagi.";
            }
        }
    }
}
?>

<div class="spk-container">
    <h2 class="spk-title">Ganti Password</h2>

    <?php if (!empty($error)): ?>
        <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="spk-form">
        <div class="spk-form-group">
            <label>Password Lama:</label>
            <input type="password" name="password_lama" required>
        </div>

        <div class="spk-form-group">
            <label>Password Baru:</label>
            <input type="password" name="password_baru" required>
        </div>

        <div class="spk-form-group">
            <label>Konfirmasi Password Baru:</label>
            <input type="password" name="konfirmasi_password" required>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="spk-btn">Ubah Password</button>
        </div>
    </form>
</div>

<?php include 'part/footer.php'; ?>
