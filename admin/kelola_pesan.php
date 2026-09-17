<?php
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama admin (header & sidebar)
include 'includes/header.php';
?>

<p>Berikut adalah daftar semua pesan yang dikirim melalui formulir kontak. Pesan yang belum dibaca akan ditandai dengan teks tebal.</p>

<style>
    /* Style untuk pesan belum dibaca */
    tr.unread td {
        font-weight: 600;
        color: var(--text-color);
    }
    .btn { 
        padding: 6px 12px; 
        text-decoration: none; 
        color: white; 
        border-radius: 5px; 
        font-size: 14px;
        margin-right: 5px;
    }
</style>

<table>
    <thead>
        <tr>
            <th>Dari</th>
            <th>Subjek</th>
            <th>Tanggal</th>
            <th width="150px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT id, name, subject, received_at, is_read FROM contact_messages ORDER BY received_at DESC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row_class = $row['is_read'] ? '' : 'unread'; // Tentukan class berdasarkan status
                echo "<tr class='$row_class'>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                echo "<td>" . date('d M Y, H:i', strtotime($row['received_at'])) . "</td>";
                echo "<td>
                        <a href='baca_pesan.php?id=" . $row['id'] . "' class='btn' style='background:#0d6efd'>Baca</a>
                        <a href='hapus_pesan.php?id=" . $row['id'] . "' class='btn' style='background:#dc3545' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>Tidak ada pesan.</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php 
// 3. Panggil footer untuk menutup kerangka
include 'includes/footer.php'; 
?>