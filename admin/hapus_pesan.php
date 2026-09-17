<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: index.php'); exit; }
include '../includes/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id");
}
header("Location: kelola_pesan.php");
exit;
?>