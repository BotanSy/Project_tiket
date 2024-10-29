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
    $dest = intval($_GET['id']);

    // Ambil data kereta untuk di edit
    $stmt = $conn->prepare("SELECT * FROM destinations WHERE id=?");
    $stmt->bind_param("i", $dest);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $des = $result->fetch_assoc();
    } else {
        die("Kereta tidak ditemukan.");
    }
}

if (isset($_POST['update_dest'])) {
    $destination_name = strip_tags(trim($_POST['destination_name']));

    // Update data kereta
    $stmt = $conn->prepare("UPDATE destinations SET destination_name=? WHERE id=?");
    $stmt->bind_param("si", $destination_name, $dest);

    if ($stmt->execute()) {
        $success_message = "Kereta berhasil diperbarui!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("location: daf_destination.php");

}

?>

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body"><br><br>
                    <h2 class="card-title">Edit Destinations Form</h2>
                    <form method="POST" action="">
                                <div class="form-group" style="margin-top: 4rem;">
                                    <label>Destination Name</label>
                                    <input type="text" name="destination_name" class="form-control" value="<?php echo $des['destination_name']; ?>" required>
                                </div></br>
                                <button type="submit" name="update_dest" class="btn btn-primary">Update</button>
                            </form>
                  </div>
                </div>
              </div>


<?php
include '../templates/footer.php';