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

$trains = $conn->query("SELECT * FROM trains");

?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title">Train List</h2>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Train Code</th>
                            <th>Available Seats</th>
                            <th>Price / Seat</th>
                            <th>Modification</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                                        $no= 0;
                                        while ($train = $trains->fetch_assoc()): 
                                        $no++;
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $no; ?></th>
                                                <td><?php echo $train['code']; ?></td>
                                                <td><?php echo $train['available_seats']; ?></td>
                                                <td><?php echo $train['price_per_seat']; ?></td>
                                                <td>
                                                    <a href="edit_train.php?id=<?php echo $train['id']; ?>" class="btn btn-success" style=" margin-right: .4rem;">Edit</a>
                                                    <form action="del_train.php" method="post" style=" display: inline; ">
                                                        <input type="hidden" name="delete" value=<?php echo $train['id']; ?>>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete This?');">Delete</button>
                                                    </form>
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