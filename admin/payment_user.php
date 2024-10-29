<?php
session_start();
include '../config/koneksi.php';

// Pastikan hanya user yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

// Cek untuk ID pemesanan
if (isset($_GET['order_id'])) {
    $reservation_id = $_GET['order_id'];
    $query = "SELECT * FROM bookings WHERE id = '$reservation_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        die("Invalid order ID.");
    }
} else {
    die("No order ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Payment Details</h1>
    <p>Order ID: <?php echo $booking['id']; ?></p>
    <p>Destination ID: <?php echo $booking['destination_id']; ?></p>
    <p>Departure Day: <?php echo $booking['departure_day']; ?></p>
    <p>Quantity: <?php echo $booking['quantity']; ?></p>
    <p>Total Price: <?php echo number_format($booking['total_harga'], 2); ?></p>
    <p>Status: <?php echo $booking['status']; ?></p>
    <a href="user_dashboard.php" class="btn btn-secondary">Back</a>
</div>
</body>
</html>