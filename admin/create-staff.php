<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
   header('location:index.php');
} else {
   if (isset($_POST['submit'])) {
      $fullName = $_POST['fullName'];
      $phoneNumber = $_POST['phoneNumber'];
      $address = $_POST['address'];
      $role = $_POST['role'];
      $username = $_POST['username'];
      $password = $_POST['password'];

      $sql = "INSERT INTO staff (fullName, phoneNumber, address, role, username, password) 
              VALUES (:fullName, :phoneNumber, :address, :role, :username, :password)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
      $query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
      $query->bindParam(':address', $address, PDO::PARAM_STR);
      $query->bindParam(':role', $role, PDO::PARAM_STR);
      $query->bindParam(':username', $username, PDO::PARAM_STR);
      $query->bindParam(':password', $password, PDO::PARAM_STR);
      $query->execute();
      $lastInsertId = $dbh->lastInsertId();

      if ($lastInsertId) {
         $msg = "Staf berjaya ditambah!";
      } else {
         $error = "Ralat. Sila cuba lagi!";
      }
   }
}
?>

<!DOCTYPE HTML>
<html>

<head>
   <title>LSRS | Tambah staf</title>

   <script type="application/x-javascript">
      addEventListener("load", function() {
         setTimeout(hideURLbar, 0);
      }, false);

      function hideURLbar() {
         window.scrollTo(0, 1);
      }
   </script>
   <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
   <link href="css/style.css" rel='stylesheet' type='text/css' />
   <link href="css/font-awesome.css" rel="stylesheet">
   <script src="js/jquery-2.1.4.min.js"></script>
   <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
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
      <div class="left-content">
         <div class="mother-grid-inner">
            <?php include('includes/header.php'); ?>
            <div class="clearfix"> </div>
         </div>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Utama</a><i class="fa fa-angle-right"></i>Tambah Staf</li>
         </ol>
         <div class="grid-form">
            <div class="grid-form1">
               <h3>Tambah Staf<h3>
               <?php if ($error) { ?>
               <div class="errorWrap">
                  <strong>Ralat:</strong> <?php echo htmlentities($error); ?>
               </div>
               <?php } else if ($msg) { ?>
               <div class="succWrap">
                  <strong>Berjaya:</strong> <?php echo htmlentities($msg); ?>
               </div>
               <?php } ?>
               <div class="tab-content">
                  <div class="tab-pane active" id="horizontal-form">
                     <form class="form-horizontal" name="staff" method="post">
                        <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Nama penuh</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control1" name="fullName" id="fullName" placeholder="Nama penuh" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Nombor telefon</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control1" name="phoneNumber" id="phoneNumber" placeholder="0123456789" required>
                           </div>
                        </div>
                        <!-- <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Alamat</label>
                           <div class="col-sm-8">
                              <textarea class="form-control" rows="5" cols="50" name="address" id="address" placeholder="Address" required></textarea>
                           </div>
                        </div> -->
                        <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Jawatan</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control1" name="role" id="role" placeholder="Lambo Sari Crew" required>
                           </div>
                        </div>
                        Perhatian : Nama pengguna dan kata laluan adalah untuk staf log masuk ke dalam sistem
                        <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Nama pengguna</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control1" name="username" id="username" placeholder="Nama pengguna" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="focusedinput" class="col-sm-2 control-label">Kata laluan</label>
                           <div class="col-sm-8">
                              <input type="password" class="form-control1" name="Kata laluan" id="password" placeholder="Kata laluan" required>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-8 col-sm-offset-2">
                              <button type="submit" name="submit" class="btn-primary btn">Tambah</button>
                              <button type="reset" class="btn-inverse btn">Padam</button>
                           </div>
                        </div>
                  </div>
                  </form>
                  <div class="panel-footer">
                  </div>
                  </form>
               </div>
            </div>
            <div class="inner-block">
            </div>
            <?php include('includes/footer.php'); ?>
         </div>
      </div>
      <?php include('includes/sidebarmenu.php'); ?>
      <div class="clearfix"></div>
   </div>
   <script>
      var toggle = true;

      $(".sidebar-icon").click(function () {
         if (toggle) {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({ "position": "absolute" });
         } else {
            $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
            setTimeout(function () {
               $("#menu span").css({ "position": "relative" });
            }, 400);
         }

         toggle = !toggle;
      });
   </script>
   <script src="js/jquery.nicescroll.js"></script>
   <script src="js/scripts.js"></script>
   <script src="js/bootstrap.min.js"></script>
</body>

</html>
<?php  ?>
