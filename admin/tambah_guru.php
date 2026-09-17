<?php
include '../includes/config.php';
include 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $photo_filename = 'default_avatar.png';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../assets/images/teachers/';
        if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
        $photo_name = time() . '_' . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $photo_name;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_filename = $photo_name;
        }
    }
    
    $query = "INSERT INTO teachers (name, position, photo) VALUES ('$name', '$position', '$photo_filename')";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href='kelola_guru.php?status=sukses_tambah';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<style>
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
    .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
</style>

<form action="tambah_guru.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="position">Jabatan / Posisi</label>
        <input type="text" id="position" name="position" required>
    </div>
    <div class="form-group">
        <label for="photo">Foto</label>
        <input type="file" id="photo" name="photo">
    </div>
    <button type="submit" class="btn-submit">Simpan Data</button>
</form>
<?php include 'includes/footer.php'; ?>