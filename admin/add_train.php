<?php
session_start();
include "../config/koneksi.php"; // Pastikan koneksi ke database

  include '../templates/header.php';
  include '../templates/navbar.php'; 
  include '../templates/sidebar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['add_train'])) {
    $code = $_POST['code'];
    $available_seats = $_POST['available_seats'];
    $price_per_seat = $_POST['price_per_seat'];
    $sql = "INSERT INTO trains (code, available_seats, price_per_seat) VALUES ('$code', $available_seats, $price_per_seat)";
    $conn->query($sql);
    
    header("location:daf_kereta.php");
    exit();
}

?>

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body"><br><br><br>
                    <h2 class="card-title">Add Destinations Form</h2>
                    <form method="POST" action="">
                            <div class="form-group" style="margin-top: 4rem;">
                                <label>Trains Code :</label>
                                <input type="text" name="code" class="form-control" placeholder="Input Code" required>
                            </div></br>
                            <div class="form-group">
                                <label>Seating Capacity :</label>
                                <input type="number" name="available_seats" class="form-control" placeholder="Input Seating" required>
                            </div></br>
                            <div class="form-group">
                                <label>Price :</label>
                                <input type="decimal" name="price_per_seat" class="form-control" placeholder="Input Price" required>
                            </div></br>
                            <button type="submit" name="add_train" class="btn btn-primary">Submit</button>
                        </form>
                  </div>
                </div>
              </div>
<?php
include '../templates/footer.php';