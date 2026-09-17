<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: index.php'); exit; }
include '../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // 1. Ambil nama file dari database sebelum dihapus
    $res = mysqli_query($conn, "SELECT file_document FROM students_ppdb WHERE id = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $file_path = '../uploads/' . $row['file_document'];
        
        // 2. Hapus file fisik dari server jika ada
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // 3. Hapus data dari database
    $query_delete = "DELETE FROM students_ppdb WHERE id = $id";
    if (mysqli_query($conn, $query_delete)) {
        header("Location: kelola_pendaftaran.php?status=sukses_hapus");
    } else {
        header("Location: kelola_pendaftaran.php?status=gagal_hapus");
    }
} else {
    header("Location: kelola_pendaftaran.php");
}
?>