<?php
include '../includes/config.php';
include 'includes/header.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM ppdb_fields WHERE id=$id");
    mysqli_query($conn, "DELETE FROM ppdb_field_data WHERE field_id=$id");
    echo "<script>window.location.href='kelola_kolom_ppdb.php?status=deleted';</script>";
    exit;
}
?>

<p>Kelola kolom-kolom tambahan yang akan muncul di formulir pendaftaran PPDB.</p>
<a href="edit_kolom_ppdb.php" class="btn" style="margin-bottom: 20px; display: inline-block; background-color: #28a745; color: white; text-decoration: none; padding: 10px 15px; border-radius: 5px;">+ Tambah Kolom Baru</a>

<style>
    .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 5px; font-size: 14px; margin-right: 5px; }
</style>

<table>
    <thead>
        <tr><th>Label Kolom</th><th>Tipe</th><th>Wajib Diisi</th><th>Urutan</th><th>Aksi</th></tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM ppdb_fields ORDER BY field_order ASC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['field_label']) . "</td>";
                echo "<td>" . htmlspecialchars($row['field_type']) . "</td>";
                echo "<td>" . ($row['is_required'] ? 'Ya' : 'Tidak') . "</td>";
                echo "<td>" . htmlspecialchars($row['field_order']) . "</td>";
                echo "<td>
                        <a href='edit_kolom_ppdb.php?id=" . $row['id'] . "' class='btn' style='background:#ffc107; color:black;'>Edit</a>
                        <a href='kelola_kolom_ppdb.php?action=delete&id=" . $row['id'] . "' class='btn' style='background:#dc3545' onclick='return confirm(\"Yakin ingin menghapus kolom ini? Semua data terkait akan hilang.\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>Belum ada kolom tambahan.</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>