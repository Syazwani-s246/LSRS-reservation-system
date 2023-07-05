<?php
session_start();
error_reporting(0);

// error_reporting(E_ALL);

include 'includes/config.php';
if (strlen($_SESSION['alogin']) == 0) {
    header('location:reservation.php');
} else {

    $activityId = intval($_GET['id']);
    if (isset($_POST['submit'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $role = $_POST['role'];

        $sql = "UPDATE staff SET phoneNumber=:phoneNumber, role=:role WHERE id=:staffId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        $query->bindParam(':staffId', $staffId, PDO::PARAM_INT);
        $query->execute();

        $msg = "Maklumat staf berjaya dikemaskini.";

        echo "<script>
			alert('Maklumat staf berjaya dikemaskini');
			window.location.href='manage-staff.php';
		</script>";
    }
   
    ?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Admin | Urus staf</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords"
            content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
                                             Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script
            type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
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
                    <?php include 'includes/header.php'; ?>
                    <div class="clearfix"> </div>
                </div>
                <!--heder end here-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Utama</a><i class="fa fa-angle-right"></i>Kemaskini
                        maklumat staf</li>
                </ol>
                <!--grid-->
                <div class="grid-form">
                    <!---->
                    <div class="grid-form1">
                        <h3>Kemaskini maklumat staf</h3>

                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">
                                <?php
                                $id = intval($_GET['id']);

                                $sql = "SELECT * FROM staff WHERE id=:staffId";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':staffId', $staffId, PDO::PARAM_INT);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_OBJ);

                              
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <form class="form-horizontal" name="activity" method="post" >
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Nama staf :</label>
                                                <div class="col-sm-8">
                                                <?php echo htmlentities($result['fullName']); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Nama staf :</label>
                                                <div class="col-sm-8">
                                                <?php echo htmlentities($result['fullName']); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Nama staf :</label>
                                                <div class="col-sm-8">
                                                <?php echo htmlentities($result['fullName']); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Bayaran aktiviti untuk
                                                    seorang (RM)</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control1" name="activityPrice"
                                                        id="activityPrice" placeholder=" contoh : 12"
                                                        value="<?php echo htmlentities($result->activityPrice); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Bilangan peserta
                                                    minimum</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control1" name="minPax" id="minPax"
                                                        placeholder=" contoh : 12"
                                                        value="<?php echo htmlentities($result->minPax); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Tempoh masa aktiviti (jam)
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control1" name="duration" id="duration"
                                                        placeholder=" contoh : 2"
                                                        value="<?php echo htmlentities($result->duration); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Maklumat aktiviti</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="5" cols="50" name="activityDetails"
                                                        id="activityDetails" placeholder="Maklumat aktiviti"
                                                        required><?php echo htmlentities($result->activityDetails); ?></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Gambar aktiviti</label>
                                                <div class="col-sm-8">
                                                    <img src="activityImage/<?php echo htmlentities($result->activityImage); ?>"
                                                        width="200">&nbsp;&nbsp;&nbsp;<a
                                                        href="change-image.php?aimage=<?php echo htmlentities($result->activityId); ?>">Tukar
                                                        gambar</a>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Tarikh kemaskini
                                                    terakhir</label>
                                                <div class="col-sm-8">
                                                    <?php echo htmlentities($result->updationDate); ?>
                                                </div>
                                            </div>
                                        <?php }
                                }
                                ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" name="submit" class="btn-primary btn">Kemaskini</button>
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
    <?php
} ?>