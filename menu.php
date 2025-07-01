<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
include 'config.php';

$menus = mysqli_query($koneksi, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Katalog Menu - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { text-align: center; margin-bottom: 32px; }
        .menu-list { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; }
        .menu-card { background: #f9f6f2; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); width: 260px; padding: 20px; text-align: center; transition: box-shadow 0.2s; }
        .menu-card:hover { box-shadow: 0 4px 16px rgba(107,79,44,0.15); }
        .menu-img { width: 100%; height: 140px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; background: #eee; }
        .menu-title { font-size: 1.2em; color: #6b4f2c; margin-bottom: 6px; }
        .menu-price { color: #bfa980; font-weight: bold; margin-bottom: 8px; }
        .menu-desc { font-size: 0.98em; color: #555; margin-bottom: 12px; }
        .add-btn { background: #6b4f2c; color: #fff; border: none; border-radius: 6px; padding: 8px 18px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .add-btn:hover { background: #543d1d; }
        .back { display: block; margin-top: 24px; text-align: center; }
        .back a { color: #6b4f2c; text-decoration: none; font-weight: bold; }
        .back a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Katalog Menu</h1>
        <div class="menu-list">
            <?php while ($menu = mysqli_fetch_assoc($menus)): ?>
                <div class="menu-card">
                    <?php if (!empty($menu['gambar'])): ?>
                        <img src="assets/<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['nama_menu']) ?>" class="menu-img">
                    <?php else: ?>
                        <div class="menu-img"></div>
                    <?php endif; ?>
                    <div class="menu-title"><?= htmlspecialchars($menu['nama_menu']) ?></div>
                    <div class="menu-price">Rp <?= number_format($menu['harga'],0,',','.') ?></div>
                    <div class="menu-desc"><?= htmlspecialchars($menu['deskripsi']) ?></div>
                    <form action="keranjang_proses.php" method="POST">
                        <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                        <button type="submit" class="add-btn">Tambah ke Keranjang</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="back">
            <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html> 