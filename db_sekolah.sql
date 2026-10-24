-- ==========================================================
-- DATABASE RESMI: db_sekolah
-- Website Profil Sekolah & PPDB Online
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `db_sekolah` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_sekolah`;

-- 1. Tabel Akun Administrator
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Akun Default: Username 'admin', Password 'admin'
INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$6y1iY2k7xRaCWD7TdSil6OxXlNw3ZKGxUjAjda3ZdHpsmReK9u7Rq', NOW())
ON DUPLICATE KEY UPDATE `username`=VALUES(`username`);

-- 2. Tabel Banner Slider Beranda
CREATE TABLE IF NOT EXISTS `slider_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_filename` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `slider_images` (`id`, `image_filename`, `uploaded_at`) VALUES
(1, '1751718104_Gemini_Generated_Image_vw2tlgvw2tlgvw2t.png', NOW()),
(2, '1751718107_Gemini_Generated_Image_swplauswplauswpl.png', NOW()),
(3, '1751721215_Gemini_Generated_Image_yjk25vyjk25vyjk2.png', NOW())
ON DUPLICATE KEY UPDATE `image_filename`=VALUES(`image_filename`);

-- 3. Tabel Konten Profil Sekolah (Sejarah, Visi-Misi, Struktur, Fasilitas)
CREATE TABLE IF NOT EXISTS `profil_konten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_halaman` varchar(50) NOT NULL,
  `konten` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_halaman` (`key_halaman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profil_konten` (`id`, `key_halaman`, `konten`, `updated_at`) VALUES
(1, 'sejarah', '{"judul":"Sejarah Berdirinya Sekolah XYZ","deskripsi":"Sekolah XYZ didirikan pada tahun 1995 dengan komitmen untuk menghadirkan pendidikan berkualitas, inklusif, dan berkarakter bagi seluruh generasi muda. Berawal dari sebuah gedung sederhana dengan 3 ruang kelas, kini sekolah kami telah berkembang menjadi salah satu lembaga pendidikan unggulan dengan ribuan lulusan berprestasi di tingkat nasional dan internasional."}', NOW()),
(2, 'visi-misi', '{"judul_visi":"Visi Sekolah","isi_visi":"Terwujudnya insan cendekia yang beriman, unggul dalam prestasi IPTEK, berkarakter mulia, dan berwawasan lingkungan global.","judul_misi":"Misi Sekolah","isi_misi":"1. Menyelenggarakan proses pembelajaran inovatif berbasis teknologi informasi.\\n2. Menumbuhkembangkan nilai spiritual, integritas, dan budi pekerti luhur.\\n3. Mengembangkan potensi bakat dan minat siswa di bidang akademik maupun non-akademik.\\n4. Membangun lingkungan belajar yang ramah, aman, disiplin, dan berwawasan lingkungan hidup."}', NOW()),
(3, 'struktur', '{"judul":"Struktur Organisasi Sekolah","deskripsi":"Berikut adalah bagan struktur kepemimpinan dan manajemen organisasi di Sekolah XYZ untuk menjamin tata kelola operasional yang akuntabel dan transparan.","gambar":"1751711850_8656485.jpg"}', NOW()),
(4, 'sarana', '{"judul":"Fasilitas & Sarana Prasarana","daftar_sarana":"Gedung Pembelajaran Modern & Full AC\\nLaboratorium Komputer & Multimedia Canggih\\nLaboratorium Sains (Fisika, Kimia, Biologi)\\nPerpustakaan Digital dan Ruang Baca Nyaman\\nLapangan Olahraga Multifungsi (Futsal, Basket, Voli)\\nAula Pertemuan Serbaguna Kapasitas 500 Orang\\nMasjid Sekolah dan Ruang Ibadah\\nKantin Sehat dan UKS Standar Nasional"}', NOW())
ON DUPLICATE KEY UPDATE `konten`=VALUES(`konten`);

-- 4. Tabel Berita, Pengumuman & Artikel Sekolah
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`id`, `title`, `category`, `content`, `image`, `created_at`) VALUES
(1, 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 Resmi Dibuka', 'Pengumuman', 'Sekolah XYZ secara resmi membuka pendaftaran peserta didik baru untuk tahun ajaran 2026/2027. Pendaftaran dapat dilakukan secara online melalui portal PPDB ini dengan mengisi formulir dan mengunggah berkas persyaratan. Segera daftarkan putra-putri Anda sebelum kuota terpenuhi!', '1751719678_Gemini_Generated_Image_szftlgszftlgszft.png', NOW() - INTERVAL 10 DAY),
(2, 'Prestasi Gemilang! Tim Sains Sekolah Meraih Medali Emas Olimpiade', 'Prestasi', 'Kabar membanggakan datang dari delegasi tim sains Sekolah XYZ yang berhasil meraih Medali Emas pada kompetisi Olimpiade Sains Nasional. Keberhasilan ini membuktikan dedikasi siswa dan bimbingan para guru pembina yang tidak kenal lelah.', '1751719787_Gemini_Generated_Image_8i4dsc8i4dsc8i4d.png', NOW() - INTERVAL 7 DAY),
(3, 'Kegiatan Gebyar Seni dan Budaya Siswa Berlangsung Meriah', 'Kegiatan', 'Seluruh siswa dan dewan guru berpartisipasi aktif dalam kegiatan tahunan Gebyar Seni dan Budaya. Berbagai pertunjukan tari daerah, musik tradisional, teater, dan pameran karya kreatif ditampilkan secara memukau di panggung utama sekolah.', '1751719816_Gemini_Generated_Image_oyb9wloyb9wloyb9.png', NOW() - INTERVAL 4 DAY),
(4, 'Workshop Peningkatan Kompetensi Literasi Digital Guru dan Staf', 'Pendidikan', 'Dalam rangka menyongsong era transformasi pendidikan digital, sekolah mengadakan workshop intensif tentang pembelajaran interaktif dan integrasi kecerdasan buatan dalam kurikulum untuk seluruh staf pendidik.', '1751719844_Gemini_Generated_Image_lfef67lfef67lfef.png', NOW() - INTERVAL 2 DAY)
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- 5. Tabel Dewan Guru & Staf Pengajar
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'default_avatar.png',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `teachers` (`id`, `name`, `position`, `photo`, `created_at`) VALUES
(1, 'Drs. H. Ahmad Sudrajat, M.Pd.', 'Kepala Sekolah & Pembina Pendidikan', '1751718223_Gemini_Generated_Image_gas0o1gas0o1gas0.png', NOW()),
(2, 'Siti Nurhaliza, S.Pd., M.Si.', 'Wakil Kepala Sekolah Bidang Kurikulum', '1751718345_Gemini_Generated_Image_b3qes9b3qes9b3qe.png', NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- 6. Tabel Pendaftar Siswa Baru (PPDB Online)
CREATE TABLE IF NOT EXISTS `students_ppdb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `address` text NOT NULL,
  `previous_school` varchar(255) NOT NULL,
  `file_document` varchar(255) DEFAULT 'default.pdf',
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `students_ppdb` (`id`, `full_name`, `birth_place`, `birth_date`, `address`, `previous_school`, `file_document`, `registration_date`) VALUES
(1, 'Budi Pratama Wijaya', 'Jakarta', '2010-05-14', 'Jl. Kenanga Indah No. 42, Jakarta', 'SMP Negeri 1 Jakarta', '1751721110_PEDOMANPENULISANSKRIPSI20232024.pdf', NOW() - INTERVAL 3 DAY),
(2, 'Annisa Rahmadani', 'Bandung', '2010-09-22', 'Jl. Merpati Putih No. 17, Bandung', 'SMP Unggulan Bangsa', '1751721110_PEDOMANPENULISANSKRIPSI20232024.pdf', NOW() - INTERVAL 1 DAY)
ON DUPLICATE KEY UPDATE `full_name`=VALUES(`full_name`);

-- 7. Tabel Kolom Dinamis / Tambahan Formulir PPDB
CREATE TABLE IF NOT EXISTS `ppdb_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_label` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL DEFAULT 'text',
  `field_options` text DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `field_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ppdb_fields` (`id`, `field_label`, `field_type`, `field_options`, `is_required`, `field_order`) VALUES
(1, 'Nama Wali / Orang Tua', 'text', '', 1, 1),
(2, 'Nomor WhatsApp Orang Tua', 'text', '', 1, 2),
(3, 'Pilihan Jurusan Utama', 'select', 'MIPA (Matematika & IPA),IPS (Ilmu Pengetahuan Sosial),Bahasa & Budaya', 1, 3)
ON DUPLICATE KEY UPDATE `field_label`=VALUES(`field_label`);

-- 8. Tabel Data Nilai Kolom Tambahan PPDB
CREATE TABLE IF NOT EXISTS `ppdb_field_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ppdb_field_data` (`id`, `student_id`, `field_id`, `field_value`) VALUES
(1, 1, 1, 'Hendra Wijaya'),
(2, 1, 2, '081234567890'),
(3, 1, 3, 'MIPA (Matematika & IPA)'),
(4, 2, 1, 'Farhan Rahmadi'),
(5, 2, 2, '085298765432'),
(6, 2, 3, 'IPS (Ilmu Pengetahuan Sosial)')
ON DUPLICATE KEY UPDATE `field_value`=VALUES(`field_value`);

-- 9. Tabel Pesan Masuk dari Formulir Kontak
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `received_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `received_at`) VALUES
(1, 'Rian Hidayat', 'rian.hidayat@gmail.com', 'Informasi Jadwal Seleksi PPDB', 'Halo admin sekolah, apakah ada tes tertulis atau tes wawancara untuk jalur prestasi pada PPDB tahun ini? Terima kasih.', 0, NOW() - INTERVAL 1 DAY),
(2, 'Ibu Maya Lestari', 'maya.lestari@yahoo.com', 'Jadwal Kunjungan Kampus', 'Selamat siang, saya orang tua calon siswa ingin menanyakan apakah ada open house atau jadwal kunjungan kampus sekolah minggu depan?', 1, NOW() - INTERVAL 3 DAY)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);