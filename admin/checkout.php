<?php
session_start();
include '../config/koneksi.php';

// Pastikan hanya user yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: .../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Proses pemesanan dari form Custom Order
if (isset($_POST['destination_id']) && isset($_POST['departure_day']) && isset($_POST['quantity'])) {
    $destination_id = $_POST['destination_id'];
    $departure_day = $_POST['departure_day'];
    $quantity = $_POST['quantity'];

    // Ambil data harga dari `trains` berdasarkan tujuan
    $train_query = "SELECT trains.price_per_seat FROM trains 
                    JOIN schedules ON schedules.train_id = trains.id 
                    WHERE schedules.destination_id = '$destination_id' LIMIT 1";
    $train_result = mysqli_query($conn, $train_query);

    // Periksa apakah hasil query valid dan tidak kosong
    if ($train_result && mysqli_num_rows($train_result) > 0) {
        $train_row = mysqli_fetch_assoc($train_result);
        $price_per_ticket = $train_row['price_per_seat'];

        // Hitung total_harga
        $total_harga = $price_per_ticket * $quantity;

        // Masukkan data pemesanan ke dalam database
        $query = "INSERT INTO bookings (user_id, destination_id, departure_day, quantity, total_harga, status) 
                  VALUES ('$user_id', '$destination_id', '$departure_day', '$quantity', '$total_harga', 'Pending')";

        if (mysqli_query($conn, $query)) {
            // Alihkan pengguna ke confirm_admin.php setelah pemesanan berhasil
            header("Location: index1.php?order_id=" . mysqli_insert_id($conn));
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Price not found for the selected destination.";
    }
}

// Proses pemesanan dari form Available Schedules
if (isset($_POST['schedule_id']) && isset($_POST['quantity'])) {
    $schedule_id = $_POST['schedule_id'];
    $quantity = $_POST['quantity'];

    // Ambil data jadwal dan harga dari `trains`
    $schedule_query = "SELECT schedules.destination_id, schedules.departure_day, trains.price_per_seat 
                       FROM schedules 
                       JOIN trains ON schedules.train_id = trains.id 
                       WHERE schedules.id = '$schedule_id'";
    $schedule_result = mysqli_query($conn, $schedule_query);

    if ($schedule_result && mysqli_num_rows($schedule_result) > 0) {
        $schedule_row = mysqli_fetch_assoc($schedule_result);

        $destination_id = $schedule_row['destination_id'];
        $departure_day = $schedule_row['departure_day'];
        $price_per_ticket = $schedule_row['price_per_seat'];

        // Hitung total_harga
        $total_harga = $price_per_ticket * $quantity;

        // Masukkan data pemesanan ke dalam database
        $query = "INSERT INTO bookings (user_id, destination_id, departure_day, quantity, total_harga, status) 
                  VALUES ('$user_id', '$destination_id', '$departure_day', '$quantity', '$total_harga', 'Pending')";

        if (mysqli_query($conn, $query)) {
            // Alihkan pengguna ke confirm_admin.php setelah pemesanan berhasil
            header("Location: ../dasboard_user.php?order_id=" . mysqli_insert_id($conn));
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Schedule data not found.";
    }
}

// Cek untuk ID pemesanan
if (isset($_GET['order_id'])) {
    $reservation_id = $_GET['order_id'];
    $query = "SELECT * FROM bookings WHERE id = '$reservation_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);

        // Periksa jika total_harga valid
        if (is_null($reservation_id) || is_null($booking['total_harga'])) {
            die("Invalid payment details.");
        }
        // Proses pembayaran...
    } else {
        die("Invalid order ID.");
    }
}
?>
