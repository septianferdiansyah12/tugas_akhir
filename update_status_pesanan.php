<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['kasir','admin'])) {
    header('Location: auth/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    if (in_array($status, ['pending','diproses','selesai'])) {
        mysqli_query($koneksi, "UPDATE pesanan SET status='$status' WHERE id='$id'");
    }
}
header('Location: kelola_pesanan.php');
exit; 