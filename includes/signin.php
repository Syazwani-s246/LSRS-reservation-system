<?php
session_start();
if (isset($_POST['signin'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sql = "SELECT EmailId,Password FROM customers WHERE EmailId=:email and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['login'] = $_POST['email'];
		echo "<script type='text/javascript'> document.location = 'reservation.php'; </script>";
	} else {

		echo "<script>alert('Invalid Details');</script>";

	}

}

?>


<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body modal-spa">
				<div class="login-grids">
					<div class="login">
						<!-- <div class="login-left">
							<ul>
								<li><a class="fb" href="#"><i></i>HEEEEE</a></li>
								<li><a class="goog" href="#"><i></i>Google</a></li>

							</ul>
						</div> -->
						<div class="login-right">
							<form method="post">
								<h3>Log masuk</h3>
								<input type="text" name="email" id="email" placeholder="Sila masukkan alamat emel"
									required="">
								<!-- <input type="password" name="password" id="password" placeholder="Kata laluan" value=""
									required=""> -->

								<input type="password" name="password" id="password" placeholder="Kata laluan" value=""
									required="">
								<span toggle="#password" class="eye-icon"></span>

								<style>
									.eye-icon {
										position: absolute;
										top: 50%;
										right: 10px;
										transform: translateY(-50%);
										cursor: pointer;
										color: #999;
									}

									.eye-icon:before {
										content: "\f070";
										font-family: FontAwesome;
									}

									.eye-icon.active:before {
										content: "\f06e";
									}
								</style>

								<script>
									$(document).on('click', '.eye-icon', function () {
										var $password = $($(this).attr('toggle'));
										if ($password.attr('type') === 'password') {
											$password.attr('type', 'text');
										} else {
											$password.attr('type', 'password');
										}
										$(this).toggleClass('active');
									});

								</script>


								<h4><a href="forgot-password.php">Lupa kata laluan</a></h4>

								<input type="submit" name="signin" value="SIGNIN">
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- <p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a
							href="page.php?type=privacy">Privacy Policy</a></p> -->
				</div>
			</div>
		</div>
	</div>
</div>