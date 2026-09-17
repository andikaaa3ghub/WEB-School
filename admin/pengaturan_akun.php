<?php
// 1. Panggil koneksi dan kerangka
include '../includes/config.php';
include 'includes/header.php';

$message = '';
$user_id = $_SESSION['id'];

// Logika untuk memproses form update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $current_password = $_POST['current_password'];

    $result = mysqli_query($conn, "SELECT username, password FROM users WHERE id = $user_id");
    $user = mysqli_fetch_assoc($result);

    // Verifikasi password saat ini
    if (password_verify($current_password, $user['password'])) {
        $update_parts = [];
        $params = [];
        $types = '';

        // Cek jika username diubah
        if ($username !== $user['username']) {
            $res_check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username' AND id != $user_id");
            if (mysqli_num_rows($res_check) > 0) {
                $message = '<div class="alert error">Username tersebut sudah digunakan oleh akun lain.</div>';
            } else {
                $update_parts[] = "username = ?";
                $params[] = $username;
                $types .= 's';
            }
        }
        
        // Cek jika password baru diisi
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                if (strlen($new_password) < 6) {
                    $message = '<div class="alert error">Password baru minimal harus 6 karakter.</div>';
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_parts[] = "password = ?";
                    $params[] = $hashed_password;
                    $types .= 's';
                }
            } else {
                $message = '<div class="alert error">Konfirmasi password baru tidak cocok.</div>';
            }
        }
        
        // Jalankan query jika ada perubahan dan tidak ada error
        if (!empty($update_parts) && empty($message)) {
            $query = "UPDATE users SET " . implode(', ', $update_parts) . " WHERE id = ?";
            $params[] = $user_id;
            $types .= 'i';

            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $_SESSION['name'] = $username; // Update session jika username berubah
                $message = '<div class="alert success">Akun berhasil diperbarui! Silakan login ulang jika Anda mengubah password.</div>';
            } else {
                $message = '<div class="alert error">Gagal memperbarui akun.</div>';
            }
            $stmt->close();
        } elseif (empty($message)) {
            $message = '<div class="alert info">Tidak ada perubahan yang disimpan.</div>';
        }

    } else {
        $message = '<div class="alert error">Password Anda saat ini salah!</div>';
    }
}
?>

<style>
    /* Style untuk form dan alert */
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input[type="text"], .form-group input[type="password"] { 
        width: 100%; padding: 10px; border: 1px solid var(--border-color); 
        border-radius: 5px; 
    }
    .help-text { font-size: 12px; color: #666; margin-top: 5px; }
    .btn-submit { background: var(--sidebar-active); color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid transparent; }
    .alert.success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
    .alert.error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    .alert.info { background-color: #cce5ff; color: #004085; border-color: #b8daff; }
</style>

<p>Di halaman ini Anda dapat mengubah username dan password untuk login ke panel admin.</p>
<hr style="margin: 20px 0; border-color: #f0f0f0;">

<?php echo $message; ?>

<form method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="new_password">Password Baru</label>
        <input type="password" id="new_password" name="new_password">
        <p class="help-text">Kosongkan jika tidak ingin mengubah password.</p>
    </div>

    <div class="form-group">
        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" id="confirm_password" name="confirm_password">
    </div>
    
    <hr style="margin: 20px 0; border-color: #f0f0f0;">
    
    <div class="form-group">
        <label for="current_password">Password Saat Ini (Wajib untuk konfirmasi)</label>
        <input type="password" id="current_password" name="current_password" required>
        <p class="help-text">Masukkan password Anda yang lama untuk menyimpan perubahan apa pun.</p>
    </div>
    
    <button type="submit" class="btn-submit">Simpan Perubahan</button>
</form>
<?php 
// Panggil footer
include 'includes/footer.php'; 
?>