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

// Fungsi Hapus User
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('User berhasil dihapus');</script>";
        echo "<script>window.location.href = 'manage_user.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus user');</script>";
    }
}

// Ambil data user dengan role customer
$sql = "SELECT id, username, full_nm FROM users WHERE role = 'user'";
$result = $conn->query($sql);

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
                            <th>ID Cust</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Modification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                            <?php 
                                $no = 0;
                                while ($user = $result->fetch_assoc()):
                                $no++;
                            ?>
                                <tr>
                                    <th scope="row"><?= $no; ?></th>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['full_nm']; ?></td>
                                <td>
                                    <a href="manage_user.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">Hapus</a>
                                </td>
                            </tr>
                                <?php endwhile; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada user yang memesan tiket.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                  
          </div>

<?php
include '../templates/footer.php';