<?php
// Konfigurasi koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "db_pemesanan");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
} 