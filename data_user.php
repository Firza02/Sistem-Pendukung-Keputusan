<?php
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

// Cek apakah user adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini!');
        window.location.href = 'index.php'; // Ganti ke halaman tujuan
    </script>";
    exit;
}
// Tambah User
if (isset($_POST['tambah'])) {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    $_SESSION['pesan'] = "User baru berhasil ditambahkan!";
    header('Location: data_user.php');
    exit;
}

// Update User
if (isset($_POST['update'])) {
    $id_user = intval($_POST['id_user']);
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = trim($_POST['password']);

    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET username='$username', password='$password_hashed', role='$role' WHERE id_user='$id_user'");
    } else {
        $conn->query("UPDATE users SET username='$username', role='$role' WHERE id_user='$id_user'");
    }
    $_SESSION['pesan'] = "User berhasil diperbarui!";
    header('Location: data_user.php');
    exit;
}

// Hapus User
if (isset($_GET['hapus'])) {
    $id_user = intval($_GET['hapus']);
    $conn->query("DELETE FROM users WHERE id_user='$id_user'");
    $_SESSION['pesan'] = "User berhasil dihapus!";
    header('Location: data_user.php');
    exit;
}
?>

<div class="spk-container">
    <h2 class="spk-title">Data User</h2>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div style="margin: 10px 0; padding: 10px; background: #e0ffe0; border: 1px solid #00b300;">
            <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 20px;">
        <a href="#" onclick="document.getElementById('formTambah').style.display='block'" class="spk-btn">+ Tambah User</a>
    </div>

    <table class="spk-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $users = $conn->query("SELECT * FROM users");
            while ($row = $users->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <a href="#" onclick="editUser(<?= $row['id_user'] ?>, '<?= htmlspecialchars($row['username']) ?>', '<?= $row['role'] ?>')" class="spk-btn-edit">Edit</a>
                    <a href="data_user.php?hapus=<?= $row['id_user'] ?>" class="spk-btn-delete" onclick="return confirm('Yakin mau hapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br><hr><br>

    <!-- Form Tambah User -->
    <div id="formTambah" style="display:none; padding:20px; border:1px solid #ccc; margin:20px;">
        <h3>Tambah User</h3>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required class="spk-input"><br><br>
            <input type="password" name="password" placeholder="Password" required class="spk-input"><br><br>
            <select name="role" required class="spk-input">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <button style='width: 95%;' type="submit" name="tambah" class="spk-btn">Simpan</button>
            <button type="button" onclick="document.getElementById('formTambah').style.display='none'" class="spk-btn-cancel">Batal</button>
        </form>
    </div>

    <!-- Form Edit User -->
    <div id="formEdit" style="display:none; padding:20px; border:1px solid #ccc; margin:20px;">
        <h3>Edit User</h3>
        <form method="post">
            <input type="hidden" name="id_user" id="edit_id_user">
            <input type="text" name="username" id="edit_username" required class="spk-input"><br><br>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti password" class="spk-input"><br><br>
            <select name="role" id="edit_role" required class="spk-input">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <button type="submit" name="update" class="spk-btn">Update</button>
            <button type="button" onclick="document.getElementById('formEdit').style.display='none'" class="spk-btn-cancel">Batal</button>
        </form>
    </div>

</div>

<script>
function editUser(id, username, role) {
    document.getElementById('formEdit').style.display = 'block';
    document.getElementById('edit_id_user').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_role').value = role;
}
</script>

<?php include 'part/footer.php'; ?>
