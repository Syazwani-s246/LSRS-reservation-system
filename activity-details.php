<?php
session_start();
include('includes/config.php');

if (isset($_POST['submit2'])) {
    $activityId = intval($_GET['actId']);
    $userEmail = $_SESSION['login'];

    // Get user's full name from customers table
    $sql = "SELECT fullName FROM customers WHERE emailId = :userEmail";

    $query = $dbh->prepare($sql);
    $query->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (isset($result['fullName'])) {
        $bookingName = $result['fullName'];
    } else {
        $bookingName = ''; // Set default value if fullName doesn't exist
    }

    $noOfParticipant = $_POST['noOfParticipant'];
    $bookDate = $_POST['bookDate'];
    $timeSlotId = $_POST['timeSlot'];
    $comment = $_POST['comment'];

    $status = 0;

    
    $sql = "INSERT INTO bookings (activityId, customerId,noOfParticipant, timeSlot, bookDate, comment)
        VALUES (:activityId, :customerId, :noOfParticipant, :timeSlot :bookDate, :comment)";


    $query = $dbh->prepare($sql);
    $query->bindParam(':activityId', $activityId, PDO::PARAM_STR);
    $query->bindParam(':customerId', $userEmail, PDO::PARAM_STR);  $query->bindParam(':timeSlotId', $timeSlotId, PDO::PARAM_INT);
    $query->bindParam(':noOfParticipant', $noOfParticipant, PDO::PARAM_INT);
    $query->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
  
    $query->bindParam(':bookDate', $bookDate, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $msg = "Booked Successfully";
    } else {
        $error = "Something went wrong. Please try again";
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
    <script>
        new WOW().init();
    </script>
    <script src="js/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $("#datepicker").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function (date) {
                    var currentDate = new Date();
                    if (date < currentDate) {
                        return [false, 'ui-datepicker-past'];
                    }
                    else {
                        return [true, ''];
                    }
                }
            });
            $(".time-slot").click(function () {
                event.preventDefault();
                $(".time-slot").removeClass("selected");
                $(this).addClass("selected");
                $("#time").val($(this).data("time"));
            });
        });


    </script>
    <style>
        .ui-datepicker-past {
            color: gray;
        }

        .time-slot.selected {
            background-color: blue;
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
    </style>
</head>

<body>
    <!-- top-header -->
    <?php include('includes/header.php'); ?>
    <div class="banner-3">
        <div class="container">
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s"
                style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> Maklumat Aktiviti</h1>
        </div>
    </div>
    <!--- /banner ---->
    <!--- selectactivity ---->
    <div class="selectactivity">
        <div class="container">
            <?php if ($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>:
                    <?php echo htmlentities($error); ?>
                </div>
            <?php } else if ($msg) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>:
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
                    <form name="book" method="post">
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
                                <p><b>Harga</b>
                                    <?php echo htmlentities($result->activityPrice); ?>
                                </p>
                                <h3>Info</h3>
                                <p style="padding-top: 1%">
                                    <?php echo htmlentities($result->activityDetails); ?>
                                </p>
                                <div class="ban-bottom">
                                    <div class="bnr-right">
                                        <label class="inputLabel">Nama pelanggan</label>
                                        <input type="text" id="bookingName" name="bookingName"
                                            value="<?php echo $bookingName; ?>" readonly>
                                        <br>
                                        <label class="inputLabel">Bilangan semua peserta</label>
                                        <input type="number" id="noOfParticipant" name="noOfParticipant"
                                            min="<?php echo $minPax; ?>" required>
                                        <br>
                                        <label for="date">Tarikh:</label>
                                        <input type="text" id="datepicker" name="bookDate" placeholder="dd-mm-yyyy" required>
                                        <br>
                                        <label for="time">Slot masa:</label>
                                        <input type="hidden" id="timeSlot" name="timeSlot"
                                            value="<?php echo $activityTimeId; ?>">
                                        <input type="text" value="<?php echo $timeSlotName; ?>" readonly>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="grand">
                                    <p>Jumlah deposit</p>
                                    <h3>...</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="selectactivity_top">
                            <div class="selectactivity-info animated wow fadeInUp animated" data-wow-duration="1200ms"
                                data-wow-delay="500ms"
                                style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
                                <ul>
                                    <li class="spe">
                                        <label class="inputLabel">Komen</label>
                                        <input class="special" type="text" name="comment">
                                    </li>
                                    <?php if ($_SESSION['login']) { ?>
                                        <li class="spe" align="center">
                                            <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                        </li>
                                    <?php } else { ?>
                                        <li class="sigi" align="center" style="margin-top: 1%">
                                            <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">
                                                Tempah</a>
                                        </li>
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
    <!-- write us -->
    <?php include('includes/write-us.php'); ?>
</body>

</html>