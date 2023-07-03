<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:reservation.php');
} else {
    $sql = "SELECT b.*, c.fullName, a.* FROM bookings b 
            JOIN customers c ON b.customerId = c.id
            JOIN activity a ON b.activityId = a.activityId";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    $bookings = array();
    foreach ($results as $result) {
           // Extract the time start and duration from the time slot
        $timeStart = $result['timeSlot'];
        $duration = $result['duration'];
        $title = $result['timeSlot'] . "\n" . $result['fullName'] . "\n" . $result['activityName'];

        // Modify the date format to yyyy-mm-dd
        $start = date('Y-m-d', strtotime($result['bookDate'])); // Use 'Y' instead of 'yy'

        
        $booking = array(
            'title' => $title,
            'start' => $start,
            'url' => 'booking-details.php?bookingId=' . $result['bookingId']
        );

        $bookings[] = $booking;
    }
    $bookingsJson = json_encode($bookings);
    ?>

    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Kalendar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script
            type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery-2.1.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/table-style.css" />
        <link rel="stylesheet" type="text/css" href="css/basictable.css" />


        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
            type='text/css' />
        <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />



        <!-- Include necessary CSS and JavaScript files for FullCalendar -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <style>
            /* Customize the calendar layout as needed */
            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <div class="page-container">
            <div class="left-content">
                <div class="mother-grid-inner">
                    <?php include('includes/header.php'); ?>
                    <div class="clearfix"> </div>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Utama</a><i class="fa fa-angle-right"></i>Tempahan
                    </li>
                </ol>
                <div class="agile-grids">
                    <div class="agile-tables">
                        <div class="w3l-table-info">
                            <h2>Kalendar Tempahan</h2>
                            <div id='calendar'></div>

                            <script>
                                $(document).ready(function () {
                                    $('#calendar').fullCalendar({
                                        events: <?php echo $bookingsJson; ?>,
                                        // Customize the calendar options as per your requirements
                                        // For example:
                                        header: {
                                            left: 'prev,next today',
                                            center: 'title',
                                            right: 'month,agendaWeek,agendaDay'
                                        },
                                        defaultView: 'month',
                                        // Add more options as needed
                                    });
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