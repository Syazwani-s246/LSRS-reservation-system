<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
	header('location:reservation.php');
	exit();
} else {
	if (isset($_REQUEST['bookingId'])) {
		$bookingId = intval($_GET['bookingId']);
		$email = $_SESSION['login'];

		// SQL query to get the data
		$sql = "SELECT b.bookingId, a.activityName, b.noOfParticipant, b.timeSlot, b.bookDate, b.comment 
				FROM bookings b 
				INNER JOIN activity a ON b.activityId = a.activityId
				WHERE b.UserEmail = :email AND b.bookingId = :bookingId";
		$query = $dbh->prepare($sql);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
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

				// Do something with the retrieved data
				// ...
			}
		} else {
			// Handle if no results found for the given booking ID
			$error = "Invalid booking ID";
		}
	}

	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Sejarah tempahan</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Tourism Management System In PHP" />
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
		<div class="top-header">
			<?php include('includes/header.php'); ?>
			<div class="banner-1 ">
				<div class="container">
					<h1 class="wow zoomIn animated animated" data-wow-delay=".5s"
						style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">TMS-Tourism Management
						System</h1>
				</div>
			</div>
			<!--- /banner-1 ---->
			<!--- privacy ---->
			<div class="privacy">
				<div class="container">
					<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s"
						style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Sejarah tempahan
						saya</h3>
					<form name="chngpwd" method="post" onSubmit="return valid();">
						<?php if ($error) { ?>
							<div class="errorWrap"><strong>RALAT</strong>:
								<?php echo htmlentities($error); ?>
							</div>
						<?php } else if ($msg) { ?>
								<div class="succWrap"><strong>BERJAYA</strong>:
								<?php echo htmlentities($msg); ?>
								</div>
						<?php } ?>
						<p>

						<table border="1" width="100%">
							<tr align="center">
								<th>#</th>
								<th>Booking Id</th>
								<th>Nama aktiviti</th>
								<th>Tarikh</th>
								<th>Masa</th>
								<th>Catatan</th>
								<th>Status</th>
								<th>Tindakan</th>
							</tr>
							<?php
							$userEmail = $_SESSION['login'];
							$sql = "SELECT b.bookingId, a.activityName, b.noOfParticipant, b.timeSlot, b.bookDate, b.comment, b.status 
									FROM bookings b 
									INNER JOIN activity a ON b.activityId = a.activityId
									WHERE b.UserEmail = :EmailId";
							$query = $dbh->prepare($sql);
							$query->bindParam(':EmailId', $userEmail, PDO::PARAM_STR);
							$query->execute();
							$results = $query->fetchAll(PDO::FETCH_OBJ);
							$cnt = 1;
							if ($query->rowCount() > 0) {
								foreach ($results as $result) {
									?>
									<tr align="center">
										<td>
											<?php echo htmlentities($cnt); ?>
										</td>
										<td>#BK<?php echo htmlentities($result->bookingId); ?></td>
										<td><a href="activity-details.php?actId=<?php echo htmlentities($result->activityId); ?>"><?php echo htmlentities($result->activityName); ?></a></td>
										<td><?php echo htmlentities($result->bookDate); ?></td>
										<td><?php echo htmlentities($result->timeSlot); ?></td>
										<td><?php echo htmlentities($result->comment); ?></td>
										<td><?php echo htmlentities($result->status); ?></td>
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
					</form>
					<!-- - /privacy -->

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
<?php } ?>
