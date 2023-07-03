<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
   header('location:reservation.php');
} else {
   ?>
   <!DOCTYPE HTML>
   <html>

   <head>
      <title> LSRS | Staf</title>
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
               <!--header end here-->
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Utama</a> <i class="fa fa-angle-right"></i></li>
               </ol>
               <!--four-grids here-->
               <div class="four-grids">
                  <div class="col-md-3 four-grid">
                     <div class="four-agileits">
                         <a href="manage-customer-list.php">
                        <div class="icon">
                           <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                        </div>
                        <div class="four-text">
                           <h3>Pelanggan</h3>
                           <?php $sql = "SELECT id from customers";
                           $query = $dbh->prepare($sql);
                           $query->execute();
                           $results = $query->fetchAll(PDO::FETCH_OBJ);
                           $cnt = $query->rowCount();
                           ?>
                           <h4>
                              <?php echo htmlentities($cnt); ?>
                           </h4>
                        </div>
                     </div>
                  </div>


                  


                  <div class="col-md-3 four-grid">
                     <div class="four-agileinfo">
                        <div class="icon">
                           <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
                        </div>
                        <div class="four-text">
                           <h3>Tempahan</h3>
                           <?php $sql1 = "SELECT bookingId from bookings";
                           $query1 = $dbh->prepare($sql1);
                           $query1->execute();
                           $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                           $cnt1 = $query1->rowCount();
                           ?>
                           <h4>
                              <?php echo htmlentities($cnt1); ?>
                           </h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 four-grid">
                     <div class="four-w3ls">
                        <div class="icon">
                           <i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
                        </div>
                        <div class="four-text">
                           <h3>Pertanyaan</h3>
                           <?php $sql2 = "SELECT id from tblenquiry";
                           $query2 = $dbh->prepare($sql2);
                           $query2->execute();
                           $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                           $cnt2 = $query2->rowCount();
                           ?>
                           <h4>
                              <?php echo htmlentities($cnt2); ?>
                           </h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 four-grid">
                     <div class="four-wthree">
                        <div class="icon">
                           <i class="glyphicon glyphicon-th-list" aria-hidden="true"></i>
                        </div>
                        <div class="four-text">
                           <h3>Aktiviti</h3>
                           <?php $sql3 = "SELECT activityId from activity";
                           $query3 = $dbh->prepare($sql3);
                           $query3->execute();
                           $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                           $cnt3 = $query3->rowCount();
                           ?>
                           <h4>
                              <?php echo htmlentities($cnt3); ?>
                           </h4>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>

            </div>
            <!--//four-grids here-->
            <div class="inner-block">
            </div>
            <!--inner block end here-->
            <!--copy rights start here-->
            <?php include('includes/footer.php'); ?>
         </div>
      </div>
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
      <!-- morris JavaScript	
         <script src="js/raphael-min.js"></script>
         <script src="js/morris.js"></script> -->
      <script>
         $(document).ready(function () {
            //BOX BUTTON SHOW AND CLOSE
            jQuery('.small-graph-box').hover(function () {
               jQuery(this).find('.box-button').fadeIn('fast');
            }, function () {
               jQuery(this).find('.box-button').fadeOut('fast');
            });
            jQuery('.small-graph-box .box-close').click(function () {
               jQuery(this).closest('.small-graph-box').fadeOut(200);
               return false;
            });

            //CHARTS
            function gd(year, day, month) {
               return new Date(year, month - 1, day).getTime();
            }


         });
      </script>
   </body>

   </html>
<?php } ?>