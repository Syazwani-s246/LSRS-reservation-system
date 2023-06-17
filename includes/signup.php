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
		$_SESSION['msg'] = "Anda telah berjaya mendaftar. Sila log masuk. ";
		header('location:thankyou.php');
	} else {
		$_SESSION['msg'] = "Terdapat ralat. Sila cuba sekali lagi.";
		header('location:thankyou.php');
	}
}
?>
<!--Javascript for check email availabilty-->
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<section>
				<div class="modal-body modal-spa">
					<div class="login-grids">
						<div class="login">
							<!-- <div class="login-left">
												<ul>
													<li><a class="fb" href="#"><i></i>Facebook</a></li>
													<li><a class="goog" href="#"><i></i>Google</a></li>
													
												</ul>
											</div> -->
							<div class="login-right">
								<form name="signup" method="post">
									<h3>Cipta akaun</h3>


									<input type="text" value="" placeholder="Full Name" name="fname" autocomplete="on"
										required="">
									<input type="text" value="" placeholder="Mobile number" maxlength="10"
										name="mobilenumber" autocomplete="on" required="">
									<input type="text" value="" placeholder="Email id" name="email" id="email"
										onBlur="checkAvailability()" autocomplete="on" required="">
									<span id="user-availability-status" style="font-size:12px;"></span>
									<input type="password" value="" placeholder="Password" name="password" required="">
									<input type="submit" name="submit" id="submit" value="BUAT AKAUN">
								</form>
							</div>
							<div class="clearfix"></div>
						</div>
						<!-- <p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a href="page.php?type=privacy">Privacy Policy</a></p> -->
					</div>
				</div>
			</section>
		</div>
	</div>
</div>