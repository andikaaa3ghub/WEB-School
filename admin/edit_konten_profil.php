<?php 
include '../includes/config.php';
include 'includes/header.php';

$halaman = isset($_GET['halaman']) ? mysqli_real_escape_string($conn, $_GET['halaman']) : '';
if (empty($halaman)) { echo "<p>Halaman tidak valid.</p>"; include 'includes/footer.php'; exit; }

$message = '';
$upload_dir = '../assets/images/profil/';

// Logika update form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newData = [];
    foreach ($_POST as $key => $value) { $newData[$key] = $value; }
    
    if ($halaman == 'struktur' && isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $old_image = $_POST['old_image'];
        if ($old_image != 'default_chart.png' && file_exists($upload_dir . $old_image)) { unlink($upload_dir . $old_image); }
        $image_name = time() . '_' . basename($_FILES['gambar']['name']);
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $image_name)) { $newData['gambar'] = $image_name; }
    } elseif ($halaman == 'struktur') { $newData['gambar'] = $_POST['old_image']; }

    unset($newData['old_image']);
    $json_to_save = json_encode($newData);
    $query_update = "UPDATE profil_konten SET konten = ? WHERE key_halaman = ?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param('ss', $json_to_save, $halaman);
    if ($stmt->execute()) { $message = '<div class="alert success">Konten berhasil diperbarui!</div>'; } 
    else { $message = '<div class="alert error">Gagal memperbarui konten.</div>'; }
    $stmt->close();
}

// Ambil data terbaru untuk ditampilkan
$query = "SELECT konten FROM profil_konten WHERE key_halaman = '$halaman'";
$result = mysqli_query($conn, $query);
$data = json_decode(mysqli_fetch_assoc($result)['konten'], true);
?>

<style>
    /* Menggunakan style yang sama dari halaman tambah berita */
    .form-group { margin-bottom: 20px; } .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
    .form-group textarea { height: 150px; } .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; } .alert.success { background-color: #d4edda; color: #155724; }
</style>

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
    <?php if ($halaman == 'sejarah'): ?>
        <div class="form-group"><label for="judul">Judul Halaman</label><input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>"></div>
        <div class="form-group"><label for="deskripsi">Isi Konten</label><textarea name="deskripsi"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea></div>
    <?php elseif ($halaman == 'visi-misi'): ?>
        <div class="form-group"><label for="judul_visi">Judul Visi</label><input type="text" name="judul_visi" value="<?php echo htmlspecialchars($data['judul_visi']); ?>"></div>
        <div class="form-group"><label for="isi_visi">Isi Visi</label><textarea name="isi_visi"><?php echo htmlspecialchars($data['isi_visi']); ?></textarea></div><hr>
        <div class="form-group"><label for="judul_misi">Judul Misi</label><input type="text" name="judul_misi" value="<?php echo htmlspecialchars($data['judul_misi']); ?>"></div>
        <div class="form-group"><label for="isi_misi">Isi Misi (Tiap baris untuk satu poin)</label><textarea name="isi_misi"><?php echo htmlspecialchars($data['isi_misi']); ?></textarea></div>
    <?php elseif ($halaman == 'struktur'): ?>
        <div class="form-group"><label for="judul">Judul Halaman</label><input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>"></div>
        <div class="form-group"><label for="deskripsi">Deskripsi Singkat</label><textarea name="deskripsi"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea></div>
        <div class="form-group"><label>Gambar Saat Ini</label><br><img src="../assets/images/profil/<?php echo htmlspecialchars($data['gambar']); ?>" width="300" style="border:1px solid #ddd; padding:5px; border-radius:5px;"></div>
        <div class="form-group"><label for="gambar">Ganti Gambar Struktur</label><input type="file" name="gambar"><input type="hidden" name="old_image" value="<?php echo htmlspecialchars($data['gambar']); ?>"></div>
    <?php elseif ($halaman == 'sarana'): ?>
        <div class="form-group"><label for="judul">Judul Halaman</label><input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>"></div>
        <div class="form-group"><label for="daftar_sarana">Daftar Sarana (Satu fasilitas per baris)</label><textarea name="daftar_sarana" style="height:250px;"><?php echo htmlspecialchars($data['daftar_sarana']); ?></textarea></div>
    <?php endif; ?>
    <br>
    <button type="submit" class="btn-submit">Simpan Perubahan</button>
</form>
<?php include 'includes/footer.php'; ?>