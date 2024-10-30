<?php
session_start();
include "../config/koneksi.php"; // Koneksi ke database

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Mengambil data jadwal keberangkatan
$schedules = $conn->query("SELECT schedules.id, trains.code AS train_code, destinations.destination_name, schedules.departure_day 
                            FROM schedules 
                            JOIN trains ON schedules.train_id = trains.id 
                            JOIN destinations ON schedules.destination_id = destinations.id 
                            ORDER BY schedules.departure_day ASC");
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sedna - A Free HTML5/CSS3 website</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" href="css/flexslider.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/queries.css">
    <link rel="stylesheet" href="css/etline-font.css">
    <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body id="top">
    <section class="hero">
        <section class="navigation">
            <header>
                <div class="header-content">
                    <div class="logo"><a href="#"><img src="img/logo3.png" alt="Sedna logo"></a></div>
                    <div class="header-nav">
                        <nav>
                            <ul class="primary-nav">
                                <li><a href="view_schedule.php">Schedule</a></li>
                                <li><a href="view_trains.php">Trains Available</a></li>
                                <li><a href="view_destinations.php">Destination List</a></li>
                                <li><a href="booking.php">Booking</a></li>
                                <li><a href="view_orders.php">Transaction</a></li>
                            </ul>
                            <ul class="member-actions">
                                <li><a href="../logout.php" class="btn-white btn-small">Log Out</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="navicon">
                        <a class="nav-toggle" href="#"><span></span></a>
                    </div>
                </div>
            </header>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="hero-content text-center">
                        
                <div class="main-content" style="
    padding: 10px;
">
                    <h2 class="text-center mb-4" style="color: white;">Schedule</h2>
                    <table class="table table-hover" style="border-radius: 15px;color: white; text-align: left;">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Train Code</th>
                                <th>Destination</th>
                                <th>Departure Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 0;
                            while ($schedule = $schedules->fetch_assoc()):
                            $no++;
                            ?>
                                <tr>
                                    <th scope="row"><?= $no; ?></th>
                                    <td><?php echo $schedule['train_code']; ?></td>
                                    <td><?php echo $schedule['destination_name']; ?></td>
                                    <td><?php echo $schedule['departure_day']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <a href="../user_dashboard.php" class="btn btn-secondary">Back</a>
                </div>


                    </div>
                </div>
            </div>
        </div>
        
    </section>
    
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="footer-links">
                        <ul class="footer-group">
                            
                        </ul>
                        <p>Copyright © 2025 <a href="#">BtnCorps</a><br>
                        <a href="http://tympanus.net/codrops/licensing/">Licence</a> | Crafted with <span class="fa fa-heart pulse2"></span> for <a href="https://tympanus.net/codrops/">Codrops</a>.</p>
                    </div>
                </div>
                <div class="social-share">
                    <p>Follow for more</p>
                    <a href="#" class="twitter-share"><i class="fa fa-twitter"></i></a> <a href="#" class="facebook-share"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="bower_components/retina.js/dist/retina.js"></script>
    <script src="js/jquery.fancybox.pack.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="bower_components/classie/classie.js"></script>
    <script src="bower_components/jquery-waypoints/lib/jquery.waypoints.min.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
</body>
</html>