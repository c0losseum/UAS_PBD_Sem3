<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'toko_meubel'; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
