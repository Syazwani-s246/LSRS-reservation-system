<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:reservation.php');
} else {
    $paidCount = 0;
    $notPaidCount = 0;

    $sql = "SELECT COUNT(*) AS count, status FROM bookings GROUP BY status";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        if ($result['status'] == 1) {
            $paidCount = $result['count'];
        } elseif ($result['status'] == 0) {
            $notPaidCount = $result['count'];
        }
    }

    $monthlyBookingData = array();
    $yearlyBookingData = array();

    $sql = "SELECT COUNT(*) AS count, MONTH(bookDate) AS month, YEAR(bookDate) AS year FROM bookings GROUP BY YEAR(bookDate), MONTH(bookDate)";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        $monthlyBookingData[] = array(
            "label" => date("M", mktime(0, 0, 0, $result['month'], 10)),
            "value" => $result['count']
        );
        $yearlyBookingData[] = array(
            "label" => strval($result['year']),
            "value" => $result['count']
        );
    }

    ?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>LSRS | Laporan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/icon-font.min.css" />
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet">
		<script src="js/jquery-2.1.4.min.js"></script>


    </head>

    <body>
        <div class="page-container">
            <div class="left-content">
                <div class="mother-grid-inner">
                    <?php include('includes/header.php'); ?>
                    <div class="clearfix"> </div>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Utama</a><i class="fa fa-angle-right"></i>Laporan</li>
                </ol>
                <div class="agile-grids">
                    <div class="agile-tables">
                        <div class="w3l-table-info">
                            <h2>Laporan</h2>
                            <div style="width: 50%">
                                <canvas id="booking-status-chart"></canvas>
                            </div>
                            <div style="width: 100%">
                                <canvas id="monthly-booking-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>
            </div>
            <?php include('includes/sidebar.php'); ?>
            <div class="clearfix"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Create the pie chart for booking status
                new Chart(document.getElementById('booking-status-chart'), {
                    type: 'pie',
                    data: {
                        labels: ['Paid', 'Not Paid'],
                        datasets: [{
                            data: [<?php echo $paidCount; ?>, <?php echo $notPaidCount; ?>],
                            backgroundColor: ['green', 'red']
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Booking Status - Paid vs Not Paid'
                        }
                    }
                });

                // Create the bar chart for monthly and yearly bookings
                new Chart(document.getElementById('monthly-booking-chart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php foreach ($monthlyBookingData as $data) {
                                echo "'" . $data['label'] . "', ";
                            } ?>
                        ],
                        datasets: [{
                            label: 'Monthly',
                            data: [
                                <?php foreach ($monthlyBookingData as $data) {
                                    echo $data['value'] . ", ";
                                } ?>
                            ],
                            backgroundColor: 'blue',
                            borderColor: 'blue',
                            borderWidth: 1
                        }, {
                            label: 'Yearly',
                            data: [
                                <?php foreach ($yearlyBookingData as $data) {
                                    echo $data['value'] . ", ";
                                } ?>
                            ],
                            backgroundColor: 'orange',
                            borderColor: 'orange',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Monthly and Yearly Bookings'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
        </script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>

    <!-- script-for sticky-nav -->
    <script>						$(document).ready(function () {
							var navoffeset = $(".header-main").offset().top; $(window).scroll(function () { var scrollpos = $(window).scrollTop(); if (scrollpos >= navoffeset) { $(".header-main").addClass("fixed"); } else { $(".header-main").removeClass("fixed"); } });
						});
					</script>
					<!-- /script-for sticky-nav -->
					<!--inner block start here-->
					<div class="inner-block">

					</div>
					<!--inner block end here-->
					<!--copy rights start here-->
					<?php include('includes/footer.php'); ?>
					<!--COPY rights end here-->
				</div>
			</div>
			<!--//content-inner-->
			<!--/sidebar-menu-->
			<?php include('includes/sidebarmenu.php'); ?>
			<div class="clearfix"></div>
		</div>
		<script>			var toggle = true;
			$(".sidebar-icon").click(function () {
				if (toggle) { $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back"); $("#menu span").css({ "position": "absolute" }); } else { $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back"); setTimeout(function () { $("#menu span").css({ "position": "relative" }); }, 400); }
				toggle = !toggle;
			});
		</script>
		<!--js -->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- /Bootstrap Core JavaScript -->

	</body>

	</html>
<?php } ?>
    </html>

