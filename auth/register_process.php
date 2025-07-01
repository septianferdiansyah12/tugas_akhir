<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Cek email sudah terdaftar
    $cek = mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.location='register.php';</script>";
        exit;
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan user baru
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password_hash', '$role')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Registrasi gagal!'); window.location='register.php';</script>";
        exit;
    }
} else {
    header('Location: register.php');
    exit;
} 