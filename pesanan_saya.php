<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// Ambil daftar pesanan user
$q = "SELECT * FROM pesanan WHERE user_id='$user_id' ORDER BY tanggal DESC";
$pesanan = mysqli_query($koneksi, $q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { text-align: center; margin-bottom: 32px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 10px 8px; text-align: center; }
        th { background: #6b4f2c; color: #fff; }
        tr:nth-child(even) { background: #f9f6f2; }
        .status { font-weight: bold; }
        .pending { color: #bfa980; }
        .diproses { color: #6b4f2c; }
        .selesai { color: #2e7d32; }
        .back { display: block; margin-top: 24px; text-align: center; }
        .back a { color: #6b4f2c; text-decoration: none; font-weight: bold; }
        .back a:hover { text-decoration: underline; }
        .empty { text-align: center; color: #888; margin: 32px 0; }
        .detail { background: #f5f5f5; border-radius: 8px; margin: 8px 0 16px 0; padding: 8px 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesanan Saya</h1>
        <?php if (isset($_GET['success'])): ?>
            <div style="color: #2e7d32; text-align:center; margin-bottom:18px;">Pesanan berhasil dibuat!</div>
        <?php endif; ?>
        <?php if (mysqli_num_rows($pesanan) > 0): ?>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
            <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
            <tr>
                <td><?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?></td>
                <td>Rp <?= number_format($p['total'],0,',','.') ?></td>
                <td class="status <?= $p['status'] ?>"><?= ucfirst($p['status']) ?></td>
                <td>
                    <?php
                    $pid = $p['id'];
                    $d = mysqli_query($koneksi, "SELECT m.nama_menu, pd.jumlah, pd.harga FROM pesanan_detail pd JOIN menu m ON pd.menu_id = m.id WHERE pd.pesanan_id='$pid'");
                    echo '<div class="detail">';
                    while ($row = mysqli_fetch_assoc($d)) {
                        echo htmlspecialchars($row['nama_menu']).' x'.$row['jumlah'].' (Rp '.number_format($row['harga'],0,',','.').')<br>';
                    }
                    echo '</div>';
                    ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <div class="empty">Belum ada pesanan.</div>
        <?php endif; ?>
        <div class="back">
            <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html> 