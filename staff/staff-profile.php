<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:reservation.php');
} else {
    if (isset($_POST['submit'])) {
        $fullName = $_POST['fullName'];
        $phoneNumber = $_POST['phoneNumber'];
        $username = $_SESSION['alogin'];

        $sql = "update staff set fullName=:fullName, phoneNumber=:phoneNumber where username=:username";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        echo '<script>alert("Profil anda berjaya dikemaskini!");</script>';
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Profil Staf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
                                             Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/morris.css" type="text/css" />
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
        <!--/content-inner-->
        <div class="left-content">
            <div class="mother-grid-inner">
                <!--header start here-->
                <?php include 'includes/header.php'; ?>
                <div class="clearfix"> </div>
            </div>
            <!--heder end here-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="staff-dashboard.php">Utama</a><i class="fa fa-angle-right"></i>Profil Staf</li>
            </ol>
            <!--grid-->
            <div class="grid-form">
                <!---->
                <div class="grid-form1">
                    <h3>Kemaskini maklumat staf</h3>
                    <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                            <?php
                            $username = $_SESSION['alogin'];
                            $sql = "SELECT * from staff where username=:username";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':username', $username, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) {
                            ?>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <p style="width: 350px;">
                                            <b>Nama penuh</b>
                                            <input type="text" name="fullName" value="<?php echo htmlentities($result->fullName); ?>" class="form-control" id="fullName" readonly>
                                        </p>
                                        <p style="width: 350px;">
                                            <b>Nombor telefon</b>
                                            <input type="number" class="form-control" name="phoneNumber" maxlength="10" value="<?php echo htmlentities($result->phoneNumber); ?>" id="phoneNumber" required="">
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button type="submit" name="submit" class="btn-primary btn">Kemaskini</button>
                                            </div>
                                        </div>
                                    </form>
                            <?php
                                }
                            }
                            ?>
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
                    <?php include 'includes/footer.php'; ?>
                    <!--COPY rights end here-->
                </div>
            </div>
            <!--//content-inner-->
            <!--/sidebar-menu-->
            <?php include 'includes/sidebarmenu.php'; ?>
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
        <!--js -->
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- /Bootstrap Core JavaScript -->
</body>

</html>
