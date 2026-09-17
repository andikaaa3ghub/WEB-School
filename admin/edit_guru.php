<?php
include '../includes/config.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) { echo "<p>ID tidak valid.</p>"; include 'includes/footer.php'; exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_to_update = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $old_photo = $_POST['old_photo'];
    $photo_filename = $old_photo;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../assets/images/teachers/';
        if ($old_photo != 'default_avatar.png' && file_exists($upload_dir . $old_photo)) {
            unlink($upload_dir . $old_photo);
        }
        $photo_name = time() . '_' . basename($_FILES['photo']['name']);
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo_name)) {
            $photo_filename = $photo_name;
        }
    }

    $query = "UPDATE teachers SET name='$name', position='$position', photo='$photo_filename' WHERE id=$id_to_update";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href='kelola_guru.php?status=sukses_edit';</script>";
        exit;
    } else { echo "Error: " . mysqli_error($conn); }
}

$result = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
$teacher = mysqli_fetch_assoc($result);
if (!$teacher) { echo "<p>Data tidak ditemukan.</p>"; include 'includes/footer.php'; exit; }
?>

<style>
    /* Menggunakan style yang sama dari halaman tambah */
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
    .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
</style>

<form action="edit_guru.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
    <input type="hidden" name="old_photo" value="<?php echo $teacher['photo']; ?>">
    
    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="position">Jabatan / Posisi</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($teacher['position']); ?>" required>
    </div>
    <div class="form-group">
        <label>Foto Saat Ini</label><br>
        <img src="../assets/images/teachers/<?php echo htmlspecialchars($teacher['photo']); ?>" width="100" style="border-radius: 50%;">
    </div>
    <div class="form-group">
        <label for="photo">Ganti Foto (Kosongkan jika tidak diubah)</label>
        <input type="file" id="photo" name="photo">
    </div>
    <button type="submit" class="btn-submit">Update Data</button>
</form>
<?php include 'includes/footer.php'; ?>