<?php 
include 'part/header.php';
include 'koneksi.php';

// Proses tambah kriteria dan subkriteria
if (isset($_POST['submit'])) {
    $criteria = trim($_POST['criteria']);
    $attribute = $_POST['attribute'];
    $sub_names = $_POST['subkriteria_name'];
    $sub_values = $_POST['subkriteria_value'];

    if ($criteria == '' || $attribute == '') {
        echo "<script>alert('Nama kriteria dan atribut wajib diisi!');</script>";
    } else {
        // Insert ke tabel criterias
        $insert = $conn->query("INSERT INTO criterias (criteria, attribute) VALUES ('$criteria', '$attribute')");

        if ($insert) {
            $id_new = $conn->insert_id;

            // Insert subkriteria
            if (!empty($sub_names)) {
                foreach ($sub_names as $index => $sub_name) {
                    $sub_name = trim($sub_name);
                    $sub_value = floatval($sub_values[$index]);
                    if ($sub_name != '' && $sub_value > 0) {
                        $conn->query("INSERT INTO sub_criterias (id_criteria, name, value) VALUES ('$id_new', '$sub_name', '$sub_value')");
                    }
                }
            }

            echo "<script>alert('Kriteria dan Subkriteria berhasil ditambahkan'); window.location='kriteria.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan kriteria');</script>";
        }
    }
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
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .spk-title {
        font-size: 28px;
        font-weight: 700;
        color: #0a1e42;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid #0a1e42;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .spk-title::before {
        content: '📝';
        font-size: 32px;
    }

    .spk-form {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 
            0 4px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }

    .spk-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #0a1e42 0%, #3b82f6 50%, #0a1e42 100%);
    }

    .spk-form-group {
        margin-bottom: 28px;
    }

    .spk-form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .spk-form-group label::before {
        content: '';
        width: 4px;
        height: 16px;
        background: #0a1e42;
        border-radius: 2px;
    }

    .spk-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #1e293b;
    }

    .spk-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .spk-input::placeholder {
        color: #94a3b8;
    }

    /* Subkriteria Container */
    #subkriteria-container {
        margin-bottom: 15px;
    }

    .subkriteria-item {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 12px;
        margin-bottom: 12px;
        padding: 16px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .subkriteria-item:hover {
        border-color: #cbd5e1;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Buttons */
    .spk-btn {
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        background: linear-gradient(135deg, #0a1e42 0%, #1e3a5f 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(10, 30, 66, 0.3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .spk-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(10, 30, 66, 0.4);
    }

    .spk-btn:active {
        transform: translateY(0);
    }

    .spk-btn-cancel {
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        background: white;
        color: #64748b;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .spk-btn-cancel:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        color: #475569;
    }

    .spk-btn-remove {
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        border: 2px solid #fecaca;
        cursor: pointer;
        background: #fef2f2;
        color: #dc2626;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        white-space: nowrap;
    }

    .spk-btn-remove:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        transform: translateY(-1px);
    }

    /* Form Actions */
    .spk-form-group:last-child {
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid #f1f5f9;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .spk-form-group:last-child button,
    .spk-form-group:last-child a {
        flex: 1;
        min-width: 150px;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #60a5fa;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-box-icon {
        font-size: 20px;
        flex-shrink: 0;
    }

    .info-box-content {
        flex: 1;
    }

    .info-box-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 4px;
    }

    .info-box-text {
        font-size: 12px;
        color: #1e40af;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .spk-container {
            padding: 20px;
        }

        .spk-form {
            padding: 25px 20px;
        }

        .spk-title {
            font-size: 24px;
        }

        .subkriteria-item {
            grid-template-columns: 1fr;
        }

        .spk-form-group:last-child {
            flex-direction: column;
        }

        .spk-form-group:last-child button,
        .spk-form-group:last-child a {
            width: 100%;
        }
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .subkriteria-item {
        animation: slideIn 0.3s ease;
    }
</style>

<div class="spk-container">
    <h2 class="spk-title">Tambah Kriteria</h2>

    <div class="info-box">
        <div class="info-box-icon">💡</div>
        <div class="info-box-content">
            <div class="info-box-title">Informasi</div>
            <div class="info-box-text">
                Isi nama kriteria dan pilih atribut (Benefit atau Cost). Tambahkan subkriteria beserta nilai bobotnya. Minimal harus ada 1 subkriteria.
            </div>
        </div>
    </div>

    <form method="post" class="spk-form">
        <div class="spk-form-group">
            <label for="criteria">Nama Kriteria</label>
            <input type="text" name="criteria" id="criteria" class="spk-input" placeholder="Contoh: Harga, Kualitas, Durabilitas" required>
        </div>

        <div class="spk-form-group">
            <label for="attribute">Atribut</label>
            <select name="attribute" id="attribute" class="spk-input" required>
                <option value="">-- Pilih Atribut --</option>
                <option value="benefit">Benefit (Semakin tinggi semakin baik)</option>
                <option value="cost">Cost (Semakin rendah semakin baik)</option>
            </select>
        </div>

        <div class="spk-form-group">
            <label>Daftar Subkriteria</label>
            <div id="subkriteria-container">
                <div class="subkriteria-item">
                    <input type="text" name="subkriteria_name[]" class="spk-input" placeholder="Nama Subkriteria" required>
                    <input type="number" name="subkriteria_value[]" class="spk-input" placeholder="Nilai (contoh: 1, 2, 3)" step="0.01" required>
                    <button type="button" class="spk-btn-remove" onclick="hapusSubkriteria(this)">Hapus</button>
                </div>
            </div>
            <button type="button" class="spk-btn" onclick="tambahSubkriteria()">Tambah Subkriteria</button>
        </div>

        <div class="spk-form-group">
            <button type="submit" name="submit" class="spk-btn">Simpan Kriteria</button>
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
        <input type="text" name="subkriteria_name[]" class="spk-input" placeholder="Nama Subkriteria" required>
        <input type="number" name="subkriteria_value[]" class="spk-input" placeholder="Nilai (contoh: 1, 2, 3)" step="0.01" required>
        <button type="button" class="spk-btn-remove" onclick="hapusSubkriteria(this)">🗑️ Hapus</button>
    `;
    container.appendChild(div);
}

function hapusSubkriteria(button) {
    const container = document.getElementById('subkriteria-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    } else {
        alert('Minimal harus ada 1 subkriteria!');
    }
}
</script>

<?php include 'part/footer.php'; ?>