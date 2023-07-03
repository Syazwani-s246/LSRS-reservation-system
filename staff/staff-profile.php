<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:reservation.php');
} else {
	if (isset($_POST['submitstaff'])) {
		$name = $_POST['fullName'];
		$phoneNumber = $_POST['phoneNumber'];
		$email = $_SESSION['login'];

		$sql = "update staff set fullName=:fullName,mobileNumber=:phoneNumber where emailId=:email";
		$query = $dbh->prepare($sql);
		$query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
		$query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$msg = "Profil anda berjaya dikemaskini!";
	}

	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Pelanggan</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Reservation System" />
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
			
			<!--- /banner-1 ---->
			<!--- privacy ---->
			<div class="privacy">
				<div class="container">
					<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s"
						style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Maklumat saya</h3>
					<form name="chngpwd" method="post">
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
						$useremail = $_SESSION['login'];
						$sql = "SELECT * from customers where emailId=:useremail";
						$query = $dbh->prepare($sql);
						$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$cnt = 1;
						if ($query->rowCount() > 0) {
							foreach ($results as $result) { ?>

								<p style="width: 350px;">

									<b>Nama penuh</b> <input type="text" name="fullName"
										value="<?php echo htmlentities($result->fullName); ?>" class="form-control" id="fullName"
										readonly>
								</p>

								<p style="width: 350px;">
									<b>Nombor telefon</b>
									<input type="number" class="form-control" name="phoneNumber" maxlength="10"
										value="<?php echo htmlentities($result->mobileNumber); ?>" id="phoneNumber" required="">
								</p>

								
							<?php }
						} ?>

						<p style="width: 350px;">
							<button type="submit" name="submitstaff" class="btn-primary btn">Update</button>
						</p>
					</form>


				</div>
			</div>
			<!--- /privacy ---->
			<!--- footer-top ---->
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
<?php } ?>