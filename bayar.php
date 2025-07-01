<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
// Ambil pesanan yang belum ada pembayaran
$q = "SELECT p.id, p.tanggal, p.total, p.status FROM pesanan p LEFT JOIN pembayaran b ON p.id = b.pesanan_id WHERE p.user_id='$user_id' AND (b.id IS NULL OR b.status='ditolak') AND p.status != 'selesai' ORDER BY p.tanggal DESC";
$pesanan = mysqli_query($koneksi, $q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pesanan - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { text-align: center; margin-bottom: 32px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        select, input[type="file"] { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { width: 100%; padding: 10px; background: #6b4f2c; color: #fff; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #543d1d; }
        .back { display: block; margin-top: 24px; text-align: center; }
        .back a { color: #6b4f2c; text-decoration: none; font-weight: bold; }
        .back a:hover { text-decoration: underline; }
        .empty { text-align: center; color: #888; margin: 32px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pembayaran Pesanan</h1>
        <?php if (mysqli_num_rows($pesanan) > 0): ?>
        <form action="bayar_proses.php" method="POST" enctype="multipart/form-data">
            <label for="pesanan_id">Pilih Pesanan</label>
            <select name="pesanan_id" id="pesanan_id" required>
                <option value="">-- Pilih Pesanan --</option>
                <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
                <option value="<?= $p['id'] ?>">#<?= $p['id'] ?> | <?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?> | Rp <?= number_format($p['total'],0,',','.') ?> | Status: <?= ucfirst($p['status']) ?></option>
                <?php endwhile; ?>
            </select>
            <label for="metode">Metode Pembayaran</label>
            <select name="metode" id="metode" required>
                <option value="">-- Pilih Metode --</option>
                <option value="transfer">Transfer Bank</option>
                <option value="qris">QRIS</option>
                <option value="tunai">Tunai</option>
            </select>
            <label for="bukti">Upload Bukti Pembayaran (jika non-tunai)</label>
            <input type="file" name="bukti" id="bukti" accept="image/*">
            <button type="submit" class="btn">Kirim Pembayaran</button>
        </form>
        <?php else: ?>
            <div class="empty">Tidak ada pesanan yang perlu dibayar.</div>
        <?php endif; ?>
        <div class="back">
            <a href="pesanan_saya.php">&larr; Kembali ke Pesanan Saya</a>
        </div>
    </div>
</body>
</html> 