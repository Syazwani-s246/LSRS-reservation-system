<?php if ($_SESSION['login']) { ?>
	<div class="top-header">
		<div class="container">
			<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
				<li class="hm"><a href="reservation.php"><i class="fa fa-home"></i></a></li>
				<li class="prnt"><a href="profile.php">Profil saya</a></li>
				<li class="prnt"><a href="change-password.php">Tukar kata laluan</a></li>
				<li class="prnt"><a href="book-history.php">Tempahan saya</a></li>
				<!-- <li class="prnt"><a href="payment-list.php">Pembayaran</a></li> -->
				<!-- <li class="prnt"><a href="issuetickets.php">Issue Tickets</a></li> -->
			</ul>
			<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s">
				<li class="tol">Selamat Datang:</li>
				<li class="sig">
					<?php echo htmlentities($_SESSION['login']); ?>
				</li>
				<li class="sigi"><a href="logout.php">/ Log keluar</a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>
<?php } else { ?>
	<div class="top-header">
		<div class="container">
			<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
				<li class="hm"><a href="reservation.php"><i class="fa fa-home"></i></a></li>
				<li class="hm"><a href="management.php">Log masuk Pengurusan</a></li>
			</ul>
			<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s">
				<li class="tol">Hubungi: 013-4568790</li>
				<li class="sig"><a href="#" data-toggle="modal" data-target="#myModal">Daftar</a></li>
				<li class="sigi"><a href="#" data-toggle="modal" data-target="#myModal4">/ Log masuk</a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>
<?php } ?>
<!--- /top-header ---->
<!--- header ---->
<div class="header">
	<div class="container">
		<div class="logo wow fadeInDown animated" data-wow-delay=".5s">
			<!-- <a href="reservation.php">Lambo Sari<span></span></a> -->
			<a href="reservation.php" style="display: inline-block;">
				<img src="image/header.png" alt="Logo Lambo Sari" style="max-width: 100%; height: auto; width: 200px;">
			</a>
		</div>



		<div class="clearfix"></div>
	</div>
</div>
<!--- /header ---->
<!--- footer-btm ---->
<div class="footer-btm wow fadeInLeft animated" data-wow-delay=".5s">
	<div class="container">
		<div class="navigation">
			<nav class="navbar navbar-default">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
					<nav class="cl-effect-1">
						<ul class="nav navbar-nav">
							
							<li><a href="reservation.php">Utama</a></li>
							<!-- <li><a href="page.php?type=aboutus">About</a></li> -->
							<li><a href="reservation.php">Senarai aktiviti</a></li>
							<!-- <li><a href="page.php?type=privacy">Privacy Policy</a></li> -->
							<!-- <li><a href="page.php?type=terms">Terms of Use</a></li>
								<li><a href="page.php?type=contact">Contact Us</a></li> -->
							<?php if ($_SESSION['login']) { ?>
							<?php } else { ?>
								<!-- <li><a href="enquiry.php"> Pertanyaan </a> </li> -->
							<?php } ?>
							<div class="clearfix"></div>

						</ul>
					</nav>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>

		<div class="clearfix"></div>
	</div>
</div>