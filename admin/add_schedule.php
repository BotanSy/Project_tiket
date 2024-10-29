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
if (isset($_POST['add_schedule'])) {
    $train_id = $_POST['train_id'];
    $destination_id = $_POST['destination_id'];
   // Memastikan format tanggal valid
   $departure_day = $_POST['departure_day'];
    
   // Cek apakah tanggal valid
   if (DateTime::createFromFormat('Y-m-d', $departure_day) !== false) {
       // Menyiapkan query
       $sql = "INSERT INTO schedules (train_id, destination_id, departure_day) VALUES ($train_id, $destination_id, '$departure_day')";
       
       if ($conn->query($sql) === TRUE) {
           echo "Jadwal keberangkatan berhasil ditambahkan.";
       } else {
           echo "Gagal menambahkan jadwal keberangkatan: " . $conn->error;
       }
   } else {
       echo "Format tanggal tidak valid.";
   }
    
    header("location:schedules.php");
    exit();
}

$trains = $conn->query("SELECT * FROM trains");
$destinations = $conn->query("SELECT * FROM destinations");
$schedules = $conn->query("SELECT schedules.*, trains.code AS train_code, destinations.destination_name AS destination_name 
    FROM schedules 
    JOIN trains ON schedules.train_id = trains.id 
    JOIN destinations ON schedules.destination_id = destinations.id");

?>

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body"><br><br><br>
                    <h2 class="card-title">Add Destinations Form</h2>
                    <form method="post">
                        <!-- Pilih Kereta -->
                        <div class="mb-3">
                            <label for="train_id" class="form-label">Select Train   :</label>
                            <select name="train_id" class="form-control" style="width:100%" required>
                                <option value="">...</option>
                                <?php while ($train = $trains->fetch_assoc()): ?>
                                    <option value="<?php echo $train['id']; ?>"><?php echo $train['code']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Pilih Tujuan -->
                        <div class="mb-3">
                            <label for="destination_id" class="form-label">Select Destinations  :</label>
                            <select name="destination_id" class="form-control" style="width:100%" required>
                                <option value="">...</option>
                                <?php while ($destination = $destinations->fetch_assoc()): ?>
                                    <option value="<?php echo $destination['id']; ?>"><?php echo $destination['destination_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Hari Keberangkatan -->
                        <div class="mb-3">
                            <label for="departure_day" class="form-label">Departure Day    :</label>
                            <input type="date" name="departure_day" class="form-control" required>
                        </div>

                        <!-- Tombol Tambah Jadwal -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="add_schedule" class="btn btn-primary">Add Schedule</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
<?php
include '../templates/footer.php';