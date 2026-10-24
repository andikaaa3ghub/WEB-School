<?php
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama admin (header & sidebar)
include 'includes/header.php';

// 3. Logika untuk membaca pesan
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) {
    echo "<p>ID pesan tidak valid.</p>";
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
    .message-card {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .message-header-bar {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .message-meta-list {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 8px 16px;
        font-size: 14px;
    }
    .message-meta-list dt {
        font-weight: 600;
        color: #475569;
    }
    .message-meta-list dd {
        margin: 0;
        color: #1e293b;
    }
    .message-body-area {
        padding: 30px 24px;
        white-space: pre-wrap;
        line-height: 1.8;
        font-size: 15px;
        color: #334155;
        background: #ffffff;
    }
    .message-action-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-msg {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-msg-back {
        background: #64748b;
        color: white;
    }
    .btn-msg-back:hover {
        background: #475569;
    }
    .btn-msg-reply {
        background: #2563eb;
        color: white;
    }
    .btn-msg-reply:hover {
        background: #1d4ed8;
    }
    .btn-msg-del {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    .btn-msg-del:hover {
        background: #fee2e2;
    }
</style>

<div class="message-card">
    <div class="message-header-bar">
        <dl class="message-meta-list">
            <dt>Pengirim</dt>
            <dd><strong><?php echo htmlspecialchars($msg['name']); ?></strong> (&lt;<?php echo htmlspecialchars($msg['email']); ?>&gt;)</dd>
            <dt>Subjek</dt>
            <dd><strong><?php echo htmlspecialchars($msg['subject']); ?></strong></dd>
            <dt>Waktu</dt>
            <dd><?php echo date('d F Y, H:i', strtotime($msg['received_at'])); ?> WIB</dd>
        </dl>
        <div style="display:flex; gap:8px;">
            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: <?php echo rawurlencode($msg['subject']); ?>" class="btn-msg btn-msg-reply">
                &#9993; Balas via Email
            </a>
            <a href="hapus_pesan.php?id=<?php echo $msg['id']; ?>" class="btn-msg btn-msg-del" onclick="return confirm('Yakin ingin menghapus pesan ini?');">
                &#128465; Hapus Pesan
            </a>
        </div>
    </div>
    <div class="message-body-area">
        <?php echo htmlspecialchars($msg['message']); ?>
    </div>
    <div class="message-action-footer">
        <a href="kelola_pesan.php" class="btn-msg btn-msg-back">
            &larr; Kembali ke Kotak Masuk
        </a>
    </div>
</div>

<?php 
// 4. Panggil footer untuk menutup kerangka
include 'includes/footer.php'; 
?>
