<?php
session_start();

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT EmailId, Password FROM customers WHERE EmailId=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if ($query->rowCount() > 0) {
        $user = $results[0];
        
        if ($user->Password == $password) {
            $_SESSION['login'] = $email;
            echo "<script type='text/javascript'> document.location = 'reservation.php'; </script>";
            exit();
        } else {
            // Password does not match
            echo "<script>alert('Kata laluan salah!');</script>";
        }
    } else {
        // Email is not registered, redirect to signup.php
        echo "<script>alert('Alamat emel tidak berdaftar, sila daftar akaun');</script>";
        
    }
}
?>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body modal-spa">
				<div class="login-grids">
					<div class="login">
							<div style="text-align: center;">
								<img src="image/logo.jpg" alt="Logo Lambo Sari" style="max-width: 200px; max-height: 200px;">
							</div>
							<form method="post" style="margin-top: 10px;">
									<h3 style="text-align: center;">Log masuk</h3>
									<?php if (isset($error)): ?>
										<div style="text-align: center; color: red;"><?php echo $error; ?></div>
									<?php endif; ?>
									<div style="text-align: center; margin-bottom: 10px;">
										<input type="text" name="email" id="email" placeholder="Sila masukkan alamat emel"
											required="" style="width: 100%; padding: 10px;">
									</div>
									<div style="text-align: center; margin-bottom: 10px; position: relative;">
										<input type="password" name="password" id="password" placeholder="Kata laluan" value=""
											required="" style="width: 100%; padding: 10px;">
										<span toggle="#password" class="eye-icon"></span>
									</div>
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
									<h4 style="text-align: center;"><a href="forgot-password.php">Lupa kata laluan</a></h4>
									<div style="text-align: center;">
										<input type="submit" name="signin" value="LOG MASUK" style="padding: 10px 20px;">
									</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div

