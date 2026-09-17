<?php
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama admin (header & sidebar)
include 'includes/header.php';

// 3. Logika untuk membaca pesan
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) {
    echo "<p>ID tidak valid.</p>";
    include 'includes/footer.php';
    exit;
}

// Tandai pesan sebagai sudah dibaca
mysqli_query($conn, "UPDATE contact_messages SET is_read = 1 WHERE id = $id");

// Ambil detail pesan
$result = mysqli_query($conn, "SELECT * FROM contact_messages WHERE id = $id");
if (mysqli_num_rows($result) == 0) {
    echo "<p>Pesan tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit;
}
$msg = mysqli_fetch_assoc($result);
?>

<style>
    .message-detail {
        border: 1px solid var(--border-color);
        border-radius: 8px;
    }
    .message-header {
        padding: 20px;
        background: #f9f9f9;
        border-bottom: 1px solid var(--border-color);
    }
    .message-header strong {
        display: inline-block;
        width: 80px;
    }
    .message-body {
        padding: 20px;
        white-space: pre-wrap; /* Mempertahankan baris baru dari pesan */
        line-height: 1.7;
    }
</style>

<div class="message-detail">
    <div class="message-header">
        <p><strong>Dari:</strong> <?php echo htmlspecialchars($msg['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
        <p><strong>Subjek:</strong> <?php echo htmlspecialchars($msg['subject']); ?></p>
        <p><strong>Tanggal:</strong> <?php echo date('d F Y, H:i', strtotime($msg['received_at'])); ?></p>
    </div>
    <div class="message-body">
        <?php echo htmlspecialchars($msg['message']); ?>
    </div>
</div>
<?php 
// 4. Panggil footer untuk menutup kerangka
include 'includes/footer.php'; 
?>