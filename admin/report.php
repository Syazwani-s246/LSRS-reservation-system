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
        <title>Laporan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="application/x-javascript">
                    addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false);
                    function hideURLbar() { window.scrollTo(0, 1); }
                </script>
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

        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/table-style.css" />
        <link rel="stylesheet" type="text/css" href="css/basictable.css" />
        <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#table').basictable();

                $('#table-breakpoint').basictable({
                    breakpoint: 768
                });

                $('#table-swap-axis').basictable({
                    swapAxis: true
                });

                $('#table-force-off').basictable({
                    forceResponsive: false
                });

                $('#table-no-resize').basictable({
                    noResize: true
                });

                $('#table-two-axis').basictable();

                $('#table-max-height').basictable({
                    tableWrapper: true
                });
            });
        </script>

        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
            type='text/css' />
        <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
        <style>
            .charts-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .chart-container {
                flex: 0 0 48%;
                margin-bottom: 20px;
                height: 400px;
            }

            .hide {
                display: none;
            }

            @media (max-width: 768px) {
                .chart-container {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>

        <body>
            <div class="page-container">
                <!--/content-inner-->
                <div class="left-content">
                    <div class="mother-grid-inner">
                        <!--header start here-->
                        <?php include('includes/header.php'); ?>
                        <div class="clearfix"> </div>
                    </div>
                    <!--header end here-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Utama</a><i
                                class="fa fa-angle-right"></i>Laporan
                            <i class="fa fa-angle-right"></i> <button type="button" id="print-button"
                                class="btn btn-primary btn-sm rounded-0"
                                onclick="this.style.display='none';document.body.offsetHeight;window.print();this.style.display='inline';">Cetak</button>
                        </li>
                    </ol>
                    <div class="agile-grids">
                        <!-- tables -->

                        <div class="agile-tables">
                            <div class="w3l-table-info">

                                <div class="charts-container">
                                    <div class="chart-container">
                                        <h3>Status Tempahan</h3>
                                        <canvas id="booking-status-chart"></canvas>
                                    </div>
                                    <div class="chart-container">
                                        <h3>Jumlah tempahan</h3>
                                        <canvas id="monthly-booking-chart"></canvas>
                                    </div>
                                </div>
                            </div>


                            <!-- List of customers who haven't paid table -->
                            <div id="not-paid-table" class="table-responsive" hidden>
                                <table id="basic-table" class="table">
                                    <div class="w3l-table-info">
                                        <h2>Bayaran yang diterima</h2>
                                        <table id="table">
                                            <thead>
                                                <tr>
                                                    <th>ID Tempahan</th>
                                                    <th>Nama penuh</th>
                                                    <!-- <th>Mobile No.</th> -->
                                                    <th>Nombor telefon</th>
                                                    <th>Amaun yang dibayar (RM) </th>
                                                    <!-- <th>RegDate </th> -->
                                                    <th>Slip pembayaran</th>

                                                    <!-- <th>Tindakan </th> -->

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT b.bookingId, d.amountPaid, c.fullName, c.mobileNumber, d.paymentReceipt
                                  FROM bookings b
                                  JOIN customers c ON b.customerId = c.id
                                  LEFT JOIN payments d ON b.paymentId = d.paymentId
                                  WHERE b.paymentId IS NULL";


                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {

                                                        ?>
                                                        <tr>
                                                            <td><a
                                                                    href="booking-details.php?bookingId=<?php echo htmlentities($result->bookingId); ?>">#BK-<?php echo htmlentities($result->bookingId); ?></a></td>
                                                            <td>
                                                                <?php echo htmlentities($result->fullName); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlentities($result->mobileNumber); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlentities($result->totalPayment); ?>
                                                            </td>




                                                        </tr>

                                                        <?php $cnt++;
                                                    }
                                                } else { ?>
                                                <tr>
                                                    <td colspan="9">Tiada tempahan yang dijumpai.</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </table>



                            </div>
        </body>

        <script>

            $(document).ready(function () {
                var navoffeset = $(".header-main").offset().top;
                $(window).scroll(function () {
                    var scrollpos = $(window).scrollTop();
                    if (scrollpos >= navoffeset) {
                        $(".header-main").addClass("fixed");
                    } else {
                        $(".header-main").removeClass("fixed");
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                // Create the pie chart for booking status
                new Chart(document.getElementById('booking-status-chart'), {
                    type: 'pie',
                    data: {
                        labels: ['Telah Dibayar', 'Belum Dibayar'],
                        datasets: [{
                            data: [<?php echo $paidCount; ?>, <?php echo $notPaidCount; ?>],
                            backgroundColor: ['green', 'red']
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Status Tempahan'
                        }
                    }
                });

                // Create the bar chart for monthly bookings
new Chart(document.getElementById('monthly-booking-chart'), {
    type: 'bar',
    data: {
        labels: [
            <?php foreach ($monthlyBookingData as $data) {
                echo "'" . $data['label'] . "', ";
            } ?>
        ],
        datasets: [{
            label: 'Bilangan Tempahan',
            data: [
                <?php foreach ($monthlyBookingData as $data) {
                    echo $data['value'] . ", ";
                } ?>
            ],
            backgroundColor: 'blue',
            borderColor: 'blue',
            borderWidth: 1
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Bilangan Tempahan Bulanan'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    precision: 0 // Set the precision to 0 to display whole numbers on the y-axis
                }
            }]
        }
    }
});



                // Get the chart segment for "Belum Dibayar"
                var notPaidSegment = bookingStatusChart.getDatasetMeta(0).data[1];

                // Add click event listener to the segment
                notPaidSegment._model.id = "not-paid-segment"; // Give ID to the segment
                document.getElementById('not-paid-segment').addEventListener('click', function () {
                    var notPaidTable = document.getElementById('not-paid-table');
                    notPaidTable.hidden = !notPaidTable.hidden;

                });

            });

            // Hide the sidebar when printing
            window.onbeforeprint = function () {
                document.querySelector('.sidebar').style.display = 'none';
            };

            // Show the sidebar after printing
            window.onafterprint = function () {
                document.querySelector('.sidebar').style.display = 'block';
            };
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