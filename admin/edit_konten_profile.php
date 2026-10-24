<?php 
include '../includes/config.php';
include 'includes/header.php';

$halaman = isset($_GET['halaman']) ? mysqli_real_escape_string($conn, $_GET['halaman']) : '';
if (empty($halaman)) { 
    echo "<p>Halaman tidak valid.</p>"; 
    include 'includes/footer.php'; 
    exit; 
}

$message = '';
$upload_dir = '../assets/images/profil/';

// Logika update form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newData = [];
    foreach ($_POST as $key => $value) { 
        $newData[$key] = $value; 
    }
    
    if ($halaman == 'struktur' && isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $old_image = $_POST['old_image'] ?? 'default_chart.png';
        if ($old_image != 'default_chart.png' && file_exists($upload_dir . $old_image)) { 
            unlink($upload_dir . $old_image); 
        }
        $image_name = time() . '_' . basename($_FILES['gambar']['name']);
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $image_name)) { 
            $newData['gambar'] = $image_name; 
        }
    } elseif ($halaman == 'struktur') { 
        $newData['gambar'] = $_POST['old_image'] ?? 'default_chart.png'; 
    }

    unset($newData['old_image']);
    $json_to_save = json_encode($newData, JSON_UNESCAPED_UNICODE);
    $query_update = "UPDATE profil_konten SET konten = ? WHERE key_halaman = ?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param('ss', $json_to_save, $halaman);
    if ($stmt->execute()) { 
        $message = '<div class="alert success">Konten berhasil diperbarui! Perubahan sudah tersimpan rapi.</div>'; 
    } else { 
        $message = '<div class="alert error">Gagal memperbarui konten: ' . htmlspecialchars($conn->error) . '</div>'; 
    }
    $stmt->close();
}

// Ambil data terbaru untuk ditampilkan
$query = "SELECT konten FROM profil_konten WHERE key_halaman = '$halaman'";
$result = mysqli_query($conn, $query);
$data = [];
if ($result && mysqli_num_rows($result) > 0) {
    $data = json_decode(mysqli_fetch_assoc($result)['konten'], true) ?: [];
}

$nama_halaman = [
    'sejarah' => 'Sejarah Sekolah',
    'visi-misi' => 'Visi & Misi',
    'struktur' => 'Struktur Organisasi',
    'sarana' => 'Sarana & Prasarana'
][$halaman] ?? 'Profil Sekolah';
?>

<style>
    .profil-edit-card {
        background: #ffffff;
        border-radius: 8px;
    }
    .form-group {
        margin-bottom: 22px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
    }
    .form-group .form-hint {
        display: block;
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }
    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #2980b9;
        box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.15);
    }
    .textarea-konten {
        min-height: 220px;
        line-height: 1.7;
        resize: vertical;
        white-space: pre-wrap;
    }
    .btn-submit {
        background: #2980b9;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-submit:hover {
        background: #1f6391;
    }
    .btn-back {
        display: inline-block;
        margin-left: 10px;
        padding: 12px 20px;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
    }
    .btn-back:hover {
        background: #5a6268;
    }
    .alert {
        padding: 14px 18px;
        margin-bottom: 22px;
        border-radius: 6px;
        font-size: 14px;
    }
    .alert.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .preview-box {
        background: #f8f9fa;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        padding: 15px;
        margin-top: 10px;
    }
</style>

<div class="profil-edit-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; border-bottom:1px solid #eee; padding-bottom:15px;">
        <h3 style="margin:0; color:#2c3e50;">Edit: <?php echo htmlspecialchars($nama_halaman); ?></h3>
        <a href="kelola_profil.php" class="btn-back" style="margin:0;">&larr; Kembali ke Menu Profil</a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <?php if ($halaman == 'sejarah'): ?>
            <div class="form-group">
                <label for="judul">Judul Halaman</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($data['judul'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Isi Konten Sejarah</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control textarea-konten" rows="10" placeholder="Tuliskan sejarah sekolah di sini. Tekan Enter untuk membuat baris baru / paragraf ke bawah..."><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                <span class="form-hint">&bull; Tekan tombol <strong>Enter</strong> pada keyboard untuk berpindah baris/paragraf ke bawah. Teks akan tampil rapi sesuai baris yang Anda buat.</span>
            </div>

        <?php elseif ($halaman == 'visi-misi'): ?>
            <div class="form-group">
                <label for="judul_visi">Judul Visi</label>
                <input type="text" id="judul_visi" name="judul_visi" class="form-control" value="<?php echo htmlspecialchars($data['judul_visi'] ?? 'Visi Sekolah'); ?>" required>
            </div>
            <div class="form-group">
                <label for="isi_visi">Isi Visi</label>
                <textarea id="isi_visi" name="isi_visi" class="form-control textarea-konten" rows="5" placeholder="Tuliskan visi sekolah..."><?php echo htmlspecialchars($data['isi_visi'] ?? ''); ?></textarea>
                <span class="form-hint">&bull; Gunakan Enter untuk memisahkan baris teks visi.</span>
            </div>
            <hr style="border:0; border-top:1px solid #eee; margin:25px 0;">
            <div class="form-group">
                <label for="judul_misi">Judul Misi</label>
                <input type="text" id="judul_misi" name="judul_misi" class="form-control" value="<?php echo htmlspecialchars($data['judul_misi'] ?? 'Misi Sekolah'); ?>" required>
            </div>
            <div class="form-group">
                <label for="isi_misi">Isi Misi (Setiap nomor/poin pada baris baru)</label>
                <textarea id="isi_misi" name="isi_misi" class="form-control textarea-konten" rows="8" placeholder="1. Misi pertama...&#10;2. Misi kedua...&#10;3. Misi ketiga..."><?php echo htmlspecialchars($data['isi_misi'] ?? ''); ?></textarea>
                <span class="form-hint">&bull; Tekan <strong>Enter</strong> untuk membuat setiap poin misi tersusun rapi ke bawah.</span>
            </div>

        <?php elseif ($halaman == 'struktur'): ?>
            <div class="form-group">
                <label for="judul">Judul Halaman</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($data['judul'] ?? 'Struktur Organisasi Sekolah'); ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Singkat / Keterangan Bagan</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control textarea-konten" rows="5"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                <span class="form-hint">&bull; Keterangan akan tampil di atas bagan struktur organisasi dengan susunan baris rapi.</span>
            </div>
            <div class="form-group">
                <label>Gambar Bagan Struktur Saat Ini</label>
                <div class="preview-box">
                    <?php 
                    $gambar = !empty($data['gambar']) ? $data['gambar'] : 'default_chart.png';
                    $gambar_path = '../assets/images/profil/' . $gambar;
                    if (file_exists($gambar_path)): ?>
                        <img src="<?php echo htmlspecialchars($gambar_path); ?>" alt="Bagan Struktur" style="max-width:350px; max-height:250px; object-fit:contain; border:1px solid #ddd; border-radius:6px; background:#fff; padding:4px;">
                    <?php else: ?>
                        <p style="color:#888; margin:0;">Belum ada gambar yang diunggah.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="gambar">Unggah Gambar Bagan Struktur Baru</label>
                <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
                <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($data['gambar'] ?? 'default_chart.png'); ?>">
                <span class="form-hint">&bull; Biarkan kosong jika tidak ingin mengubah gambar struktur saat ini.</span>
            </div>

        <?php elseif ($halaman == 'sarana'): ?>
            <div class="form-group">
                <label for="judul">Judul Halaman</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($data['judul'] ?? 'Fasilitas & Sarana Prasarana'); ?>" required>
            </div>
            <div class="form-group">
                <label for="daftar_sarana">Daftar Fasilitas & Sarana (Satu fasilitas per baris ke bawah)</label>
                <textarea id="daftar_sarana" name="daftar_sarana" class="form-control textarea-konten" rows="12" placeholder="Gedung Pembelajaran Modern&#10;Laboratorium Komputer&#10;Perpustakaan Digital"><?php echo htmlspecialchars($data['daftar_sarana'] ?? ''); ?></textarea>
                <span class="form-hint">&bull; Masukkan setiap fasilitas di baris baru (tekan Enter). Setiap baris akan otomatis menjadi poin daftar teratur (bullet list).</span>
            </div>
        <?php endif; ?>

        <div style="margin-top:30px; padding-top:15px; border-top:1px solid #eee;">
            <button type="submit" class="btn-submit">&#128190; Simpan Perubahan</button>
            <a href="kelola_profil.php" class="btn-back">Batal</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
