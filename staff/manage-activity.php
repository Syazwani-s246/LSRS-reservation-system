<?php
session_start();
error_reporting(0);
//error_reporting(E_ALL);

include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:reservation.php');
} else {
	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Staf | Urus aktiviti</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript"> addEventListener("load", function() 
										{ setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
										</script>
		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<!-- Custom CSS -->
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<!-- <link rel="stylesheet" href="css/morris.css" type="text/css"/> -->
		<!-- Graph CSS -->
		<link href="css/font-awesome.css" rel="stylesheet">
		<!-- jQuery -->
		<script src="js/jquery-2.1.4.min.js"></script>
		<!-- //jQuery -->
		<!-- tables -->
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
		<!-- //tables -->
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
			type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<!-- lined-icons -->
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<!-- //lined-icons -->
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
						aktiviti</li>
				</ol>
				<div class="agile-grids">
					<!-- tables -->

					<div class="agile-tables">
						<div class="w3l-table-info">
							<h2>Pengurusan aktiviti</h2>
							<table id="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama aktivity</th>
										<th>Harga per seorang</th>
										<th>Maklumat aktiviti</th>
										<th>Gambar</th>
										<th>Tarikh dicipta</th>
										<th>Tindakan</th>
									</tr>
								</thead>
								<tbody>
									<?php $sql = "SELECT * from activity";
									$query = $dbh->prepare($sql);
									//$query -> bindParam(':city', $city, PDO::PARAM_STR);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) { ?>
											<tr>
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td>
													<?php echo htmlentities($result->activityName); ?>
												</td>
												<td>
													<?php echo htmlentities($result->activityPrice); ?>
												</td>
												<td>
													<?php echo htmlentities($result->activityDetails); ?>
												</td>
												<td>
													<?php echo htmlentities($result->activityImage); ?>
												</td>
												<td>
													<?php echo htmlentities($result->creationDate); ?>
												</td>


												<!-- Modal -->
												<div class="modal fade"
													id="activityModal<?php echo htmlentities($result->activityId); ?>" tabindex="-1"
													role="dialog"
													aria-labelledby="activityModalLabel<?php echo htmlentities($result->activityId); ?>">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title"
																	id="activityModalLabel<?php echo htmlentities($result->activityId); ?>">
																	Maklumat penuh aktiviti</h4>
																<button type="button" class="close" data-dismiss="modal"
																	aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<?php
																// Retrieve the activity details from the database
																$activityId = $result->activityId;
																$sql = "SELECT * FROM activity WHERE activityId = :activityId";
																$query = $dbh->prepare($sql);
																$query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
																$query->execute();
																$activity = $query->fetch(PDO::FETCH_ASSOC);

																if ($activity) {
																	?>
																	<!--  -->
																	<p>
																		<img src="activityImage/<?php echo htmlentities($result->activityImage); ?>"
																			width="200" height="100" style="border:solid 1px #000">
																	</p>

																	<p><strong>Nama : </strong>
																		<?php echo htmlentities($activity['activityName']); ?>
																	</p>
																	<p><strong>Bayaran : RM</strong>
																		<?php echo htmlentities($activity['activityPrice']); ?>
																	</p>
																	<p><strong>Tempoh masa :</strong>
																		<?php echo htmlentities($activity['duration']); ?> jam
																	</p>
																	<p><strong>Bilangan peserta minimum :</strong>
																		<?php echo htmlentities($activity['minPax']); ?> orang
																	</p>
																	<p><strong>Maklumat :</strong>
																		<?php echo htmlentities($activity['activityDetails']); ?>
																	</p>
																	<p><strong>Tarikh akhir kemaskini :</strong>
																		<?php echo htmlentities($activity['updationDate']); ?>
																	</p>
																	<!-- Add more details if needed -->
																	<?php
																} else {
																	?>
																	<p>Maklumat aktiviti ini tidak tersedia</p>
																	<?php
																}
																?>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default"
																	data-dismiss="modal">Tutup</button>
															</div>
														</div>
													</div>
												</div>

												<td>

													<!-- retrieve details -->
													<a href="#" data-toggle="modal"
														data-target="#activityModal<?php echo htmlentities($result->activityId); ?>">
														<span class="glyphicon glyphicon-eye-open"></span>
													</a>



													<!-- update details -->
													<a
														href="update-activity.php?activityId=<?php echo htmlentities($result->activityId); ?>">
														<span class="glyphicon glyphicon-pencil"></span>
													</a>

													<!-- delete details -->
													<a
														href="delete-activity.php?activityId=<?php echo htmlentities($result->activityId); ?>">
														<span class="glyphicon glyphicon-trash"></span>
													</a>
												</td>


											</tr>
											<?php $cnt = $cnt + 1;
										}
									} ?>
								</tbody>
							</table>
						</div>
						</table>





					</div>
					<!-- script-for sticky-nav -->
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
		<script>
			var toggle = true;

			$(".sidebar-icon").click(function () {
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({ "position": "absolute" });
				}
				else {
					$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function () {
						$("#menu span").css({ "position": "relative" });
					}, 400);
				}

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