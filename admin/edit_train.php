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
if (isset($_GET['id'])) {
    $train_id = intval($_GET['id']);

    // Ambil data kereta untuk di edit
    $stmt = $conn->prepare("SELECT * FROM trains WHERE id=?");
    $stmt->bind_param("i", $train_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $train = $result->fetch_assoc();
    } else {
        die("Kereta tidak ditemukan.");
    }
}

if (isset($_POST['update_train'])) {
    $code = strip_tags(trim($_POST['code']));
    $price_per_seat = floatval($_POST['price_per_seat']);
    $available_seats = intval($_POST['available_seats']);

    // Update data kereta
    $stmt = $conn->prepare("UPDATE trains SET code=?, price_per_seat=?, available_seats=? WHERE id=?");
    $stmt->bind_param("sdsi", $code, $price_per_seat, $available_seats, $train_id);

    if ($stmt->execute()) {
        $success_message = "Kereta berhasil diperbarui!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("location: daf_kereta.php");

}

?>

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body"><br><br><br>
                    <h2 class="card-title">Edit Train Form</h2>
                    <form method="POST" action="">
                                <div class="form-group" style="margin-top: 4rem;">
                                    <label>Trains Code</label>
                                    <input type="text" name="code" class="form-control" value="<?php echo $train['code']; ?>" required>
                                </div></br>
                                <div class="form-group">
                                    <label>Seating Capacity</label>
                                    <input type="number" name="available_seats" class="form-control" value="<?php echo $train['available_seats'] ?>" required>
                                </div></br>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price_per_seat" class="form-control" value="<?php echo $train['price_per_seat'] ?>" required>
                                </div></br>
                                <button type="submit" name="update_train" class="btn btn-primary">Update</button>
                            </form>
                  </div>
                </div>
              </div>


<?php
include '../templates/footer.php';