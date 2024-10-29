<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query untuk memeriksa user
    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    // Cek jika hasil query ditemukan
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Arahkan berdasarkan peran user
        if ($user['role'] === 'admin') {
            header("Location:dashboard_admin.php");
        } else {
            header("Location:user_dashboard.php");
        }
        exit();
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-primary"><h3 class="text-center font-weight-dark my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username" placeholder="Input Username" required>
                                            </div></br>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Input Password" required>
                                            </div></br>
                                            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3 bg-primary">
                                        <div class="small"><a href="register.php"style="color:#fff;">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html> 