<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {
    $user_id = $_SESSION['user_id'];
    $menu_id = intval($_POST['menu_id']);

    // Cek apakah menu sudah ada di keranjang user
    $cek = mysqli_query($koneksi, "SELECT id, jumlah FROM keranjang WHERE user_id='$user_id' AND menu_id='$menu_id'");
    if ($row = mysqli_fetch_assoc($cek)) {
        // Jika sudah ada, update jumlah
        $new_jumlah = $row['jumlah'] + 1;
        mysqli_query($koneksi, "UPDATE keranjang SET jumlah='$new_jumlah' WHERE id='{$row['id']}'");
    } else {
        // Jika belum ada, insert baru
        mysqli_query($koneksi, "INSERT INTO keranjang (user_id, menu_id, jumlah) VALUES ('$user_id', '$menu_id', 1)");
    }
}
header('Location: menu.php');
exit; 