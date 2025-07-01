<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['kasir','admin'])) {
    header('Location: auth/login.php');
    exit;
}

// Ambil semua pesanan
$q = "SELECT p.*, u.name FROM pesanan p JOIN users u ON p.user_id = u.id ORDER BY p.tanggal DESC";
$pesanan = mysqli_query($koneksi, $q);

function next_status($status) {
    if ($status == 'pending') return 'diproses';
    if ($status == 'diproses') return 'selesai';
    return null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { text-align: center; margin-bottom: 32px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 10px 8px; text-align: center; }
        th { background: #6b4f2c; color: #fff; }
        tr:nth-child(even) { background: #f9f6f2; }
        .status { font-weight: bold; }
        .pending { color: #bfa980; }
        .diproses { color: #6b4f2c; }
        .selesai { color: #2e7d32; }
        .btn { background: #6b4f2c; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #543d1d; }
        .detail { background: #f5f5f5; border-radius: 8px; margin: 8px 0 16px 0; padding: 8px 16px; }
        .back { display: block; margin-top: 24px; text-align: center; }
        .back a { color: #6b4f2c; text-decoration: none; font-weight: bold; }
        .back a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Pesanan</h1>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Pemesan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Detail</th>
                <th>Aksi</th>
            </tr>
            <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
            <tr>
                <td><?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
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
                <td>
                    <?php $next = next_status($p['status']); if ($next): ?>
                    <form action="update_status_pesanan.php" method="POST">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="status" value="<?= $next ?>">
                        <button type="submit" class="btn">Set <?= ucfirst($next) ?></button>
                    </form>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div class="back">
            <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html> 