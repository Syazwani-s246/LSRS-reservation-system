<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Theme Made By www.w3schools.com -->
	<title>Lambo Sari | Laman Utama</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
		integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
		integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
		crossorigin="anonymous"></script>
	<!-- <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
	<!--Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<!--JQuery-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">  </script>
	<!-- <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script> -->
	<!--Glyphicons-->
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	<style>
		body {
			font: 400 15px Lato, sans-serif;
			line-height: 1.8;
			color: #0D1821;
		}

		h2 {
			font-size: 24px;
			text-transform: uppercase;
			color: #303030;
			font-weight: 600;
			margin-bottom: 30px;
		}

		h4 {
			font-size: 19px;
			line-height: 1.375em;
			color: #303030;
			font-weight: 400;
			margin-bottom: 30px;
		}

		.jumbotron {
			background-color: #cf995f;
			color: #303030;
			padding: 100px 25px;
			font-family: Montserrat, sans-serif;
		}

		.container-fluid {
			padding: 60px 50px;
		}

		.bg-grey {
			background-color: #D9DBF1;
		}

		.logo-small {
			color: #cf995f;
			font-size: 50px;
		}

		.logo {
			color: #cf995f;
			font-size: 200px;
		}

		.thumbnail {
			padding: 0 0 15px 0;
			border: none;
			border-radius: 0;
		}

		.thumbnail img {
			width: 400px;
			height: 400px;
			margin-bottom: 10px;
		}

		.carousel-control.right,
		.carousel-control.left {
			background-image: none;
			color: #cf995f;
		}

		.carousel-indicators li {
			border-color: #cf995f;
		}

		.carousel-indicators li.active {
			background-color: #cf995f;
		}

		.item h4 {
			font-size: 19px;
			line-height: 1.375em;
			font-weight: 400;
			font-style: italic;
			margin: 70px 0;
		}

		.item span {
			font-style: normal;
		}

		.panel {
			border: 1px solid #cf995f;
			border-radius: 0 !important;
			transition: box-shadow 0.5s;
		}

		.panel:hover {
			box-shadow: 5px 0px 40px rgba(0, 0, 0, .2);
		}

		.panel-footer .btn:hover {
			border: 1px solid #cf995f;
			background-color: #343A40 !important;
			color: #cf995f;
		}

		.panel-heading {
			color: #FFFCFF !important;
			background-color: #cf995f !important;
			padding: 25px;
			border-bottom: 1px solid transparent;
			border-top-left-radius: 0px;
			border-top-right-radius: 0px;
			border-bottom-left-radius: 0px;
			border-bottom-right-radius: 0px;
		}

		.panel-footer {
			background-color: white !important;
		}

		.panel-footer h3 {
			font-size: 32px;
		}

		.panel-footer h4 {
			color: #aaa;
			font-size: 14px;
		}

		.panel-footer .btn {
			margin: 15px 0;
			background-color: #cf995f;
			color: #FFFCFF;
		}

		.navbar {
			margin-bottom: 0;
			background-color: #cf995f;
			z-index: 9999;
			border: 0;
			font-size: 12px !important;
			line-height: 1.42857143 !important;
			letter-spacing: 0px;
			border-radius: 0;
			font-family: Montserrat, sans-serif;
		}

		.navbar li a,
		.navbar .navbar-brand {
			color: #FFFCFF !important;
			margin: 5px;
		}

		.navbar-nav li a:hover,
		.navbar-nav li.active a {
			color: #cf995f !important;
			background-color: #FFFCFF !important;
		}

		.navbar-default .navbar-toggle {
			border-color: transparent;
			color: #FFFCFF !important;
		}

		footer .glyphicon {
			font-size: 20px;
			margin-bottom: 20px;
			color: #cf995f;
		}

		.slideanim {
			visibility: hidden;
		}

		.slide {
			animation-name: slide;
			-webkit-animation-name: slide;
			animation-duration: 1s;
			-webkit-animation-duration: 1s;
			visibility: visible;
		}

		@keyframes slide {
			0% {
				opacity: 0;
				transform: translateY(70%);
			}

			100% {
				opacity: 1;
				transform: translateY(0%);
			}
		}

		@-webkit-keyframes slide {
			0% {
				opacity: 0;
				-webkit-transform: translateY(70%);
			}

			100% {
				opacity: 1;
				-webkit-transform: translateY(0%);
			}
		}

		@media screen and (max-width: 768px) {
			.col-sm-4 {
				text-align: center;
				margin: 25px 0;
			}

			.btn-lg {
				width: 100%;
				margin-bottom: 35px;
			}
		}

		@media screen and (max-width: 480px) {
			.logo {
				font-size: 150px;
			}
		}
	</style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
	<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand" href="#myPage">Lambo Sari</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><a class="nav-link" href="#about">Mengenai kami</a></li>
					<li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
					<li class="nav-item"><a class="nav-link" href="#how">Cara tempahan</a></li>
					<li class="nav-item"><a class="nav-link" href="reservation.php">Buat tempahan</a></li>
					<li class="nav-item"><a class="nav-link" href="#contact">Hubungi kami</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="jumbotron text-center">
		<h1>Lambo Sari</h1>
		<p>Melestarikan Warisan secara Digital</p>


		<a href="reservation.php">
			<button class="btn btn-secondary btn-lg">Tempah slot aktiviti sekarang</button>
		</a>

	</div>
	<!-- Container (About Section) -->
	<div id="about" class="container-fluid">
		<div class="row">
			<div class="col-sm-8">
				<h2>Mengenai Lambo Sari</h2>

				<p>Lambo Sari, merupakan unit kepada Koperasi Homestay Teluk Ketapang (KHTK) dan mula beroperasi sebagai
					pusat interaktif budaya sejak 2019. Antara pakej aktiviti yang ditawarkan oleh Lambo Sari meliputi
					aktiviti mewarna Batik, demo masakan, berbusana tradisional, mencanting Batik, membuat Wau dan
					mewarna Wau dengan corak bermotif Batik. </p>
				<h4><strong>Misi</strong> <br>
					Pihak Lambo Sari percaya bahawa kita seharusnya mengekalkan warisan budaya ini agar terpelihara
					identiti dan budaya dan tidak lenyap ditelan arus pemodenan.
					Budaya perlu dikekalkan demi kesinambungan tamadun kita. Melalui budaya tradisional, kita mengetahui
					asal usul kita dan tidak dihanyutkan oleh budaya moden.</h4>

				<h4><strong>Visi</strong> <br>
					Lambo Sari mengalu-alukan sebarang kolaborasi dengan mana-mana syarikat, individu persendirian,
					kerajaan atau organisasi yang berminat dalam membantu pusat interaktif budaya ini untuk terus
					memperkasakan budaya dan warisan. Pihak Lambo Sari mengharap mereka boleh dapat terus bergerak ke
					hadapan dengan sokongan pelbagai pihak.
					</p>
					<br><a href=#contact> <button class="btn btn-secondary btn-lg">Hubungi kami</button> </a>
			</div>
			<div class="col-sm-4">
				<img src="assets\banner.jpg" alt="Lambo Sari" position=flex; width=100%; height=auto;>
				<br>
				<br>
				<center>
					<img src="assets\puanSarinah.jpg" alt="Puan Sarinah" width=auto; height="300">
					<p><strong>Puan Sarinah</strong></p>
					<p>CEO, Lambo Sari</p>
			</div>

		</div>
	</div>
	</div>


	<!-- Container (Portfolio Section) -->
	<div id="gallery" class="container-fluid text-center bg-grey">
		<h2>Galeri</h2>
		<br>
		<h4>Terokai aktiviti menarik</h4>
		<div class="row text-center slideanim">
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery1.jpg" alt="Galeri 1">
					<!-- <p><strong>Nasi Lemak</strong></p>
						<p>Yes, we serve Nasi Lemak</p> -->
				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery2.jpg" alt="Galeri 2">
					<!-- <p><strong>Nasi Lemak</strong></p>
						<p>Yes, we serve Nasi Lemak</p> -->
				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery3.jpg" alt="Galeri 3">

				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery4.jpg" alt="Galeri 4">

				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery5.jpg" alt="Galeri 5">

				</div>
			</div>
			<div class="col-sm-4">
				<div class="thumbnail">
					<img src="assets\gallery6.jpg" alt="Galeri 6">

				</div>
			</div>
		</div>
		<br>
	</div>

	<!-- Container (gallery Section) -->
	<div id="how" class="container-fluid text-center">
		<h2>Cara Tempahan</h2>
		<h4>Ikuti langkah di bawah untuk menempah slot aktiviti</h4>
		<br>
		<div class="row slideanim">
			<div class="col-sm-4">
				<span class="glyphicon glyphicon glyphicon-ok logo-small"></span>
				<h4>Laman utama</h4>
				<p>Klik butang "Tempah slot aktiviti sekarang"</p>
			</div>
			<div class="col-sm-4">
				<span class="glyphicon glyphicon-user logo-small"></span>
				<h4>Daftar/ Log masuk</h4>
				<p>Daftar akaun/ log masuk akaun</p>
			</div>
			<div class="col-sm-4">
				<span class="glyphicon glyphicon-search logo-small"></span>
				<h4>Pilih</h4>
				<p>Pilih aktiviti</p>
			</div>
			<!-- <div class="col-sm-4">
					<span class="glyphicon glyphicon-pencil logo-small"></span>
					<h4>Info</h4>
					<p>Klik info lanjut di aktiviti</p>
				</div> -->
		</div>
		<br><br>
		<div class="row slideanim">
			<div class="col-sm-4">
				<span class="glyphicon glyphicon-list-alt logo-small"></span>
				<h4>Isi</h4>
				<p>Isi maklumat</p>
			</div>
			<div class="col-sm-4">
				<span class="glyphicon glyphicon-check logo-small"></span>
				<h4>Tempah</h4>
				<p>Klik butang tempah</p>
			</div>
			<div class="col-sm-4">
				<span class="glyphicon glyphicon-tag logo-small"></span>
				<h4 style="color:#303030;">Pembayaran</h4>
				<p>Bayar berdasarkan jumlah yang ditetapkan</p>
			</div>
		</div>
	</div>

	<!-- Container (Contact Section) -->
	<div id="contact" class="container-fluid bg-grey">
		<h2 class="text">Hubungi Kami</h2>
		<div class="row">
			<div class="col-sm-5">
				<h3><strong>Pembangun Laman Web</strong></h3>
				<p>Norsyazwani binti Mohd Subri</p>
				<p><span class="glyphicon glyphicon-map-marker"></span> Universiti Malaysia Terengganu, Kuala
					Terengganu, Malaysia</p>
				<!-- <p><a href="https://www.google.com/maps/place/Universiti+Malaysia+Terengganu/@5.3643927,103.1268254,17z/data=!3m1!4b1!4m5!3m4!1s0x304ac7eea5b5dcc7:0x9f852e7097dcfdaa!8m2!3d5.3643927!4d103.1290641" target="_blank">
  <span class="glyphicon glyphicon-map-marker"></span> 
  Universiti Malaysia Terengganu, Kuala Terengganu, Malaysia
</a></p> -->
				<p><span class="glyphicon glyphicon-phone"></span> +60139059827</p>
				<p><span class="glyphicon glyphicon-envelope"></span> s59246@ocean.umt.edu.my</p>
			</div>
			<div class="col-sm-5">
				<h3><strong>Lambo Sari</strong></h3>
				<p>Puan Sarinah</p>
				<p><span class="glyphicon glyphicon-map-marker"></span> 28486, Jalan Ketapang, Kampung Telaga Daing,
					21300 Kuala Terengganu, Malaysia</p>
				<p><span class="glyphicon glyphicon-phone"></span> +60199438979</p>
				<p><span class="glyphicon glyphicon-envelope"></span> lambosariresources@gmail.com</p>
			</div>
		</div>

	</div>

	<footer class="container-fluid text-center">
		<a href="#myPage" title="To Top">
			<span class="glyphicon glyphicon-chevron-up"></span>
		</a>
		<p>Lambo Sari</p>
	</footer>
	<script>
		$(document).ready(function () {
			// Add smooth scrolling to all links in navbar + footer link
			$(".navbar a, footer a[href='#myPage']").on('click', function (event) {
				// Make sure this.hash has a value before overriding default behavior
				if (this.hash !== "") {
					// Prevent default anchor click behavior
					event.preventDefault();

					// Store hash
					var hash = this.hash;

					// Using jQuery's animate() method to add smooth page scroll
					// The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
					$('html, body').animate({
						scrollTop: $(hash).offset().top
					}, 900, function () {

						// Add hash (#) to URL when done scrolling (default click behavior)
						window.location.hash = hash;
					});
				} // End if
			});

			$(window).scroll(function () {
				$(".slideanim").each(function () {
					var pos = $(this).offset().top;

					var winTop = $(window).scrollTop();
					if (pos < winTop + 600) {
						$(this).addClass("slide");
					}
				});
			});
		})
	</script>
</body>

</html>