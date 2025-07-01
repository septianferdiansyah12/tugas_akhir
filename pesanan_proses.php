<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// Ambil isi keranjang user
$query = "SELECT k.menu_id, k.jumlah, m.harga FROM keranjang k JOIN menu m ON k.menu_id = m.id WHERE k.user_id='$user_id'";
$result = mysqli_query($koneksi, $query);

$items = [];
$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
    $total += $row['harga'] * $row['jumlah'];
}

if (count($items) > 0) {
    // Simpan ke tabel pesanan
    mysqli_query($koneksi, "INSERT INTO pesanan (user_id, total) VALUES ('$user_id', '$total')");
    $pesanan_id = mysqli_insert_id($koneksi);
    // Simpan detail pesanan
    foreach ($items as $item) {
        $menu_id = $item['menu_id'];
        $jumlah = $item['jumlah'];
        $harga = $item['harga'];
        mysqli_query($koneksi, "INSERT INTO pesanan_detail (pesanan_id, menu_id, jumlah, harga) VALUES ('$pesanan_id', '$menu_id', '$jumlah', '$harga')");
    }
    // Kosongkan keranjang
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE user_id='$user_id'");
    header('Location: pesanan_saya.php?success=1');
    exit;
} else {
    header('Location: keranjang.php');
    exit;
} 