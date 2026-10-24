<?php 
include '../includes/config.php';
include 'includes/header.php';

$message = '';
$upload_dir = '../assets/images/posts/';

// Pastikan folder penyimpanan ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Fungsi kompresi gambar dengan fallback aman jika ekstensi GD di PHP/XAMPP belum aktif
function saveUploadedImage($source, $destination, $quality = 75) {
    // Cek apakah ekstensi GD aktif di PHP
    if (extension_loaded('gd') && function_exists('imagecreatefrompng') && function_exists('imagecreatefromjpeg')) {
        $info = @getimagesize($source);
        if ($info) {
            $image = null;
            if ($info['mime'] == 'image/jpeg') {
                $image = @imagecreatefromjpeg($source);
            } elseif ($info['mime'] == 'image/gif') {
                $image = @imagecreatefromgif($source);
            } elseif ($info['mime'] == 'image/png') {
                $image = @imagecreatefrompng($source);
            }

            if ($image) {
                // Kompres dan simpan
                @imagejpeg($image, $destination, $quality);
                @imagedestroy($image);
                if (file_exists($destination)) {
                    return true;
                }
            }
        }
    }

    // Fallback otomatis jika GD dinonaktifkan di XAMPP: langsung simpan file asli
    return move_uploaded_file($source, $destination);
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

        // Validasi tipe file
        if (!in_array($image_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            $message = '<p style="color:red;">Hanya format JPG, JPEG, PNG, & GIF yang diizinkan.</p>';
        } 
        // Simpan gambar (kompres jika ada GD, atau simpan langsung)
        elseif (saveUploadedImage($image['tmp_name'], $target_file, 75)) {
            $image_filename = $image_name;
        } 
        else {
            $message = '<p style="color:red;">Gagal mengunggah file gambar ke server.</p>';
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