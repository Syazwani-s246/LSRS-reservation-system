<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:reservation.php');
} else {
	// Code for cancelling a booking
	if (isset($_GET['bookingId'])) {
		$bookingId = intval($_GET['bookingId']);
		$status = 2;
		$cancelBy = 'Admin';

		$sql = "UPDATE bookings SET status = :status, CancelledBy = :cancelBy WHERE bookingId = :bookingId";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		$query->bindParam(':cancelBy', $cancelBy, PDO::PARAM_STR);
		$query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
		$query->execute();

		$msg = "Tempahan telah dibatalkan.";
	}

	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>LSRS | Urus tempahan</title>
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
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>
					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="dashboard.php">Utama</a><i class="fa fa-angle-right"></i>Urus
						tempahan</li>
				</ol>
				<div class="agile-grids">
					<!-- tables -->
					<?php if ($error) { ?>
						<div class="errorWrap"><strong>RALAT</strong>:
							<?php echo htmlentities($error); ?>
						</div>
					<?php } else if ($msg) { ?>
							<div class="succWrap"><strong>BERJAYA</strong>:
							<?php echo htmlentities($msg); ?>
							</div>
						<?php } ?>
					<div class="agile-tables">
						<div class="w3l-table-info">
							<h2>Urus tempahan</h2>
							<table id="table">
								<thead>
									<tr>
										<th>ID Tempahan</th>
										<th>Nama penuh</th>
										<!-- <th>Mobile No.</th> -->
										<th>Nombor telefon</th>
										<!-- <th>RegDate </th> -->
										<th>Tarikh</th>
										<th>Slot masa</th>
										<th>Aktiviti</th>
										<!-- <th>Bilangan peserta</th> -->
										<!-- <th>Catatan pelanggan</th> -->
										<th>Status </th>

									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT bookings.*, customers.*, activity.*
									FROM bookings
									JOIN customers ON bookings.customerId = customers.id
									JOIN activity ON bookings.activityId = activity.activityId";


									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) {
											$status = ($result->status == 1) ? 'Telah dibayar' : 'Belum dibayar';
											?>
											<tr>
												<td>
													<a href="#" data-toggle="modal"
														data-target="#bookingDetailsModal<?php echo htmlentities($result->bookingId); ?>">
														#BK-<?php echo htmlentities($result->bookingId); ?>
													</a>
												</td>
												<td>
													<?php echo htmlentities($result->fullName); ?>
												</td>
												<td>
													<?php
													$mobileNumber = htmlentities($result->mobileNumber);
													$url = "https://api.whatsapp.com/send?phone=" . $mobileNumber;
													?>
													<a href="<?php echo $url; ?>" target="_blank"><?php echo $mobileNumber; ?></a>
												</td>
												<td>
													<?php echo htmlentities($result->bookDate); ?>
												</td>
												<td>
													<?php echo htmlentities($result->timeSlot); ?>
												</td>
												<td>
													<?php echo htmlentities($result->activityName); ?>
												</td>

												<td>
													<?php echo $status; ?>
												</td>


											</tr>

											<!-- Modal -->
											<div class="modal fade"
												id="bookingDetailsModal<?php echo htmlentities($result->bookingId); ?>"
												tabindex="-1" role="dialog" aria-labelledby="bookingDetailsModalLabel"
												aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="bookingDetailsModalLabel">Maklumat tempahan
															</h5>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<!-- Add the booking details here -->
															<p><strong>ID Tempahan:</strong> #BK-
																<?php echo htmlentities($result->bookingId); ?>
															</p>
															<p><strong>Nama penuh:</strong>
																<?php echo htmlentities($result->fullName); ?>
															</p>
															<p><strong>Emel:</strong>
																<?php echo htmlentities($result->emailId); ?>
															</p>
															<p><strong>Nombor telefon:</strong>
																<?php echo htmlentities($result->mobileNumber); ?>
															</p>
															<p><strong>Tarikh:</strong>
																<?php echo htmlentities($result->bookDate); ?>
															</p>
															<p><strong>Aktiviti:</strong>
																<?php echo htmlentities($result->activityName); ?>
															</p>
															<p><strong>Slot masa:</strong>
																<?php echo htmlentities($result->timeSlot); ?>
															</p>
															<p><strong>Tempoh masa aktiviti:</strong>
																<?php echo htmlentities($result->duration); ?> jam
															</p>
															<p><strong>Bilangan peserta:</strong>
																<?php echo htmlentities($result->noOfParticipant); ?>
															</p>
															<p><strong>Catatan pelanggan:</strong>
																<?php echo htmlentities($result->comment); ?>
															</p>
															<p><strong>Status :</strong>
																<?php echo $status; ?>
															</p>
															<!-- Add more booking details as needed -->
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary"
																data-dismiss="modal">Tutup</button>
														</div>
													</div>
												</div>
											</div>

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