<?php

include '../config/koneksi.php';

// Fungsi Hapus Kereta
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $sql = "DELETE FROM destinations WHERE id=$id";
    $conn->query($sql);

    header("location: daf_destination.php");
}?>