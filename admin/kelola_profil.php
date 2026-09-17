<?php 
// Panggil kerangka utama admin
include 'includes/header.php'; 
?>

<style>
    .profile-menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    .menu-card {
        background: #fff;
        border: 1px solid var(--border-color);
        padding: 25px;
        text-align: center;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    .menu-card h4 {
        margin-top: 0;
        margin-bottom: 10px;
        color: var(--sidebar-bg);
    }
    .menu-card a {
        background: var(--sidebar-active);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
    }
</style>

<p>Pilih bagian dari profil sekolah yang ingin Anda kelola melalui menu di bawah ini atau melalui sidebar.</p>
<br>
<div class="profile-menu-grid">
    <div class="menu-card">
        <h4>Sejarah Sekolah</h4>
        <a href="edit_konten_profil.php?halaman=sejarah">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <h4>Visi & Misi</h4>
        <a href="edit_konten_profil.php?halaman=visi-misi">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <h4>Struktur Organisasi</h4>
        <a href="edit_konten_profil.php?halaman=struktur">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <h4>Sarana & Prasarana</h4>
        <a href="edit_konten_profil.php?halaman=sarana">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <h4>Guru & Staff</h4>
        <a href="kelola_guru.php">Kelola Data Guru</a>
    </div>
</div>
<?php 
// Panggil footer
include 'includes/footer.php'; 
?>