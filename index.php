<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
// Halaman utama aplikasi pemesanan menu

echo "<h1>Selamat Datang di Aplikasi Pemesanan Menu</h1>";
echo "<h2>Selamat datang, " . htmlspecialchars($_SESSION['user_name']) . "!</h2>";
echo '<a href="auth/logout.php">Logout</a>'; 