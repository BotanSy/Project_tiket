<?php
session_start();
include "../config/koneksi.php"; // Pastikan koneksi ke database

  include '../templates/header.php';
  include '../templates/navbar.php'; 
  include '../templates/sidebar.php';

// Pastikan hanya user yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pemesanan yang sudah dikonfirmasi
$result = mysqli_query($conn, "SELECT * FROM bookings WHERE user_id = '$user_id' AND status = 'confirmed'");

?>



<?php
include '../templates/footer.php';
