<?php
error_reporting(0);
if (isset($_POST['submit'])) {
	$fname = $_POST['fname'];
	$mnumber = $_POST['mobilenumber'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sql = "INSERT INTO  customers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':fname', $fname, PDO::PARAM_STR);
	$query->bindParam(':mnumber', $mnumber, PDO::PARAM_STR);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	if ($lastInsertId) {
		echo "<script>alert('Anda telah berjaya mendaftar. Sila log masuk.');</script>";
       
		//echo "<script type='text/javascript'> document.location = 'signin.php'; </script>";
          
		// $_SESSION['msg'] = "Anda telah berjaya mendaftar. Sila log masuk. ";
		// header('location:thankyou.php');
	} else {
		$_SESSION['msg'] = "Terdapat ralat. Sila cuba sekali lagi.";
		header('location:thankyou.php');
	}
}
?>
<!-- Javascript for checking email availability -->
<script>
	function checkAvailability() {
		$("#loaderIcon").show();
		jQuery.ajax({
			url: "check-email-availability.php",
			data: 'emailid=' + $("#email").val(),
			type: "POST",
			success: function (data) {
				$("#user-availability-status").html(data);
				$("#loaderIcon").hide();
			},
			error: function () { }
		});
	}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">×</span></button>
			</div>
			<section>
				<div class="modal-body modal-spa">
					<div class="login-grids">
						<div class="login">
							<div style="text-align: center;">
								<img src="image/logo.jpg" alt="Logo Lambo Sari"
									style="max-width: 200px; max-height: 200px;">
							</div>
							<div class="signup">
								<form name="signup" method="post">
									<h3><center>Daftar akaun</center></h3>
									<div style="text-align: center; margin-bottom: 10px;">
										<input type="text" value="" placeholder="Nama penuh" name="fname"
											autocomplete="on" required=""
											style="width: 100%; padding: 10px; margin-bottom: 10px;">
										<br>
										<input type="number" value="" placeholder="Nombor telefon" maxlength="10"
											name="mobilenumber" autocomplete="on" required=""
											style="width: 100%; padding: 10px; margin-bottom: 10px;">
										<br>
										<input type="text" value="" placeholder="Alamat emel" name="email" id="email"
											onBlur="checkAvailability()" autocomplete="on" required=""
											style="width: 100%; padding: 10px; margin-bottom: 10px;">
										<span id="user-availability-status" style="font-size: 12px;"></span>
										<br>
										<input type="password" value="" placeholder="Kata laluan" name="password"
											required="" style="width: 100%; padding: 10px; margin-bottom: 10px;">
										<br>
										<input type="submit" name="submit" id="submit" value="Daftar">
									</div>
								</form>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>
					<!-- <p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a href="page.php?type=privacy">Privacy Policy</a></p> -->
				</div>
			</section>
		</div>
	</div>
</div>