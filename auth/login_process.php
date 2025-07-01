<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query user berdasarkan email
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: ../dashboard.php');
        exit;
    } else {
        // Login gagal
        echo "<script>alert('Email atau password salah!'); window.location='login.php';</script>";
        exit;
    }
} else {
    header('Location: login.php');
    exit;
} 