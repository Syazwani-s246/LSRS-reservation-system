<?php
session_start();
include('includes/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['bookingDetails'])) {
    $bookingDetails = $_SESSION['bookingDetails'];

    if (isset($_GET['activityId'], $_GET['customerId'])) {
        $activityId = $_GET['activityId'];
        $customerId = $_GET['customerId'];

        // Retrieve booking details from session
        $noOfParticipant = $bookingDetails['noOfParticipant'];
        $timeSlot = $bookingDetails['timeSlot'];
        $bookDate = $bookingDetails['bookDate'];
        $comment = $bookingDetails['comment'];
        $totalPayment = $bookingDetails['totalPayment'];

        // Retrieve activity name
        $activitySql = "SELECT activityName FROM activity WHERE activityId = :activityId";
        $activityQuery = $dbh->prepare($activitySql);
        $activityQuery->bindParam(':activityId', $activityId, PDO::PARAM_INT);
        $activityQuery->execute();
        $activityRow = $activityQuery->fetch(PDO::FETCH_ASSOC);
        $activityName = $activityRow ? $activityRow['activityName'] : "Unknown Activity";

        // Retrieve customer full name
        $customerSql = "SELECT fullName FROM customers WHERE id = :customerId";
        $customerQuery = $dbh->prepare($customerSql);
        $customerQuery->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $customerQuery->execute();
        $customerRow = $customerQuery->fetch(PDO::FETCH_ASSOC);
        $fullName = $customerRow ? $customerRow['fullName'] : "Unknown Customer";

        // Update payment details in the database
        $updatePaymentSql = "UPDATE bookings SET paymentId = :paymentId WHERE bookingId = :bookingId";
        $updatePaymentQuery = $dbh->prepare($updatePaymentSql);
        $updatePaymentQuery->bindParam(':paymentId', $bookingDetails['paymentId'], PDO::PARAM_INT);
        $updatePaymentQuery->bindParam(':bookingId', $bookingDetails['bookingId'], PDO::PARAM_INT);
        $updatePaymentQuery->execute();
    } else {
        header("Location: index.php"); // Redirect to the home page if booking details are not available
        exit();
    }
} else {
    header("Location: index.php"); // Redirect to the home page if booking details are not available
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload'])) {
        $paymentReceipt = $_FILES['paymentReceipt']['name'];
        $tempPaymentReceipt = $_FILES['paymentReceipt']['tmp_name'];

        // Move the uploaded file to a desired location
        $destination = "/payment" . $paymentReceipt;
        move_uploaded_file($tempPaymentReceipt, $destination);

        // Insert payment details into the database
        $insertPaymentSql = "INSERT INTO payments (bookingId, paymentAmount, paymentReceipt) VALUES (:bookingId, :paymentAmount, :paymentReceipt)";
        $insertPaymentQuery = $dbh->prepare($insertPaymentSql);
        $insertPaymentQuery->bindParam(':bookingId', $bookingDetails['bookingId'], PDO::PARAM_INT);
        $insertPaymentQuery->bindParam(':paymentAmount', $totalPayment, PDO::PARAM_STR);
        $insertPaymentQuery->bindParam(':paymentReceipt', $paymentReceipt, PDO::PARAM_STR);
        $insertPaymentQuery->execute();

        header("Location: receipt.php"); // Redirect to receipt.php after successful payment
        exit();
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Pembayaran Tempahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
</head>

<body>
    <!-- top-header -->
    <?php include('includes/header.php'); ?>
    <!--- /top-header ---->
    <!--- privacy ---->
    <div class="privacy">
        <div class="container">
            <h3 class="tittle">Pembayaran Tempahan</h3>
            <div class="well">
                <h4>Butiran Tempahan</h4>
                <p><strong>Aktiviti:</strong> <?php echo htmlentities($activityName); ?></p>
                <p><strong>Nama Pelanggan:</strong> <?php echo htmlentities($fullName); ?></p>
                <p><strong>Bilangan Peserta:</strong> <?php echo htmlentities($noOfParticipant); ?></p>
                <p><strong>Slot Masa:</strong> <?php echo htmlentities($timeSlot); ?></p>
                <p><strong>Tarikh Tempahan:</strong> <?php echo htmlentities($bookDate); ?></p>
                <p><strong>Komen:</strong> <?php echo htmlentities($comment); ?></p>
                <p><strong>Jumlah Bayaran (RM):</strong> <?php echo htmlentities($totalPayment); ?></p>

                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="paymentReceipt">Sila masukkan bukti pembayaran:</label>
                        <input type="file" name="paymentReceipt" id="paymentReceipt" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="upload" class="btn btn-primary">Hantar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--- /privacy ---->
    <!--- footer-top ---->
    <?php include('includes/footer.php'); ?>
    <!--- /footer-top ---->
    <!--- footer-bottom ---->
    <!--- /footer-bottom ---->
</body>

</html>
