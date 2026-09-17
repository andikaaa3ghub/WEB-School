<?php
// 1. Panggil koneksi dan kerangka
include '../includes/config.php';
include 'includes/header.php';
?>

<p>Berikut adalah daftar semua calon siswa yang telah mendaftar melalui formulir PPDB online.</p>
<br>
<div style="margin-bottom: 20px;">
    <a href="kelola_kolom_ppdb.php" class="btn" style="background-color:#5a6268; color: white; text-decoration: none; padding: 10px 15px; border-radius: 5px;">
        ⚙️ Kelola Kolom Formulir
    </a>
</div>


<style>
    /* Style untuk tombol aksi di tabel */
    .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 5px; font-size: 14px; margin-right: 5px; }
</style>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Asal Sekolah</th>
            <th>Tanggal Daftar</th>
            <th width="150px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT id, full_name, previous_school, registration_date FROM students_ppdb ORDER BY id DESC");
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['previous_school']) . "</td>";
                echo "<td>" . date('d M Y, H:i', strtotime($row['registration_date'])) . "</td>";
                echo "<td>
                        <a href='detail_pendaftar.php?id=" . $row['id'] . "' class='btn' style='background:#17a2b8;'>Detail</a>
                        <a href='hapus_pendaftar.php?id=" . $row['id'] . "' class='btn' style='background:#dc3545;' onclick='return confirm(\"Yakin ingin menghapus data pendaftar ini?\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>Belum ada pendaftar.</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php 
// 3. Panggil footer
include 'includes/footer.php'; 
?>