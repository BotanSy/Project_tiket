<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'] ?? null;

    if (is_null($reservation_id)) {
        die("Invalid reservation ID.");
    }

    // Konfirmasi pesanan
    $update_status = mysqli_query($conn, "UPDATE bookings SET status = 'confirmed' WHERE id = '$reservation_id'");

    if (!$update_status) {
        die("Gagal mengonfirmasi pesanan: " . mysqli_error($conn));
    }

    // Setelah berhasil, arahkan ke halaman view_orders.php
    header("Location: confirm_admin.php");
    exit;
}
?>