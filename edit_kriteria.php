<?php 
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location='kriteria.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// ambil kriteria
$kriteria = $conn->query("SELECT * FROM criterias WHERE id_criteria='$id'")->fetch_assoc();

// ambil subkriteria
$subkriteria = $conn->query("SELECT * FROM sub_criterias WHERE id_criteria='$id'");

// proses update
if (isset($_POST['submit'])) {
    $criteria  = $conn->real_escape_string(trim($_POST['criteria']));
    $attribute = $conn->real_escape_string($_POST['attribute']);

    // Update kriteria
    $conn->query("UPDATE criterias SET 
        criteria='$criteria',
        attribute='$attribute'
        WHERE id_criteria='$id'
    ");

    // Ambil semua subkriteria lama yang dikirim
    $sub_ids_posted = $_POST['id_sub'] ?? [];

    // Hapus subkriteria lama yang dihapus user
    if (!empty($sub_ids_posted)) {
        $ids_to_keep = implode(',', array_map('intval', $sub_ids_posted));
        $conn->query("DELETE FROM sub_criterias WHERE id_criteria='$id' AND id_subcriteria NOT IN ($ids_to_keep)");
    } else {
        // jika semua dihapus, hapus seluruh subkriteria lama
        $conn->query("DELETE FROM sub_criterias WHERE id_criteria='$id'");
    }

    // Update subkriteria lama yang tersisa
    foreach ($sub_ids_posted as $i => $idsub) {
        $name  = $conn->real_escape_string($_POST['subkriteria_name'][$i]);
        $value = floatval($_POST['subkriteria_value'][$i]);
        if ($name !== '' && $value > 0) {
            $conn->query("UPDATE sub_criterias SET name='$name', value='$value' WHERE id_subcriteria='$idsub'");
        }
    }

    // Tambah subkriteria baru jika ada
    if (isset($_POST['new_sub_name']) && isset($_POST['new_sub_value'])) {
        foreach ($_POST['new_sub_name'] as $i => $name) {
            $name = $conn->real_escape_string(trim($name));
            $value = floatval($_POST['new_sub_value'][$i]);
            if ($name !== '' && $value > 0) {
                $conn->query("INSERT INTO sub_criterias (id_criteria, name, value) VALUES ('$id', '$name', '$value')");
            }
        }
    }

    echo "<script>alert('Kriteria dan Subkriteria berhasil diperbarui'); window.location='kriteria.php';</script>";
}
?>


<style>
/* ======= PAKAI DESAIN YANG SAMA PERSIS ======= */
.spk-container{
    padding:40px;max-width:900px;margin:auto;min-height:100vh
}
.spk-title{
    font-size:28px;font-weight:700;color:#0a1e42;
    margin-bottom:30px;border-bottom:3px solid #0a1e42;
    padding-bottom:15px
}
.spk-form{
    background:white;padding:40px;border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08)
}
.spk-form-group{margin-bottom:25px}
label{display:block;font-weight:600;margin-bottom:8px}
.spk-input{
    width:100%;padding:14px;border-radius:10px;
    border:2px solid #e2e8f0;background:#f8fafc
}
.subkriteria-item{
    display:grid;grid-template-columns:1fr 1fr auto;
    gap:12px;margin-bottom:12px;
    padding:15px;border-radius:12px;
    background:#f8fafc;border:2px solid #e2e8f0
}
.spk-btn{
    background:#0a1e42;color:white;
    padding:12px 24px;border:none;border-radius:10px;
    font-weight:600;cursor:pointer
}
.spk-btn-cancel{
    padding:12px 24px;
    border-radius:10px;
    border:2px solid #0a1e42;
    background:#fff;
    color:#0a1e42;
    text-decoration:none;
    font-weight:600;
    cursor:pointer;
}
.spk-btn-cancel:hover{
    background:#f8fafc;
}

.spk-btn-remove{
    background:#fee2e2;border:2px solid #fca5a5;
    color:#dc2626;border-radius:8px;padding:10px
}
.info-box{
    background:#dbeafe;border:2px solid #60a5fa;
    padding:15px;border-radius:12px;
    margin-bottom:25px
}
@media(max-width:768px){
    .subkriteria-item{grid-template-columns:1fr}
}
</style>

<div class="spk-container">
    <h2 class="spk-title">Edit Kriteria</h2>

    <div class="info-box">
        <b>ℹ️ Informasi</b><br>
        Ubah nama kriteria, atribut, dan nilai subkriteria sesuai kebutuhan. Tambahkan subkriteria baru jika perlu.
    </div>

    <form method="post" class="spk-form">
        <div class="spk-form-group">
            <label>Nama Kriteria</label>
            <input type="text" name="criteria" class="spk-input" required value="<?= htmlspecialchars($kriteria['criteria']) ?>">
        </div>

        <div class="spk-form-group">
            <label>Atribut</label>
            <select name="attribute" class="spk-input" required>
                <option value="benefit" <?= $kriteria['attribute']=='benefit'?'selected':'' ?>>Benefit</option>
                <option value="cost" <?= $kriteria['attribute']=='cost'?'selected':'' ?>>Cost</option>
            </select>
        </div>

       <div class="spk-form-group">
            <label>Daftar Subkriteria</label>
            <div id="subkriteria-container">
                <?php while($s = $subkriteria->fetch_assoc()): ?>
                <div class="subkriteria-item">
                    <input type="hidden" name="id_sub[]" value="<?= $s['id_subcriteria'] ?>">
                    <input type="text" name="subkriteria_name[]" class="spk-input" value="<?= $s['name'] ?>" required>
                    <input type="number" name="subkriteria_value[]" class="spk-input" value="<?= $s['value'] ?>" step="0.01" required>
                    <button type="button" class="spk-btn-remove" onclick="hapusSubkriteria(this)">🗑 Hapus</button>
                </div>
                <?php endwhile; ?>
            </div>
            <button type="button" class="spk-btn" onclick="tambahSubkriteria()">Tambah Subkriteria</button>

        </div>

        <div class="spk-form-group">
            <button type="submit" name="submit" class="spk-btn">Update Kriteria</button>
            <a href="kriteria.php" class="spk-btn-cancel">Batal</a>
        </div>
    </form>
</div>

<script>
function tambahSubkriteria() {
    const container = document.getElementById('subkriteria-container');
    const div = document.createElement('div');
    div.className = 'subkriteria-item';
    div.innerHTML = `
        <input type="text" name="new_sub_name[]" class="spk-input" placeholder="Nama Subkriteria" required>
        <input type="number" name="new_sub_value[]" class="spk-input" placeholder="Nilai (contoh: 1,2,3)" step="0.01" required>
        <button type="button" class="spk-btn-remove" onclick="hapusSubkriteria(this)">🗑 Hapus</button>
    `;
    container.appendChild(div);
}

function hapusSubkriteria(btn) {
    const container = document.getElementById('subkriteria-container');
    if(container.children.length > 1){
        btn.parentElement.remove();
    } else {
        alert('Minimal harus ada 1 subkriteria!');
    }
}
</script>

<?php include 'part/footer.php'; ?>
