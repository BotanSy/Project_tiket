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

// Fungsi Hapus Keberangkatan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM schedules WHERE id=$id";
    $conn->query($sql);
    echo "Jadwal keberangkatan berhasil dihapus.";
}

$schedules = $conn->query("SELECT schedules.*, trains.code AS train_code, destinations.destination_name AS destination_name 
    FROM schedules 
    JOIN trains ON schedules.train_id = trains.id 
    JOIN destinations ON schedules.destination_id = destinations.id");
?>

<div class="main-panel">
          <div class="content-wrapper">
          <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title">Schedules</h2>
                    <button type="button" class="btn btn-outline-primary btn-fw"><a href="add_schedule.php" class="btn btn-inverse-{color}">Add New Schedules</a></button>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                        <tr>
                                            <th>No</th>
                                            <th>Train</th>
                                            <th>Destinations</th>
                                            <th>Departure Day</th>
                                            <th>Modification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no= 0;
                                        while ($s = $schedules->fetch_assoc()): 
                                        $no++;
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $no; ?></th>
                                                <td><?php echo $s['train_code']; ?></td>
                                                <td><?php echo $s['destination_name']; ?></td>
                                                <td><?php echo $s['departure_day']; ?></td>
                                                <td>
                                                <a href="?delete=<?php echo $s['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" class="btn btn-danger">Hapus</a>
                                                </td>
                                            </tr>
                                    <?php endwhile; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                  
          </div>

<?php
include '../templates/footer.php';