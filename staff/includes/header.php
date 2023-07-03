<?php
include 'includes/config.php'; // Include config.php at the beginning

// Retrieve the staff's name from the database
$sql = "SELECT fullName FROM staff";
$query = $dbh->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$staffName = $result['fullName'];
?>

<!-- HTML code with dynamic staff name -->
<div class="header-main">
   <div class="logo-w3-agile">
      <h1><a href="staff-dashboard.php">Sistem Pengurusan Tempahan</a></h1>
   </div>
   <div class="profile_details w3l">
      <ul>
         <li class="dropdown profile_details_drop">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
               <div class="profile_img">
                  <span class="prfil-img"><img src="images/User-icon.png" alt=""></span>
                  <div class="user-name">
                     <p>Selamat datang,  <span><?php echo $staffName; ?></span></p>
                  </div>
                  <i class="fa fa-angle-down"></i>
                  <i class="fa fa-angle-up"></i>
                  <div class="clearfix"></div>
               </div>
            </a>
            <ul class="dropdown-menu drp-mnu">
			<li> <a href="staff-profile.php"><i class="fa fa-user"></i> Profil saya</a> </li>
			
               <li> <a href="change-password.php"><i class="fa fa-lock"></i> Tetapan</a> </li>
               <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Log keluar</a> </li>
            </ul>
         </li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>