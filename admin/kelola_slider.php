<?php
// 1. Panggil koneksi dan kerangka
include '../includes/config.php';
include 'includes/header.php';

$message = '';
$upload_dir = '../assets/images/slider/';

// Pastikan direktori ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Logika Hapus Gambar
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT image_filename FROM slider_images WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        if (file_exists($upload_dir . $row['image_filename'])) {
            unlink($upload_dir . $row['image_filename']);
        }
        mysqli_query($conn, "DELETE FROM slider_images WHERE id=$id");
        $message = '<div class="alert success">Foto berhasil dihapus.</div>';
    }
}

// Logika Upload Gambar Baru (TANPA KOMPRESI)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['slider_image'])) {
    $res_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM slider_images");
    $current_count = mysqli_fetch_assoc($res_count)['total'];
    
    if ($current_count >= 5) {
        $message = '<div class="alert error">Gagal! Jumlah foto sudah maksimal (5 foto).</div>';
    } else {
        if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] == 0) {
            $image = $_FILES['slider_image'];
            $image_name = time() . '_' . basename($image['name']);
            $target_file = $upload_dir . $image_name;
            $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validasi tipe file saja
            if (!in_array($image_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                $message = '<div class="alert error">Hanya format JPG, JPEG, PNG, & GIF yang diizinkan.</div>';
            } elseif (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Langsung simpan ke database setelah dipindah
                mysqli_query($conn, "INSERT INTO slider_images (image_filename) VALUES ('$image_name')");
                $message = '<div class="alert success">Foto berhasil diupload.</div>';
            } else {
                $message = '<div class="alert error">Terjadi kesalahan saat mengupload foto.</div>';
            }
        } else {
            $message = '<div class="alert error">Tidak ada file yang dipilih atau terjadi error upload.</div>';
        }
    }
}

// Ambil semua gambar slider untuk ditampilkan
$slider_images = mysqli_query($conn, "SELECT * FROM slider_images");
$image_count = mysqli_num_rows($slider_images);
?>

<style>
    .slider-management-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: flex-start; }
    .current-images-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
    .img-card { border: 1px solid var(--border-color); border-radius: 8px; text-align: center; padding: 10px; position: relative; }
    .img-card img { width: 100%; height: 100px; object-fit: cover; border-radius: 5px; }
    .img-card a.delete-btn { position: absolute; top: -10px; right: -10px; background: #dc3545; color: white; width: 25px; height: 25px; border-radius: 50%; text-decoration: none; font-weight: bold; display: flex; align-items: center; justify-content: center; border: 2px solid white; }
    .upload-box { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); }
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
    .alert.success { background-color: #d4edda; color: #155724; }
    .alert.error { background-color: #f8d7da; color: #721c24; }
    @media (max-width: 992px) { .slider-management-grid { grid-template-columns: 1fr; } }
</style>

<?php if ($message) { echo $message; } ?>

<div class="slider-management-grid">
    <div>
        <h4>Foto Saat Ini (<?php echo $image_count; ?>/5)</h4>
        <div class="current-images-list">
            <?php while ($img = mysqli_fetch_assoc($slider_images)): ?>
                <div class="img-card">
                    <img src="../assets/images/slider/<?php echo htmlspecialchars($img['image_filename']); ?>" alt="Slider Image">
                    <a href="kelola_slider.php?action=delete&id=<?php echo $img['id']; ?>" class="delete-btn" onclick="return confirm('Anda yakin ingin menghapus foto ini?');">×</a>
                </div>
            <?php endwhile; ?>
            <?php if($image_count == 0): ?> <p>Belum ada foto. Silakan upload.</p> <?php endif; ?>
        </div>
    </div>

    <div class="upload-box">
        <?php if ($image_count < 5): ?>
            <h4>Upload Foto Baru</h4>
            <form action="kelola_slider.php" method="post" enctype="multipart/form-data">
                <div class="form-group" style="margin-bottom:15px;">
                    <input type="file" name="slider_image" required style="width: 100%;">
                </div>
                <button type="submit" class="btn" style="background:var(--sidebar-active); color:white; border:none; padding:10px 15px; border-radius:5px; width:100%;">Upload</button>
            </form>
        <?php else: ?>
             <h4>Upload Dinonaktifkan</h4>
             <p>Jumlah foto sudah mencapai batas maksimal (5 foto).</p>
        <?php endif; ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>