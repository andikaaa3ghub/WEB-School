</main> <footer>
            <div class="container">
                <div class="footer-grid">
                    
                    <div class="footer-col">
                        <h4>Tentang Sekolah XYZ</h4>
                        <p>
                            Sekolah XYZ berkomitmen untuk menyediakan pendidikan berkualitas yang menginspirasi siswa untuk mencapai potensi penuh mereka.
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
                            <li><a href="#" target="_blank">Facebook</a></li>
                            <li><a href="#" target="_blank">Instagram</a></li>
                            <li><a href="#" target="_blank">YouTube</a></li>
                        </ul>
                    </div>

                </div> <div class="footer-bottom">
                    &copy; <?php echo date("Y"); ?> Sekolah XYZ. Didesain dan Dikembangkan Oleh Maulana Malik H, Mohon Izin Terlebih Dahulu Untuk Mengeditnya.
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