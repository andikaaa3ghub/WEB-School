<?php 
include '../includes/config.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$upload_dir = '../assets/images/posts/';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_to_update = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $old_image = $_POST['old_image'];
    $image_filename = $old_image;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        if ($old_image != 'default.jpg' && file_exists($upload_dir . $old_image)) {
            unlink($upload_dir . $old_image);
        }
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']);
        if(move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
            $image_filename = $image_name;
        }
    }

    $query = "UPDATE posts SET title='$title', category='$category', content='$content', image='$image_filename' WHERE id=$id_to_update";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href='kelola_berita.php?status=sukses_edit';</script>";
        exit;
    } else { $message = "Error: " . mysqli_error($conn); }
}

$post = null;
if ($id > 0) {
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");
    $post = mysqli_fetch_assoc($result);
}

if(!$post) { echo "<p>Data tidak ditemukan.</p>"; include 'includes/footer.php'; exit; }
?>

<style>
    .form-group { margin-bottom: 20px; } .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
    .form-group textarea { height: 250px; } .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
</style>
<?php if($message) { echo $message; } ?>
<form action="edit_berita.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>"><input type="hidden" name="old_image" value="<?php echo $post['image']; ?>">
    <div class="form-group"><label for="title">Judul Berita</label><input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required></div>
    <div class="form-group"><label>Gambar Saat Ini</label><br><img src="../assets/images/posts/<?php echo htmlspecialchars($post['image']); ?>" width="200" style="border-radius:5px;"></div>
    <div class="form-group"><label for="image">Ganti Gambar (Kosongkan jika tidak diubah)</label><input type="file" id="image" name="image"></div>
    <div class="form-group"><label for="category">Kategori</label><select id="category" name="category"><option value="Berita" <?php if($post['category'] == 'Berita') echo 'selected'; ?>>Berita</option><option value="Kegiatan" <?php if($post['category'] == 'Kegiatan') echo 'selected'; ?>>Kegiatan</option><option value="Prestasi" <?php if($post['category'] == 'Prestasi') echo 'selected'; ?>>Prestasi</option></select></div>
    <div class="form-group"><label for="content">Isi Berita</label><textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea></div>
    <button type="submit" class="btn-submit">Update Berita</button>
</form>

<?php include 'includes/footer.php'; ?>