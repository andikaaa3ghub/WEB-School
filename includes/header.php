<?php 
// Hubungkan ke database (jika belum)
if (!isset($conn)) {
    include 'config.php';
}

// Ambil nama file halaman yang sedang dibuka saat ini
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website SMK Negeri 1 Kota Prabumulih - Modern</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <a href="index.php" class="logo">SMK Negeri 1 Kota Prabumulih</a>
        <nav>
            <a href="index.php" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Beranda</a>
            <a href="profil.php" class="<?php echo ($currentPage == 'profil.php') ? 'active' : ''; ?>">Profil</a>
            
            <a href="postingan.php" class="<?php echo ($currentPage == 'postingan.php' || $currentPage == 'detail_postingan.php') ? 'active' : ''; ?>">Berita</a>
            
            <a href="ppdb.php" class="<?php echo ($currentPage == 'ppdb.php') ? 'active' : ''; ?>">PPDB</a>
            <a href="kontak.php" class="<?php echo ($currentPage == 'kontak.php') ? 'active' : ''; ?>">Kontak</a>
        </nav>
    </div>
</header>

<main>