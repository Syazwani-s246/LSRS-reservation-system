<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_GET['actId'])) {
    $activityId = intval($_GET['actId']);
    $userEmail = $_SESSION['login'];
    $sql = "SELECT id,fullName FROM customers WHERE emailId = :userEmail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    // $result['fullName'] dapatkan column 'fullName' guna cara array
    if (isset($result['fullName'])) {
        $bookingName = $result['fullName'];
    } else {
        $bookingName = ''; // Set default value if fullName doesn't exist
    }

    if (isset($result['id'])) {
        $customerId = $result['id'];
    } else {
        $customerId = ''; // Set default value if fullName doesn't exist
    }

    $sql = "SELECT minPax, duration,activityPrice FROM activity WHERE activityId = :activityId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
    $query->execute();
    $activityResult = $query->fetch(PDO::FETCH_ASSOC);
    // var_dump($activityResult); //to test minPax,duration and activityPrice
    if (isset($activityResult['minPax'])) {
        $minPax = $activityResult['minPax'];
    } else {
        $minPax = 1; // Set default value if minPax doesn't exist
    }

    if (isset($activityResult['duration'])) {
        $duration = $activityResult['duration'];
    } else {
        $duration = 1; // Set default value if duration doesn't exist
    }
}

if (isset($_POST['submit2'])) {
    // Retrieve activityId, customerId, and other form data
    $activityId = intval($_POST['actId']);
    $customerId = $_POST['customerId'];
    $userEmail = $_SESSION['login'];
    $bookDate = $_POST['bookDate'];
    $comment = $_POST['comment'];
    $timeSlot = $_POST['selectedTimeSlot'];
    $activityPrice = $_POST['activityPrice'];

    //instead of minPax, get noOfParticipant, the name=" " indicate what you retrieve from
    $noOfParticipant = $_POST['noOfParticipant'];

    // Calculate total payment
    $activityPrice = $activityResult['activityPrice'];
    $totalPayment = $noOfParticipant * $activityPrice;






    $status = 0;

    // Fetch already booked time slots for the selected date
    $sql = "SELECT timeSlot FROM bookings WHERE bookDate = :bookDate";
    $query = $dbh->prepare($sql);
    //$query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
    $query->bindParam(':bookDate', $bookDate, PDO::PARAM_STR);
    $query->execute();
    $bookedTimeSlots = $query->fetchAll(PDO::FETCH_COLUMN);



    // Check if the selected timeslot and date combination already exists
    $sql = "SELECT COUNT(*) AS count FROM bookings WHERE activityId = :activityId AND timeSlot = :timeSlot AND bookDate = :bookDate";
    $query = $dbh->prepare($sql);
    $query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
    $query->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
    $query->bindParam(':bookDate', $bookDate, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo "<script>alert('Tarikh ATAU slot masa tidak tersedia. Sila pilih masa ATAU tarikh lain.');</script>";
    } else {
        // Store booking details in session
        $_SESSION['bookingDetails'] = array(
            'activityId' => $activityId,
            'customerId' => $customerId,
            'noOfParticipant' => $noOfParticipant,
            'timeSlot' => $timeSlot,
            'bookDate' => $bookDate,
            'comment' => $comment,
            'activityPrice' => $activityPrice,
            'totalPayment' => $noOfParticipant * $activityPrice,

        );

        // get value for this id to bring id to booking_confirmation
        $_SESSION['activityId'] = $activityId;
        $_SESSION['customerId'] = $customerId;

        // Redirect to booking confirmation page
        header("Location: booking_confirmation.php");
        exit();
    }
}


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Maklumat Aktiviti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="applijewelleryion/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
         function hideURLbar(){ window.scrollTo(0,1); } 
      </script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Custom Theme files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="js/jquery-1.12.0.min.js"></script> -->
    <script src="js/bootstrap.min.js"></script>
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery-ui.js"></script>
    <script>
        new WOW().init();

        var duration = <?php echo $duration; ?>;


        $(document).ready(function () {

            $("#datepicker").datepicker({
                minDate: 0,
                dateFormat: 'dd-mm-yy',
                beforeShowDay: function (date) {
                    var currentDate = new Date();
                    if (date < currentDate) {
                        return [false, 'ui-datepicker-past'];
                    } else {
                        return [true, ''];
                    }
                },


                onSelect: function (dateText, inst) {
                    var selectedDate = new Date(dateText);
                    var selectedDateString = dateText;
                    var bookedTimeSlots = <?php echo json_encode($bookedTimeSlots); ?>;
                    var timeSlots = generateTimeSlots(duration, selectedDate, bookedTimeSlots);

                    // Clear previous buttons and add new time slots as buttons
                    var timeSlotsContainer = $('#timeSlotsContainer');
                    timeSlotsContainer.empty();
                    timeSlots.forEach(function (timeSlot, index) {
                        var radioOption = $(`
                    <div>
                    <input type='radio' id='timeslot-${index}' name='selectedTimeSlot' value='${timeSlot}'>
                    <label for='timeslot-${index}'>${timeSlot}</label>
                    </div>
                `);
                        timeSlotsContainer.append(radioOption);
                    });
                }
            });

            // initial render of time slots
            var timeSlots = generateTimeSlots(duration);
            // Clear previous buttons and add new time slots as buttons
            var timeSlotsContainer = $('#timeSlotsContainer');
            timeSlotsContainer.empty();
            timeSlots.forEach(function (timeSlot, index) {
                var radioOption = $(`
                    <div>
                    <input type='radio' id='timeslot-${index}' name='selectedTimeSlot' value='${timeSlot}'>
                    <label for='timeslot-${index}'>${timeSlot}</label>
                    </div>
                `);
                timeSlotsContainer.append(radioOption);
            });




            // Function to generate time slots
            function generateTimeSlots(duration) {
                var startTime = new Date();
                startTime.setHours(9, 0, 0); // Set the starting time (e.g., 9:00 AM)

                var endTime = new Date();
                endTime.setHours(18, 0, 0); // Set the ending time (e.g., 6:00 PM)

                var timeSlots = [];
                var currentTime = startTime;

                while (currentTime <= endTime) {
                    var timeSlot = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    timeSlots.push(timeSlot);
                    // Add the interval to the current time
                    currentTime.setHours(currentTime.getHours() + duration);
                }
                return timeSlots;
            }

            // Disable booked time slots for the selected date
            var bookedTimeSlots = <?php echo json_encode($bookedTimeSlots); ?>;
            bookedTimeSlots.forEach(function (bookedTimeSlot) {
                $('input[value="' + bookedTimeSlot + '"]').prop('disabled', true).parent().addClass('fully-booked-time');
            });




        });
    </script>



    <style>
        .ui-datepicker-past {
            color: gray;
        }


        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .fully-booked-time {
            background-color: lightgray;
            /* Set the background color for disabled time slots */
            cursor: not-allowed;
            /* Change the cursor to indicate that the time slots are not selectable */
            opacity: 0.5;
            /* Adjust the opacity to visually indicate that the time slots are disabled */
            pointer-events: none;
            /* Disable pointer events on the disabled time slots */
        }


        .selected-time-slot {
            background-color: grey;
        }

        .fully-booked-date {
            background-color: lightgrey;
        }
    </style>

    </style>

    <script>
        function validateForm() {
            var selectedTimeSlot = $('input[name="selectedTimeSlot"]:checked').val();
            if (!selectedTimeSlot) {
                alert("Sila pilih slot masa.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>

</head>

<body>
    <!-- top-header -->
    <?php include('includes/header.php'); ?>
    <h1>
        <center>Maklumat Aktiviti</center>
    </h1>

    <!--- selected-activity ---->
    <div class="selectactivity">
        <div class="container">
            <?php if ($error) { ?>
                <div class="errorWrap"><strong>RALAT</strong>:
                    <?php echo htmlentities($error); ?>
                </div>
            <?php } else if ($msg) { ?>
                    <div class="succWrap"><strong>BERJAYA</strong>:
                    <?php echo htmlentities($msg); ?>
                    </div>
                <?php } ?>
            <?php
            $activityId = intval($_GET['actId']);
            $sql = "SELECT * from activity where activityId=:activityId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':activityId', $activityId, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <form name="book" method="post" onsubmit="return validateForm()">
                        <div class="selectactivity_top">
                            <div class="col-md-4 selectactivity_left wow fadeInLeft animated" data-wow-delay=".5s">
                                <img src="admin/activityImage/<?php echo htmlentities($result->activityImage); ?>"
                                    class="img-responsive" alt="">
                            </div>
                            <div class="col-md-8 selectactivity_right wow fadeInRight animated" data-wow-delay=".5s">
                                <h2>
                                    <?php echo htmlentities($result->activityName); ?>
                                </h2>
                                <p class="dow">#A-
                                    <?php echo htmlentities($result->activityId); ?>
                                </p>
                                <p><b>Harga</b> :
                                    RM
                                    <?php echo htmlentities($result->activityPrice); ?>
                                </p>
                                <p><b>Tempoh masa aktiviti</b> :

                                    <?php echo htmlentities($result->duration); ?> jam
                                </p>
                                <p><b>Info</b></p>
                                <p style="padding-top: 1%">
                                    <?php echo htmlentities($result->activityDetails); ?>
                                </p>
                                <div class="ban-bottom">
                                    <div class="bnr-right">
                                        <input type="hidden" name="actId" value="<?php echo $activityId; ?>">
                                        <input type="hidden" name="customerId" value="<?php echo $customerId; ?>">
                                        <label class="inputLabel">Nama pelanggan</label>
                                        <input type="text" id="bookingName" name="bookingName"
                                            value="<?php echo $bookingName; ?>" readonly>
                                        <br>
                                        <label class="inputLabel">Bilangan semua peserta</label>
                                        <input type="number" id="noOfParticipant" name="noOfParticipant"
                                            min="<?php echo $minPax; ?>" value="<?php echo $minPax; ?>" required>
                                        <br>
                                        <label for="date">Tarikh:</label>
                                        <input type="text" id="datepicker" name="bookDate" placeholder="dd-mm-yyyy" required>
                                        <br>


                                        <div class="form-group">
                                            <label>Pilih slot masa<span style="color:red;">*</span></label>
                                            <div id="timeSlotsContainer"></div>
                                        </div>




                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <!-- <div class="grand">
                                    <p>Jumlah deposit</p>
                                    <h3>...</h3>
                                </div> -->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="selectactivity_top">
                            <div class="selectactivity-info animated wow fadeInUp animated" data-wow-duration="1200ms"
                                data-wow-delay="500ms"
                                style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
                                <ul>

                                    <label class="inputLabel">Catatan (jika ada)</label>
                                    <input type="text" name="comment">

                                    <?php if ($_SESSION['login']) { ?>
                                        <ul class="spe" align="center">
                                            <button type="submit" name="submit2" class="btn-primary btn">Tempah</button>

                                        <?php } else { ?>
                                            <!-- <li class="sigi" align="center" style="margin-top: 1%">
                                            <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">
                                                Tempah</a>
                                        </li> -->
                                        <?php } ?>
                                        <div class="clearfix"></div>
                                    </ul>
                            </div>
                        </div>
                    </form>
                <?php }
            } ?>
        </div>
    </div>

    <!--- /selectactivity ---->
    <!--- /footer-top ---->
    <?php include('includes/footer.php'); ?>
    <!-- signup -->
    <?php include('includes/signup.php'); ?>
    <!-- //signu -->
    <!-- signin -->
    <?php include('includes/signin.php'); ?>
    <!-- //signin -->

</body>

</html>