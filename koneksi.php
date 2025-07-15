<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "resto_app"; // Ganti dengan nama database Anda jika berbeda

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?> 