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

// Ambil data pemesanan yang pending
$result = mysqli_query($conn, "
    SELECT b.id AS reservation_id, u.full_nm AS user_name, d.destination_name, b.departure_day AS reservation_date, b.total_harga AS price, b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN schedules s ON s.destination_id = b.destination_id  -- Ubah join sesuai dengan kolom yang ada
    JOIN destinations d ON s.destination_id = d.id
    WHERE b.status = 'Pending'
");

// Periksa apakah query berhasil
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<div class="main-panel">
          <div class="content-wrapper">
          <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title">Payments</h2>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                        <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Destination</th>
                                        <th>Order Date</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 0;
                                    while ($order = mysqli_fetch_assoc($result)) { 
                                        $no++;    
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?php echo $order['user_name']; ?></td>
                                        <td><?php echo $order['destination_name']; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($order['reservation_date'])); ?></td>
                                        <td>Rp<?php echo number_format($order['price'], 2, ',', '.'); ?></td>
                                        <td><?php echo $order['status']; ?></td>
                                        <td>
                                            <form action="admin_confirm.php" method="post">
                                                <input type="hidden" name="reservation_id" value="<?php echo $order['reservation_id']; ?>">
                                                <button type="submit" class="btn btn-success">Konfirmasi</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                  
          </div>

<?php
include '../templates/footer.php';