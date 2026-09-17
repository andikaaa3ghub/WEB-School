<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: index.php'); exit; }
include '../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil nama file foto sebelum dihapus dari DB
    $res = mysqli_query($conn, "SELECT photo FROM teachers WHERE id = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $photo_to_delete = $row['photo'];
        // Hapus file fisik jika bukan default
        if ($photo_to_delete != 'default_avatar.png' && file_exists('../assets/images/teachers/' . $photo_to_delete)) {
            unlink('../assets/images/teachers/' . $photo_to_delete);
        }
    }

    // Hapus data dari database
    $query = "DELETE FROM teachers WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: kelola_guru.php?status=sukses_hapus");
} else {
    header("Location: kelola_guru.php");
}
?>