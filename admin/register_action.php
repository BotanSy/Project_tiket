<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = ($_POST['password']);
    $full_nm = $_POST['full_nm'];

    // Cek apakah username sudah ada
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows > 0) {
        echo "Username sudah ada!";
    } else {
        // Tambahkan pengguna baru
        $conn->query("INSERT INTO users (username, password, full_nm ,role) VALUES ('$username', '$password','$full_nm', 'user')");
        header("Location: index.php");
    }
}
?>
