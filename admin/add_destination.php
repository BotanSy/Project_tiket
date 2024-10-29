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

if (isset($_POST['add_destination'])) {
    $destination_name = $_POST['destination_name'];
    $sql = "INSERT INTO destinations (destination_name) VALUES ('$destination_name')";
    $conn->query($sql);
    
    header("location:daf_destination.php");
    exit();
}
    

?>

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body"><br><br><br>
                    <h2 class="card-title">Add Destinations Form</h2>
                    <form method="POST" action="">
                            <div class="form-group" style="margin-top: 4rem;">
                                <label>Destinatons :</label>
                                <input type="text" name="destination_name" class="form-control" placeholder="Input Destinations Name" required>
                              </div></br>
                             <button type="submit" name="add_destination" class="btn btn-primary">Submit</button>
                        </form>
                  </div>
                </div>
              </div>
<?php
include '../templates/footer.php';