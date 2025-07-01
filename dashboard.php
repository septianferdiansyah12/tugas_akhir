<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - d'edge coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f5f5; }
        .header {
            background: linear-gradient(90deg, #6b4f2c 60%, #bfa980 100%);
            color: #fff;
            padding: 32px 0 24px 0;
            text-align: center;
            border-radius: 0 0 32px 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 32px;
        }
        .header img {
            width: 80px;
            margin-bottom: 12px;
        }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 32px 24px; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        h1 { margin-bottom: 8px; font-size: 2.2em; }
        .role { color: #6b4f2c; margin-bottom: 32px; font-size: 1.1em; }
        .features { display: flex; flex-wrap: wrap; gap: 24px; justify-content: center; margin-bottom: 32px; }
        .card {
            background: #f9f6f2;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            padding: 28px 24px;
            min-width: 220px;
            flex: 1 1 220px;
            text-align: center;
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: 0 4px 16px rgba(107,79,44,0.15);
        }
        .card-title {
            font-size: 1.2em;
            color: #6b4f2c;
            margin-bottom: 10px;
        }
        .card-link {
            display: inline-block;
            margin-top: 10px;
            color: #fff;
            background: #6b4f2c;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .card-link:hover {
            background: #543d1d;
        }
        .logout {
            display: block;
            text-align: right;
            margin-top: 12px;
        }
        .logout a {
            color: #b94e4e;
            text-decoration: none;
            font-weight: bold;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://img.icons8.com/ios-filled/100/ffffff/coffee-cup.png" alt="Coffee Icon">
        <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
        <div class="role">Role: <b><?= htmlspecialchars($_SESSION['user_role']) ?></b></div>
    </div>
    <div class="container">
        <div class="features">
            <?php if ($_SESSION['user_role'] == 'kasir'): ?>
                <div class="card">
                    <div class="card-title">Kelola Pesanan</div>
                    <div>Proses dan pantau pesanan pelanggan secara real-time.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
                <div class="card">
                    <div class="card-title">Kelola Menu</div>
                    <div>Tambah, edit, atau hapus menu makanan & minuman.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
            <?php elseif ($_SESSION['user_role'] == 'pelanggan'): ?>
                <div class="card">
                    <div class="card-title">Lihat Menu</div>
                    <div>Lihat katalog menu dan pesan makanan/minuman favoritmu.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
                <div class="card">
                    <div class="card-title">Pesanan Saya</div>
                    <div>Lihat status dan riwayat pesananmu di sini.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
            <?php elseif ($_SESSION['user_role'] == 'admin'): ?>
                <div class="card">
                    <div class="card-title">Kelola User</div>
                    <div>Kelola data user, kasir, dan pelanggan aplikasi.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
                <div class="card">
                    <div class="card-title">Laporan</div>
                    <div>Lihat laporan transaksi dan statistik aplikasi.</div>
                    <a href="#" class="card-link">Buka</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="logout">
            <a href="auth/logout.php">Logout</a>
        </div>
    </div>
</body>
</html> 