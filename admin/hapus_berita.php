<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: index.php'); exit; }
include '../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // 1. Ambil nama file gambar sebelum dihapus dari DB
    $res = mysqli_query($conn, "SELECT image FROM posts WHERE id = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $image_to_delete = $row['image'];
        // 2. Hapus file fisik jika bukan default
        if ($image_to_delete != 'default.jpg' && file_exists('../assets/images/posts/' . $image_to_delete)) {
            unlink('../assets/images/posts/' . $image_to_delete);
        }
    }

    // 3. Hapus data dari database
    $query = "DELETE FROM posts WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: kelola_berita.php?status=sukses_hapus");
    } else {
        header("Location: kelola_berita.php?status=gagal_hapus");
    }
} else {
    header("Location: kelola_berita.php");
}
?>