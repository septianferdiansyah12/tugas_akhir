<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['jumlah'])) {
    $id = intval($_POST['id']);
    $jumlah = max(1, intval($_POST['jumlah']));
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah='$jumlah' WHERE id='$id'");
}
 