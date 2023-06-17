<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
   header('location:index.php');
} else {
   if (isset($_POST['submit'])) {

      $aname = $_POST['activityName'];
      $aprice = $_POST['activityPrice'];
      $adetails = $_POST['activityDetails'];

      $array = array();

      // define the key "activityImage"
      $array['activityImage'] = 'value';

      // access the key "activityImage"
      $activityImage = $array['activityImage'];




      $aimage = $_FILES["activityImage"]["name"];
      move_uploaded_file($_FILES["activityImage"]["tmp_name"], "activityImage/" . $_FILES["activityImage"]["name"]);
      $sql = "INSERT INTO activity
   (activityName,activityPrice,activityDetails,activityImage) 
   VALUES(:aname,:aprice,:adetails,:aimage)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':aname', $aname, PDO::PARAM_STR);
      $query->bindParam(':aprice', $aprice, PDO::PARAM_STR);
      $query->bindParam(':adetails', $adetails, PDO::PARAM_STR);
      $query->bindParam(':aimage', $aimage, PDO::PARAM_STR);
      $query->execute();
      $lastInsertId = $dbh->lastInsertId();

      if ($lastInsertId) {
         // $startTime = $_POST['startTime'];
         // $endTime = $_POST['endTime'];

         // foreach($start_time as $key=>$st) {
         // 	$et = $end_time[$key];
         // 	$sql = "INSERT INTO activitytimes (activityId, startTime, endTime) VALUES (:activityId, :st, :et)";
         // 	$query = $dbh->prepare($sql);
         // 	$query->bindParam(':activityId', $lastInsertId, PDO::PARAM_INT);
         // 	$query->bindParam(':st', $st, PDO::PARAM_STR);
         // 	$query->bindParam(':et', $et, PDO::PARAM_STR);
         // 	$query->execute();
         // }
         $msg = "Activiti berjaya dicipta!";
      } else {
         $error = "Ralat. Sila cuba lagi.";
      }
   }

   ?>
   <!DOCTYPE HTML>
   <html>

   <head>
      <title>LSRS | Cipta aktiviti</title>


      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
          function hideURLbar(){ window.scrollTo(0,1); } </script>
      <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
      <link href="css/style.css" rel='stylesheet' type='text/css' />
      <!-- <link rel="stylesheet" href="css/morris.css" type="text/css" /> -->
      <link href="css/font-awesome.css" rel="stylesheet">
      <script src="js/jquery-2.1.4.min.js"></script>
      <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
         type='text/css' />
      <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
               <li class="breadcrumb-item"><a href="index.php">Utama</a><i class="fa fa-angle-right"></i>Cipta aktiviti
               </li>
            </ol>
            <!--grid-->
            <div class="grid-form">
               <!---->
               <div class="grid-form1">
                  <h3>Cipta aktiviti baharu</h3>
                  <?php if ($error) { ?>
                     <div class="errorWrap"><strong>RALAT</strong>:
                        <?php echo htmlentities($error); ?>
                     </div>
                  <?php } else if ($msg) { ?>
                        <div class="succWrap"><strong>BERJAYA</strong>:
                        <?php echo htmlentities($msg); ?>
                        </div>
                  <?php } ?>
                  <div class="tab-content">
                     <div class="tab-pane active" id="horizontal-form">
                        <form class="form-horizontal" name="activity" method="post" enctype="multipart/form-data">
                           <div class="form-group">
                              <label for="focusedinput" class="col-sm-2 control-label">Nama aktiviti</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control1" name="activityName" id="activityname"
                                    placeholder="Nama aktiviti" required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="focusedinput" class="col-sm-2 control-label">Bayaran aktiviti untuk seorang (RM)
                              </label>
                              <div class="col-sm-8">
                                 <input type="number" class="form-control1" name="activityPrice" id="activityPrice"
                                    placeholder=" Contoh : 12 " required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="focusedinput" class="col-sm-2 control-label">Maklumat aktiviti</label>
                              <div class="col-sm-8">
                                 <textarea class="form-control" rows="5" cols="50" name="activityDetails"
                                    id="activityDetails" placeholder="Maklumat aktiviti" required></textarea>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="focusedinput" class="col-sm-2 control-label">Gambar aktiviti</label>
                              <div class="col-sm-8">
                                 <input type="file" name="activityImage" id="activityImage" required>
                              </div>
                           </div>
                           <!--For Time Slot 
                              <div class="form-group">
                              <label for="focusedinput" class="col-sm-2 control-label">Time Slot</label>
                              <div class="col-sm-8">
                                 <input type="file" name="activityImage" id="activityImage" required>
                              </div>
                           </div> -->
                           <div class="row">
                              <div class="col-sm-8 col-sm-offset-2">
                                 <button type="submit" name="submit" class="btn-primary btn">Cipta</button>
                                 <button type="reset" class="btn-inverse btn">Mula semula</button>
                              </div>
                           </div>
                     </div>
                     </form>
                     <div class="panel-footer">
                     </div>
                     </form>
                  </div>
               </div>
               <!--//grid-->
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