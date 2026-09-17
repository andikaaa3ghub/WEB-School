<?php
include 'includes/config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Logika PHP Anda untuk memproses form tidak perlu diubah) ...
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $previous_school = mysqli_real_escape_string($conn, $_POST['previous_school']);

    $file_name = 'default.pdf';
    if (isset($_FILES['file_document']) && $_FILES['file_document']['error'] == 0) {
        $file_document = $_FILES['file_document'];
        $clean_name = preg_replace("/[^a-zA-Z0-9._-]/", "", basename($file_document['name']));
        $safe_name = str_replace(' ', '_', $clean_name);
        $file_name = time() . '_' . $safe_name;
        $target_file = "uploads/" . $file_name;
        if (!move_uploaded_file($file_document['tmp_name'], $target_file)) {
            $message = '<div class="alert error">Gagal mengupload file.</div>';
        }
    }

    if (empty($message)) {
        $query_student = "INSERT INTO students_ppdb (full_name, birth_place, birth_date, address, previous_school, file_document) VALUES ('$full_name', '$birth_place', '$birth_date', '$address', '$previous_school', '$file_name')";
        if (mysqli_query($conn, $query_student)) {
            $student_id = mysqli_insert_id($conn);
            if (isset($_POST['custom_fields']) && is_array($_POST['custom_fields'])) {
                foreach ($_POST['custom_fields'] as $field_id => $field_value) {
                    $field_id_safe = intval($field_id);
                    $field_value_safe = mysqli_real_escape_string($conn, $field_value);
                    $query_custom = "INSERT INTO ppdb_field_data (student_id, field_id, field_value) VALUES ($student_id, $field_id_safe, '$field_value_safe')";
                    mysqli_query($conn, $query_custom);
                }
            }
            $message = '<div class="alert success">Pendaftaran Anda berhasil dikirim!</div>';
        } else {
            $message = '<div class="alert error">Gagal menyimpan data ke database.</div>';
        }
    }
}
include 'includes/header.php';
?>

<section class="page-header">
    <h1>Pendaftaran Siswa Baru</h1>
</section>

<section class="page-section">
    <div class="container">
        <div class="form-wrapper">
            <p style="text-align:center; margin-bottom:20px;">Silakan isi formulir di bawah ini dengan data yang benar untuk mendaftar sebagai calon siswa baru.</p>
            <?php echo $message; ?>
            <form action="ppdb.php" method="post" enctype="multipart/form-data">
                <h4>Data Wajib</h4>
                <div class="form-group"><label for="full_name">Nama Lengkap</label><input type="text" id="full_name" name="full_name" required></div>
                <div class="form-group"><label for="birth_place">Tempat Lahir</label><input type="text" id="birth_place" name="birth_place" required></div>
                <div class="form-group"><label for="birth_date">Tanggal Lahir</label><input type="date" id="birth_date" name="birth_date" required></div>
                <div class="form-group"><label for="address">Alamat Lengkap</label><textarea id="address" name="address" rows="3" required></textarea></div>
                <div class="form-group"><label for="previous_school">Asal Sekolah</label><input type="text" id="previous_school" name="previous_school" required></div>
                <div class="form-group"><label for="file_document">Upload Berkas (PDF)</label><input type="file" id="file_document" name="file_document" accept=".pdf" required></div>
                
                <h4>Data Tambahan</h4>
                <?php
                // Logika untuk menampilkan custom fields tidak berubah
                $custom_fields = mysqli_query($conn, "SELECT * FROM ppdb_fields ORDER BY field_order ASC");
                while ($field = mysqli_fetch_assoc($custom_fields)) {
                    $field_id = $field['id'];
                    $label = htmlspecialchars($field['field_label']);
                    $is_required = $field['is_required'] ? 'required' : '';
                    echo "<div class='form-group'><label for='custom_field_$field_id'>$label</label>";
                    switch ($field['field_type']) {
                        case 'textarea': echo "<textarea name='custom_fields[$field_id]' id='custom_field_$field_id' $is_required></textarea>"; break;
                        case 'select':
                            echo "<select name='custom_fields[$field_id]' id='custom_field_$field_id' $is_required><option value=''>-- Pilih --</option>";
                            $options = explode(',', $field['field_options']);
                            foreach ($options as $option) {
                                $opt_val = trim($option); echo "<option value='$opt_val'>$opt_val</option>";
                            }
                            echo "</select>"; break;
                        default: echo "<input type='text' name='custom_fields[$field_id]' id='custom_field_$field_id' $is_required>"; break;
                    } echo "</div>";
                }
                ?>
                <div class="form-group" style="text-align:center; margin-top:30px;">
                    <button type="submit" class="btn">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>