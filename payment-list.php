<!-- customer can view amount paid, past receipt and the timestamp they upload the receipt -->
<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location: reservation.php');
    exit();
} else {
    if (isset($_REQUEST['bookingId'])) {

        $userEmail = $_SESSION['login'];
        $bookingId = intval($_GET['bookingId']);

        // SQL query to get the data
        $sql = "SELECT b.*, a.activityName, IF(b.paymentId IS NULL, 0, 1) AS status, b.bookDate
                FROM bookings b
                INNER JOIN customers c ON b.customerId = c.id
                INNER JOIN activity a ON b.activityId = a.activityId
                WHERE c.emailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $userEmail, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
                $bookingId = $result->bookingId;
                $activityName = $result->activityName;
                $noOfParticipant = $result->noOfParticipant;
                $timeSlot = $result->timeSlot;
                $bookDate = $result->bookDate;
                $comment = $result->comment;

                // Print the result to test
                echo "Booking ID: " . $bookingId . "<br>";
                echo "Activity Name: " . $activityName . "<br>";
                echo "Number of Participants: " . $noOfParticipant . "<br>";
                echo "Time Slot: " . $timeSlot . "<br>";
                echo "Booking Date: " . $bookDate . "<br>";
                echo "Comment: " . $comment . "<br>";
            }
        } else {
            // Handle if no results found for the given conditions
            $error = "No bookings found for the given UserEmail";
        }
    }

?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Pembayaran</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Lambo Sari Reservation System" />
		<script
			type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href="css/font-awesome.css" rel="stylesheet">
		<!-- Custom Theme files -->
		<script src="js/jquery-1.12.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!--animate-->
		<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/wow.min.js"></script>
		<script>
			new WOW().init();
		</script>

		<style>
			
		</style>
	</head>

	<body>
		<!-- top-header -->
		<div class="top-header">
			<?php include('includes/header.php'); ?>
		
			<!--- /banner-1 ---->
            <!--- privacy ---->
            <div class="privacy">
                <div class="container">
                    <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s"
                        style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Sejarah tempahan saya</h3>
                    <table border="1" width="100%">
                        <tr align="center">
                            <th>#</th>
                            <th>Id tempahan</th>
                            <th>Nama aktiviti</th>
                            <th>Tarikh</th>
                            <th>Masa</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                        <?php
                        $userEmail = $_SESSION['login'];
                        $sql = "SELECT b.*, a.activityName, IF(b.paymentId IS NULL, 0, 1) AS status, b.bookDate
                                FROM bookings b
                                INNER JOIN customers c ON b.customerId = c.id
                                INNER JOIN activity a ON b.activityId = a.activityId
                                WHERE c.emailId = :EmailId";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':EmailId', $userEmail, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                ?>
                                <tr align="center">
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td>#BK<?php echo htmlentities($result->bookingId); ?></td>
                                    <td><a href="activity-details.php?actId=<?php echo htmlentities($result->activityId); ?>"><?php echo htmlentities($result->activityName); ?></a></td>
                                    <td><?php echo htmlentities($result->bookDate); ?></td>
                                    <td><?php echo htmlentities($result->timeSlot); ?></td>
                                    <td><?php echo htmlentities($result->comment); ?></td>
                                    <td>
                                        <?php
                                       if ($result->status == 0) {
                                        echo '<a href="payment.php?bookingId=' . $result->bookingId . '&activityId=' . $result->activityId . '&customerId=' . $result->customerId . '">Belum Dibayar</a>';
                                    } elseif ($result->status == 1) {
                                        echo "Sudah dibayar";
                                    } elseif ($result->status == 2) {
                                        echo "Selesai";
                                    }
                                    

                                        // Check if bookDate has passed one week
                                        $bookingDate = strtotime($result->bookDate);
                                        $oneWeekAgo = strtotime('-1 week');

                                        if ($result->status == 2 && $bookingDate < $oneWeekAgo) {
                                            ?>
                                            <br>
                                            <a href="rate.php?bookingId=<?php echo $result->bookingId; ?>">RATE</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <!-- Add appropriate actions here -->
                                    </td>
                                </tr>
                                <?php
                                $cnt++;
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <!-- - /privacy -->

					<!-- signup -->
					<?php include('includes/signup.php'); ?>
					<!-- //signu -->
					<!-- signin -->
					<?php include('includes/signin.php'); ?>

	</body>

	</html>
<?php } ?>