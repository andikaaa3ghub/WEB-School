<?php
// 1. Panggil koneksi dan kerangka
include '../includes/config.php';
include 'includes/header.php';
?>

<p>Di halaman ini Anda dapat mengelola semua data guru dan staff yang akan ditampilkan di halaman profil publik.</p>

<a href="tambah_guru.php" class="btn btn-add" style="margin-bottom: 20px; display: inline-block; background-color: #28a745; color: white; text-decoration: none; padding: 10px 15px; border-radius: 5px;">
    + Tambah Data Baru
</a>

<style>
    .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 5px; font-size: 14px; margin-right: 5px; }
    td img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; }
</style>

<table>
    <thead>
        <tr>
            <th width="10%">Foto</th>
            <th>Nama Lengkap</th>
            <th>Jabatan / Posisi</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY name ASC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image_path = '../assets/images/teachers/' . htmlspecialchars($row['photo']);
                if (!file_exists($image_path) || empty($row['photo']) || $row['photo'] == 'default_avatar.png') {
                    $image_path = 'https://via.placeholder.com/50.png?text=N/A';
                }
                echo "<tr>";
                echo "<td><img src='" . $image_path . "'></td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                echo "<td>
                        <a href='edit_guru.php?id=" . $row['id'] . "' class='btn' style='background:#ffc107; color:black;'>Edit</a>
                        <a href='hapus_guru.php?id=" . $row['id'] . "' class='btn' style='background:#dc3545' onclick='return confirm(\"Yakin ingin menghapus data ini?\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>Belum ada data guru.</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php 
// 3. Panggil footer
include 'includes/footer.php'; 
?>