<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Kosongkan jika tidak ada password
$db_name = 'db_sekolah';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>