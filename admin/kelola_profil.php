<?php 
// Panggil kerangka utama admin
include 'includes/header.php'; 
?>

<style>
    .profile-menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }
    .menu-card {
        background: #fff;
        border: 1px solid var(--border-color);
        padding: 28px 24px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .menu-card .icon-profil {
        font-size: 38px;
        margin-bottom: 12px;
    }
    .menu-card h4 {
        margin-top: 0;
        margin-bottom: 8px;
        color: var(--sidebar-bg);
        font-size: 18px;
    }
    .menu-card p {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .menu-card a.btn-action {
        background: var(--sidebar-active);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 6px;
        display: inline-block;
        font-weight: 500;
        font-size: 14px;
        transition: background-color 0.2s;
    }
    .menu-card a.btn-action:hover {
        background: #1f6391;
    }
</style>

<p style="color:#555; font-size:15px; line-height:1.6;">
    Kelola isi konten dan teks profil sekolah Anda di bawah ini. Anda dapat menuliskan paragraf, visi misi, serta sarana prasarana yang tersusun rapi ke bawah (mendukung baris baru dengan tombol Enter).
</p>

<div class="profile-menu-grid">
    <div class="menu-card">
        <div>
            <div class="icon-profil">&#128214;</div>
            <h4>Sejarah Sekolah</h4>
            <p>Atur narasi sejarah berdirinya sekolah, latar belakang, dan perkembangan institusi.</p>
        </div>
        <a href="edit_konten_profil.php?halaman=sejarah" class="btn-action">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <div>
            <div class="icon-profil">&#127919;</div>
            <h4>Visi & Misi</h4>
            <p>Susun poin-poin visi cita-cita dan butir-butir misi sekolah secara teratur ke bawah.</p>
        </div>
        <a href="edit_konten_profil.php?halaman=visi-misi" class="btn-action">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <div>
            <div class="icon-profil">&#128101;</div>
            <h4>Struktur Organisasi</h4>
            <p>Kelola deskripsi susunan kepemimpinan dan unggah bagan struktur organisasi sekolah.</p>
        </div>
        <a href="edit_konten_profil.php?halaman=struktur" class="btn-action">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <div>
            <div class="icon-profil">&#127979;</div>
            <h4>Sarana & Prasarana</h4>
            <p>Daftar sarana, fasilitas belajar, laboratorium, dan gedung sekolah satu per baris.</p>
        </div>
        <a href="edit_konten_profil.php?halaman=sarana" class="btn-action">Edit Halaman</a>
    </div>
    <div class="menu-card">
        <div>
            <div class="icon-profil">&#128104;&#8205;&#127979;</div>
            <h4>Guru & Staff</h4>
            <p>Kelola data nama pengajar, foto profil pendidik, serta jabatan dewan guru.</p>
        </div>
        <a href="kelola_guru.php" class="btn-action" style="background:#27ae60;">Kelola Data Guru</a>
    </div>
</div>

<?php 
// Panggil footer
include 'includes/footer.php'; 
?>
