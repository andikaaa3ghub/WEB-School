<?php
// 1. Panggil koneksi database
include '../includes/config.php';

// 2. Panggil kerangka utama admin (header & sidebar)
include 'includes/header.php';
?>

<style>
    .pesan-intro {
        margin-bottom: 24px;
        color: #555;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .table-container {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    table.pesan-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    table.pesan-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-color);
        border-top: none;
    }

    table.pesan-table td {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-size: 14px;
    }

    table.pesan-table tbody tr {
        transition: background-color 0.15s ease-in-out;
    }

    table.pesan-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Status Baris Belum Dibaca */
    table.pesan-table tr.unread td {
        font-weight: 600;
        color: #0f172a;
        background-color: #f0f9ff;
    }

    /* Badge Status */
    .badge-unread {
        display: inline-block;
        background-color: #0284c7;
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        margin-right: 8px;
    }

    .badge-read {
        display: inline-block;
        background-color: #e2e8f0;
        color: #64748b;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        margin-right: 8px;
    }

    /* Wadah Tombol Aksi */
    .action-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Desain Tombol Aksi Modern */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        white-space: nowrap;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-action-view {
        background-color: #2563eb;
        color: #ffffff;
        border-color: #1d4ed8;
    }

    .btn-action-view:hover {
        background-color: #1d4ed8;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    .btn-action-delete {
        background-color: #ffffff;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .btn-action-delete:hover {
        background-color: #fee2e2;
        border-color: #f87171;
        color: #b91c1c;
        box-shadow: 0 2px 5px rgba(220, 38, 38, 0.15);
        transform: translateY(-1px);
    }

    .pesan-date {
        color: #64748b;
        font-size: 13px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }
</style>

<div class="pesan-intro">
    Berikut adalah daftar pesan dari formulir kontak website sekolah. Pesan yang <strong>belum dibaca</strong> ditandai warna biru muda. Klik tombol <strong>Baca</strong> untuk melihat isi pesan lengkap atau <strong>Hapus</strong> jika pesan sudah selesai ditangani.
</div>

<div class="table-container">
    <table class="pesan-table">
        <thead>
            <tr>
                <th width="80px">Status</th>
                <th width="22%">Pengirim</th>
                <th>Subjek Pesan</th>
                <th width="18%">Tanggal Masuk</th>
                <th width="190px" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT id, name, subject, received_at, is_read FROM contact_messages ORDER BY received_at DESC");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $row_class = $row['is_read'] ? '' : 'unread';
                    $badge = $row['is_read'] ? '<span class="badge-read">Dibaca</span>' : '<span class="badge-unread">Baru</span>';
                    echo "<tr class='$row_class'>";
                    echo "<td>" . $badge . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td><span class='pesan-date'>" . date('d M Y, H:i', strtotime($row['received_at'])) . " WIB</span></td>";
                    echo "<td style='text-align: center;'>
                            <div class='action-group'>
                                <a href='baca_pesan.php?id=" . $row['id'] . "' class='btn-action btn-action-view' title='Baca isi pesan'>
                                    &#128065; Baca
                                </a>
                                <a href='hapus_pesan.php?id=" . $row['id'] . "' class='btn-action btn-action-delete' title='Hapus pesan ini' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesan dari " . htmlspecialchars(addslashes($row['name'])) . "?\");'>
                                    &#128465; Hapus
                                </a>
                            </div>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='empty-state'>&#128140; Belum ada pesan masuk di kotak masuk.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php 
// 3. Panggil footer untuk menutup kerangka
include 'includes/footer.php'; 
?>
