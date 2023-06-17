<?php
session_start();
error_reporting(0);
include 'includes/config.php';
?>

<!DOCTYPE HTML>
<html>

<head>
   <title> Sistem Tempahan Lambo Sari </title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <script type="application/x-javascript">
      addEventListener("load", function () {
         setTimeout(hideURLbar, 0);
      }, false);

      function hideURLbar() {
         window.scrollTo(0, 1);
      }
   </script>
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
   <!--//end-animate-->
</head>

<body>
   <?php include 'includes/header.php'; ?>
   <div class="container">
      <h1 class="wow zoomIn animated animated" data-wow-delay=".5s"
         style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> Melestarikan Warisan secara Digital
      </h1>
   </div>
   <!-- </div> -->
   <!---activity---->
   <div class="container">
   <div class="activity">
      <h3>Terokai pelbagai aktiviti di Lambo Sari</h3>
      <div class="row">
         <?php
         $sql = "SELECT * FROM activity";
         $query = $dbh->prepare($sql);
         $query->execute();
         $results = $query->fetchAll(PDO::FETCH_OBJ);
         $cnt = 1;
         if ($query->rowCount() > 0) {
            foreach ($results as $result) {
               $activityId = $result->activityId;
               $imageSql = "SELECT * FROM activity WHERE activityId = :activityId";
               $imageQuery = $dbh->prepare($imageSql);
               $imageQuery->bindParam(':activityId', $activityId, PDO::PARAM_INT);
               $imageQuery->execute();
               $images = $imageQuery->fetchAll(PDO::FETCH_OBJ);
         ?>
               <div class="col-md-4">
                  <div class="img-btm">
                     <div class="activity-image-wrapper">
                        <img src="admin/activityImage/<?php echo htmlentities($result->activityImage); ?>" class="img-responsive activity-image" alt="">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <h4><?php echo htmlentities($result->activityName); ?></h4>
                     <p><?php echo htmlentities($result->activityDetails); ?></p>
                     <h5>RM <?php echo htmlentities($result->activityPrice); ?></h5>
                     <?php if (isset($_SESSION['login'])) { ?>
                        <a href="activity-details.php?actId=<?php echo htmlentities($result->activityId); ?>" class="view">Tempah sekarang</a>
                     <?php } else { ?>
                        <a href="javascript:void(0);" onclick="alert('Sila log masuk dahulu untuk buat tempahan');" class="view">Tempah sekarang</a>
                     <?php } ?>
                  </div>
               </div>
         <?php
               $cnt++;
            }
         }
         ?>
      </div>
   </div>
   <div class="clearfix"></div>
</div>

      <div class="clearfix"></div>
   </div>
   <?php include 'includes/footer.php'; ?>
   <!-- signup -->
   <?php include 'includes/signup.php'; ?>
   <!-- //signu -->
   <!-- signin -->
   <?php include 'includes/signin.php'; ?>
   <!-- //signin -->
   <!-- write us -->
   <?php include 'includes/write-us.php'; ?>
   <!-- //write us -->
</body>

</html>
