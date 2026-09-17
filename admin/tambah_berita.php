<?php 
include '../includes/config.php';
include 'includes/header.php';

$message = '';
$upload_dir = '../assets/images/posts/';

// --- FUNGSI UNTUK MENGOMPRES GAMBAR ---
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        return false;
    }
    imagejpeg($image, $destination, $quality);
    return $destination;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image_filename = 'default.jpg';

    // Cek dan proses gambar yang diupload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']);
        $target_file = $upload_dir . $image_name;
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file (tanpa validasi ukuran)
        if (!in_array($image_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            $message = '<p style="color:red;">Hanya format JPG, JPEG, PNG, & GIF yang diizinkan.</p>';
        } 
        // Panggil fungsi kompresi
        elseif (compressImage($image['tmp_name'], $target_file, 75)) { // Kualitas 75%
            $image_filename = $image_name; // Gunakan nama file baru jika berhasil
        } 
        else {
            $message = '<p style="color:red;">Gagal mengupload atau mengompres file.</p>';
        }
    }
    
    // Lanjutkan simpan ke database jika tidak ada error
    if (empty($message)) {
        $query = "INSERT INTO posts (title, category, content, image) VALUES ('$title', '$category', '$content', '$image_filename')";
        if (mysqli_query($conn, $query)) {
            echo "<script>window.location.href='kelola_berita.php?status=sukses_tambah';</script>";
            exit;
        } else { $message = "Error: " . mysqli_error($conn); }
    }
}
?>

<style>
    .form-group { margin-bottom: 20px; } .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
    .form-group textarea { height: 250px; } .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
</style>

<?php if($message) { echo "<p>$message</p>"; } ?>

<form action="tambah_berita.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Judul Berita</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="category">Kategori</label>
        <select id="category" name="category">
            <option value="Berita">Berita</option>
            <option value="Kegiatan">Kegiatan</option>
            <option value="Prestasi">Prestasi</option>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Gambar Berita</label>
        <input type="file" id="image" name="image">
    </div>
    <div class="form-group">
        <label for="content">Isi Berita</label>
        <textarea id="content" name="content" required></textarea>
    </div>
    <button type="submit" class="btn-submit">Simpan Berita</button>
</form>

<?php include 'includes/footer.php'; ?>