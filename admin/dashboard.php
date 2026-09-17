<?php 
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama (header akan memulai HTML dan memanggil sidebar)
include 'includes/header.php'; 

// 3. Ambil data statistik khusus untuk dashboard
$res_msg = mysqli_query($conn, "SELECT COUNT(id) AS unread_count FROM contact_messages WHERE is_read = 0");
$unread_count = mysqli_fetch_assoc($res_msg)['unread_count'] ?? 0;

$res_pendaftar = mysqli_query($conn, "SELECT COUNT(id) AS pendaftar_count FROM students_ppdb");
$pendaftar_count = mysqli_fetch_assoc($res_pendaftar)['pendaftar_count'] ?? 0;

$res_berita = mysqli_query($conn, "SELECT COUNT(id) AS berita_count FROM posts");
$berita_count = mysqli_fetch_assoc($res_berita)['berita_count'] ?? 0;
?>

<style>
    .dashboard-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .stat-card { background: #ffffff; padding: 25px; border-radius: 8px; border-left: 5px solid var(--sidebar-active); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .stat-card .stat-number { font-size: 36px; font-weight: 700; color: var(--sidebar-bg); }
    .stat-card .stat-label { font-size: 16px; color: #666; }
    .stat-card .stat-label a { text-decoration: none; color: var(--sidebar-active); font-weight: 500; }
    .stat-card .stat-label a:hover { text-decoration: underline; }
</style>

<div class="dashboard-stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $unread_count; ?></div>
        <div class="stat-label"><a href="kelola_pesan.php">Pesan Baru</a></div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $pendaftar_count; ?></div>
        <div class="stat-label"><a href="kelola_pendaftaran.php">Total Pendaftar</a></div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $berita_count; ?></div>
        <div class="stat-label"><a href="kelola_berita.php">Total Berita</a></div>
    </div>
</div>

<div style="margin-top: 40px; background: #fff; padding: 20px; border-radius: 8px;">
    <h3>Selamat Datang di Panel Admin</h3>
    <p>Gunakan menu navigasi di sebelah kiri untuk mengelola berbagai bagian dari website sekolah Anda.</p>
</div>

<?php 
// 4. Panggil footer untuk menutup semua tag HTML
include 'includes/footer.php'; 
?>