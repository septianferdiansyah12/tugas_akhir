<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'pelanggan') {
    header('Location: auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesanan_id'], $_POST['metode'])) {
    $pesanan_id = intval($_POST['pesanan_id']);
    $metode = mysqli_real_escape_string($koneksi, $_POST['metode']);
    $bukti = null;

    // Upload bukti jika ada file dan bukan tunai
    if ($metode != 'tunai' && isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (in_array($ext, $allowed)) {
            $bukti = 'bukti_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            move_uploaded_file($_FILES['bukti']['tmp_name'], 'assets/' . $bukti);
        }
    }

    // Simpan ke tabel pembayaran
    $bukti_sql = $bukti ? "'$bukti'" : 'NULL';
    mysqli_query($koneksi, "INSERT INTO pembayaran (pesanan_id, metode, bukti) VALUES ('$pesanan_id', '$metode', $bukti_sql)");

    header('Location: pesanan_saya.php?bayar=1');
    exit;
} else {
    header('Location: bayar.php');
    exit;
} 