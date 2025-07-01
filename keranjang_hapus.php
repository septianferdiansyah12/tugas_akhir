<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id='$id'");
}
header('Location: keranjang.php');
exit; 