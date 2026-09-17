<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: index.php'); exit; }
include '../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$is_edit = $id > 0;
$field = [
    'field_label' => '', 'field_type' => 'text', 'field_options' => '',
    'is_required' => 0, 'field_order' => 0
];

if ($is_edit) {
    $res = mysqli_query($conn, "SELECT * FROM ppdb_fields WHERE id=$id");
    $field = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $label = mysqli_real_escape_string($conn, $_POST['field_label']);
    $type = mysqli_real_escape_string($conn, $_POST['field_type']);
    $options = mysqli_real_escape_string($conn, $_POST['field_options']);
    $required = isset($_POST['is_required']) ? 1 : 0;
    $order = intval($_POST['field_order']);

    if ($is_edit) {
        $query = "UPDATE ppdb_fields SET field_label='$label', field_type='$type', field_options='$options', is_required=$required, field_order=$order WHERE id=$id";
    } else {
        $query = "INSERT INTO ppdb_fields (field_label, field_type, field_options, is_required, field_order) VALUES ('$label', '$type', '$options', $required, $order)";
    }
    
    if (mysqli_query($conn, $query)) {
        header("Location: kelola_kolom_ppdb.php?status=saved");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Kolom Formulir</title>
    <style> /* Salin CSS dari tambah_berita.php */
        body { font-family: Arial, sans-serif; }
        .container { max-width: 700px; margin: 20px auto; padding: 20px; background: #fff; }
        .form-group { margin-bottom: 15px; } label { display: block; margin-bottom: 5px; }
        input[type=text], input[type=number], select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .help-text { font-size: 12px; color: #666; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Kolom <a href="kelola_kolom_ppdb.php" style="font-size:14px; float:right;">Batal</a></h2>
    <form method="POST">
        <div class="form-group">
            <label for="field_label">Label Kolom</label>
            <input type="text" name="field_label" value="<?php echo htmlspecialchars($field['field_label']); ?>" required>
            <p class="help-text">Teks yang akan muncul di formulir (e.g., "Nama Wali").</p>
        </div>
        <div class="form-group">
            <label for="field_type">Tipe Input</label>
            <select name="field_type">
                <option value="text" <?php if($field['field_type']=='text') echo 'selected'; ?>>Teks Singkat</option>
                <option value="textarea" <?php if($field['field_type']=='textarea') echo 'selected'; ?>>Teks Panjang</option>
                <option value="select" <?php if($field['field_type']=='select') echo 'selected'; ?>>Pilihan (Select)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="field_options">Pilihan untuk Tipe Select</label>
            <input type="text" name="field_options" value="<?php echo htmlspecialchars($field['field_options']); ?>">
            <p class="help-text">Isi hanya jika Tipe Input adalah "Pilihan". Pisahkan dengan koma (e.g., Laki-laki,Perempuan).</p>
        </div>
        <div class="form-group">
            <label for="field_order">Urutan Tampil</label>
            <input type="number" name="field_order" value="<?php echo htmlspecialchars($field['field_order']); ?>" required>
            <p class="help-text">Angka lebih kecil akan tampil lebih dulu.</p>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_required" value="1" <?php if($field['is_required']) echo 'checked'; ?>> Wajib Diisi</label>
        </div>
        <button type="submit">Simpan Kolom</button>
    </form>
</div>
</body>
</html>