<?php 
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama admin
include 'includes/header.php'; 
?>

<p>Di bawah ini adalah daftar semua berita dan artikel yang telah Anda publikasikan. Anda bisa menambah, mengedit, atau menghapusnya.</p>

<a href="tambah_berita.php" class="btn btn-add" style="margin-bottom: 20px; display: inline-block; background-color: #28a745; color: white; text-decoration: none; padding: 10px 15px; border-radius: 5px;">
    + Tambah Berita Baru
</a>

<style>
    .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 5px; font-size: 14px; margin-right: 5px; }
</style>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Foto</th>
            <th>Judul</th>
            <th width="15%">Kategori</th>
            <th width="15%">Tanggal</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image_path = '../assets/images/posts/' . htmlspecialchars($row['image']);
                if (!file_exists($image_path) || empty($row['image']) || $row['image'] == 'default.jpg') {
                    $image_path = 'https://via.placeholder.com/100x60.png?text=N/A';
                }

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td><img src='" . $image_path . "' width='100' style='border-radius:5px;'></td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td>" . date('d M Y', strtotime($row['created_at'])) . "</td>";
                echo "<td>
                        <a href='edit_berita.php?id=" . $row['id'] . "' class='btn' style='background:#ffc107; color:black;'>Edit</a>
                        <a href='hapus_berita.php?id=" . $row['id'] . "' class='btn' style='background:#dc3545;' onclick='return confirm(\"Yakin ingin menghapus?\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>Belum ada berita.</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php 
// 3. Panggil footer
include 'includes/footer.php'; 
?>