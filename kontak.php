<?php
include 'includes/config.php';
$message_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if (mysqli_query($conn, $query)) {
        $message_status = '<div class="alert success">Pesan Anda berhasil terkirim. Terima kasih!</div>';
    } else {
        $message_status = '<div class="alert error">Maaf, terjadi kesalahan. Silakan coba lagi.</div>';
    }
}
include 'includes/header.php';
?>

<section class="page-header">
    <h1>Hubungi Kami</h1>
</section>

<section class="page-section">
    <div class="container">
        <?php echo $message_status; ?>
        <div class="contact-grid">
            <div class="contact-info">
                <h4>Informasi Kontak</h4>
                <p>Jangan ragu untuk menghubungi kami melalui detail di bawah ini atau melalui formulir di samping.</p>
                <p><strong>Alamat:</strong> Jl. M. Yusuf Wahid No. 1, Prabumulih.</p>
                <p><strong>Telepon:</strong> 082185280514</p>
                <p><strong>Email:</strong> smkn1.prabumulih@gmail.com</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.8142879971024!2d104.24500647497224!3d-3.3954605965791322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3a337c4c0ad839%3A0x5cbff942feb915fd!2sSMK%20Negeri%201%20Prabumulih!5e0!3m2!1sid!2sid!4v1789682529979!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>

            <div class="form-wrapper" style="padding:30px;">
                <h4>Kirim Pesan</h4>
                <form action="kontak.php" method="post">
                    <div class="form-group"><label for="name">Nama Anda</label><input type="text" id="name" name="name" required></div>
                    <div class="form-group"><label for="email">Email Anda</label><input type="email" id="email" name="email" required></div>
                    <div class="form-group"><label for="subject">Subjek</label><input type="text" id="subject" name="subject" required></div>
                    <div class="form-group"><label for="message">Pesan</label><textarea id="message" name="message" rows="5" required></textarea></div>
                    <div class="form-group"><button type="submit" class="btn">Kirim Pesan</button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>