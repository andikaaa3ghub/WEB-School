<?php
// 1. Panggil koneksi dan kerangka
include '../includes/config.php';
include 'includes/header.php';

// 2. Logika untuk mengambil data pendaftar
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) { echo "<p>ID tidak valid.</p>"; include 'includes/footer.php'; exit; }

$result_student = mysqli_query($conn, "SELECT * FROM students_ppdb WHERE id = $id");
if (mysqli_num_rows($result_student) == 0) { echo "<p>Data pendaftar tidak ditemukan.</p>"; include 'includes/footer.php'; exit; }
$data = mysqli_fetch_assoc($result_student);

$query_custom = "SELECT f.field_label, d.field_value FROM ppdb_field_data d JOIN ppdb_fields f ON d.field_id = f.id WHERE d.student_id = $id ORDER BY f.field_order ASC";
$result_custom = mysqli_query($conn, $query_custom);
?>

<style>
    .detail-section h3 { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-top: 0; margin-bottom: 15px; }
    .detail-section table { width: 100%; }
    .detail-section td { padding: 10px 5px; border-bottom: 1px solid #eee; }
    .detail-section td:first-child { font-weight: 500; width: 30%; color: #555; }
    .btn-download { background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
</style>

<div class="detail-section">
    <h3>Data Wajib</h3>
    <table>
        <tr><td>Nama Lengkap</td><td>: <?php echo htmlspecialchars($data['full_name']); ?></td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>: <?php echo htmlspecialchars($data['birth_place']) . ', ' . date('d F Y', strtotime($data['birth_date'])); ?></td></tr>
        <tr><td>Alamat</td><td>: <?php echo htmlspecialchars($data['address']); ?></td></tr>
        <tr><td>Asal Sekolah</td><td>: <?php echo htmlspecialchars($data['previous_school']); ?></td></tr>
        <tr><td>Tanggal Pendaftaran</td><td>: <?php echo date('d M Y, H:i:s', strtotime($data['registration_date'])); ?></td></tr>
        <tr><td>Berkas Terlampir</td><td>: <a href="../uploads/<?php echo htmlspecialchars($data['file_document']); ?>" target="_blank" class="btn-download">Unduh Berkas</a></td></tr>
    </table>
</div>

<div class="detail-section" style="margin-top: 30px;">
    <h3>Data Tambahan</h3>
    <table>
        <?php
        if(mysqli_num_rows($result_custom) > 0) {
            while($custom_row = mysqli_fetch_assoc($result_custom)) {
                echo "<tr><td>" . htmlspecialchars($custom_row['field_label']) . "</td><td>: " . htmlspecialchars($custom_row['field_value']) . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Tidak ada data tambahan yang diisi.</td></tr>";
        }
        ?>
    </table>
</div>
<?php 
// 3. Panggil footer
include 'includes/footer.php'; 
?>