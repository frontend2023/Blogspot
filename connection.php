<?php
// Mulai sesi
session_start();

// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // Ganti dengan password MySQL Anda jika ada
$dbname = "php1";

// Membuat koneksi PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Atur mode error PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Atur mode fetch ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Jika terjadi kesalahan dalam koneksi
    die("Koneksi gagal: " . $e->getMessage());
}
?>