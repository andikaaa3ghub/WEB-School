</main> <footer>
            <div class="container">
                <div class="footer-grid">
                    
                    <div class="footer-col">
                        <h4>Tentang Skansa</h4>
                        <p>
                            SMK Negeri 1 Kota Prabumulih (SKANSA) merupakan salah satu sekolah menengah kejuruan negeri terkemuka di Kota Prabumulih, Sumatera Selatan. Sekolah ini berfokus pada pendidikan keahlian manajemen, bisnis, dan layanan profesional untuk menyiapkan siswa siap kerja. SMK Negeri 1 Kota Prabumulih memiliki fasilitas modern, tenaga pengajar berkualitas, dan program pembelajaran yang relevan dengan kebutuhan industri saat ini. Sekolah ini juga aktif dalam berbagai kegiatan ekstrakurikuler dan kompetisi untuk mengembangkan potensi siswa secara menyeluruh.
                        </p>
                    </div>

                    <div class="footer-col">
                        <h4>Link Cepat</h4>
                        <ul>
                            <li><a href="profil.php?sub=sejarah">Profil Sekolah</a></li>
                            <li><a href="postingan.php">Berita & Kegiatan</a></li>
                            <li><a href="ppdb.php">Pendaftaran (PPDB)</a></li>
                            <li><a href="kontak.php">Hubungi Kami</a></li>
                        </ul>
                    </div>


                    <div class="footer-col">
                        <h4>Ikuti Kami</h4>
                        <ul>
                            <li><a href="https://web.facebook.com/profile.php?id=100080907600179&_rdc=1&_rdr" target="_blank">Facebook</a></li>
                            <li><a href="https://www.instagram.com/smkn_1prabumulih" target="_blank">Instagram</a></li>
                            <li><a href="https://www.tiktok.com/@osis_smkn1pbm" target="_blank">TikTok</a></li>
                        </ul>
                    </div>

                </div> <div class="footer-bottom">
                    &copy; <?php echo date("Y"); ?> SMK Negeri 1 Kota Prabumulih. © 2026 Copyright by andikaXadmin. All Rights Reserved.
                </div>

            </div> </footer>

        <script src="assets/js/script.js"></script>
    </body>
</html>
<?php
// Menutup koneksi database di akhir script
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>