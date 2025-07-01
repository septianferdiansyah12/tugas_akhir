<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// Ambil isi keranjang user
$query = "SELECT k.id, m.nama_menu, m.harga, k.jumlah, (m.harga * k.jumlah) as subtotal FROM keranjang k JOIN menu m ON k.menu_id = m.id WHERE k.user_id='$user_id'";
$result = mysqli_query($koneksi, $query);

$total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
    $total += $row['subtotal'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 700px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { text-align: center; margin-bottom: 32px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 10px 8px; text-align: center; }
        th { background: #6b4f2c; color: #fff; }
        tr:nth-child(even) { background: #f9f6f2; }
        .total { font-weight: bold; color: #6b4f2c; }
        .btn { background: #6b4f2c; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #543d1d; }
        .back { display: block; margin-top: 24px; text-align: center; }
        .back a { color: #6b4f2c; text-decoration: none; font-weight: bold; }
        .back a:hover { text-decoration: underline; }
        .empty { text-align: center; color: #888; margin: 32px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Keranjang Belanja</h1>
        <?php if (count($items) > 0): ?>
        <form action="#" method="POST">
        <table>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nama_menu']) ?></td>
                <td>Rp <?= number_format($item['harga'],0,',','.') ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td>Rp <?= number_format($item['subtotal'],0,',','.') ?></td>
                <td>
                    <form action="keranjang_update.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="number" name="jumlah" value="<?= $item['jumlah'] ?>" min="1" style="width:50px;">
                        <button type="submit" class="btn">Update</button>
                    </form>
                    <form action="keranjang_hapus.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" class="btn" style="background:#b94e4e;">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td colspan="2" class="total">Rp <?= number_format($total,0,',','.') ?></td>
            </tr>
        </table>
        <button type="button" class="btn" disabled>Pesan Sekarang</button>
        </form>
        <?php else: ?>
            <div class="empty">Keranjang masih kosong.</div>
        <?php endif; ?>
        <div class="back">
            <a href="menu.php">&larr; Kembali ke Menu</a>
        </div>
    </div>
</body>
</html> 