<?php 
include 'cek_login.php';
include 'part/header.php';
include 'koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini!');
        window.location.href = 'index.php';
    </script>";
    exit;
}
?>

<div class="spk-container">
    <h2 class="spk-title">Edit Perbandingan Kriteria (AHP) - Matriks Input</h2>

    <form action="simpan_edit_perbandingan.php" method="post">
    <table class="spk-table">
        <thead>
            <tr>
                <th>Kriteria</th>
                <?php
                // Ambil kriteria
                $kriteria = [];
                $query = $conn->query("SELECT id_criteria, criteria FROM criterias ORDER BY id_criteria ASC");
                while ($row = $query->fetch_assoc()) {
                    $kriteria[$row['id_criteria']] = $row['criteria'];
                }
                foreach ($kriteria as $id => $nama) {
                    echo "<th>" . htmlspecialchars($nama) . "</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ambil data nilai yang sudah ada
            $perbandingan = [];
            $query = $conn->query("SELECT * FROM ahp_comparisons");
            while ($row = $query->fetch_assoc()) {
                $perbandingan[$row['kriteria_1']][$row['kriteria_2']] = $row['nilai'];
            }

            foreach ($kriteria as $id1 => $nama1) {
                echo "<tr>";
                echo "<th>" . htmlspecialchars($nama1) . "</th>";
                
                foreach ($kriteria as $id2 => $nama2) {
                    if ($id1 == $id2) {
                        // PERBAIKAN DI SINI: Tambahkan name='...' agar angka 1 ikut terkirim
                        echo "<td><input type='text' name='nilai[$id1][$id2]' class='spk-input' value='1' readonly style='background:#f0f0f0; text-align:center;'></td>";
                    } else {
                        // Cek apakah ada nilai di database, jika tidak kosongkan
                        $nilai_db = isset($perbandingan[$id1][$id2]) ? $perbandingan[$id1][$id2] : '';
                        echo "<td><input type='text' name='nilai[$id1][$id2]' class='spk-input' value='" . htmlspecialchars($nilai_db) . "' required autocomplete='off'></td>";
                    }
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <button type="submit" class="spk-btn">Simpan Perbandingan</button>
    </div>
</form>
</div>
<?php include 'part/footer.php'; ?>
