<?php
session_start();
include('includes/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['bookingDetails'])) {
    $bookingDetails = $_SESSION['bookingDetails'];

    if (isset($_GET['bookingId'], $_GET['activityId'], $_GET['customerId'])) {
        $bookingId = $_GET['bookingId'];
        $activityId = $_GET['activityId'];
        $customerId = $_GET['customerId'];

        //to test if bookingId exists or not
        //if (empty($bookingId)) {
        // Redirect or display an error message
        //    echo 'NO BOOKING ID ';
        //    exit();
        //}

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
              
        // Update payment details and status in the bookings
        $updatePaymentSql = "UPDATE bookings SET paymentId = :paymentId, status = CASE WHEN paymentId IS NULL THEN 0 ELSE 1 END WHERE bookingId = :bookingId";
        $updatePaymentQuery = $dbh->prepare($updatePaymentSql);
        $updatePaymentQuery->bindParam(':paymentId', $bookingDetails['paymentId'], PDO::PARAM_INT);
        $updatePaymentQuery->bindParam(':bookingId', $bookingId, PDO::PARAM_INT); // Use the correct $bookingId
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

        // Insert payment details into the payments table
        $insertPaymentSql = "INSERT INTO payments (bookingId, amountPaid, paymentReceipt) VALUES (:bookingId, :amountPaid, :paymentReceipt)";
        $insertPaymentQuery = $dbh->prepare($insertPaymentSql);
        $insertPaymentQuery->bindParam(':bookingId', $bookingId, PDO::PARAM_INT); // Use the correct $bookingId
        $insertPaymentQuery->bindParam(':amountPaid', $totalPayment, PDO::PARAM_STR);
        $insertPaymentQuery->bindParam(':paymentReceipt', $paymentReceipt, PDO::PARAM_STR);
        $insertPaymentQuery->execute();

         // Check if the payment was successfully inserted
         $paymentId = $dbh->lastInsertId(); // Get the inserted payment ID


         if ($paymentId) {
            // Update payment details and status in the bookings
            $updatePaymentSql = "UPDATE bookings SET paymentId = :paymentId, status = CASE WHEN paymentId IS NULL THEN 0 ELSE 1 END WHERE bookingId = :bookingId";
            $updatePaymentQuery = $dbh->prepare($updatePaymentSql);
            $updatePaymentQuery->bindParam(':paymentId', $paymentId, PDO::PARAM_INT);
            $updatePaymentQuery->bindParam(':bookingId', $bookingId, PDO::PARAM_INT); // Use the correct $bookingId
            $updatePaymentQuery->execute();

            echo "<script>
            if (confirm('Bukti bayaran telah dihantar! Adakah anda memerlukan resit?')) {
                window.location.href = 'receipt.php'; // Redirect to receipt.php if user selects 'Yes'
            } else {
                window.location.href = 'book-history.php'; // Redirect to book-history.php if user selects 'No'
            }
            </script>";
        } else {
            echo "Error: Failed to insert payment details.";
        }
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
            <h3 class="title">Pembayaran Tempahan</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <h4>Butiran Tempahan</h4>
                        <h3><strong>Id tempahan: BK -
                                <?php echo htmlentities($bookingId); ?>
                            </strong></h3>
                        <p><strong>Aktiviti:</strong>
                            <?php echo htmlentities($activityName); ?>
                        </p>
                        <p><strong>Nama Pelanggan:</strong>
                            <?php echo htmlentities($fullName); ?>
                        </p>
                        <p><strong>Bilangan Peserta:</strong>
                            <?php echo htmlentities($noOfParticipant); ?>
                        </p>
                        <p><strong>Slot Masa:</strong>
                            <?php echo htmlentities($timeSlot); ?>
                        </p>
                        <p><strong>Tarikh Tempahan:</strong>
                            <?php echo htmlentities($bookDate); ?>
                        </p>
                        <p><strong>Komen:</strong>
                            <?php echo htmlentities($comment); ?>
                        </p>
                        <p><strong>Jumlah Bayaran (RM):</strong>
                            <?php echo htmlentities($totalPayment); ?>
                        </p>




                        <p>
                        <h2> Jumlah deposit: RM

                            <?php echo htmlentities($totalPayment * 0.7); ?>
                        </h2>
                        </p>

                        <p>Pastikan Jumlah yang ingin dibayar (RM) sama dengan jumlah di resit bukti pembayaran.</p>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="well">
                        <h1>Cara Pembayaran</h1>
                        <div class="payment-info">
                            <img src="image/LS-acc-bank.jpeg" alt="Akaun Lambo Sari"
                                style="max-width: 200px; max-height: 200px;">
                            <p><strong>CIMB Bank</strong></p>
                            <p><strong>Nombor Akaun:</strong> 8604048979</p>
                            <p><strong>Penerima:</strong> Lambo Sari Resources</p>
                            <p><strong></strong> Reference: BK -
                                <?php echo htmlentities($bookingId); ?>
                            </p>
                            <p>Sila jelaskan pembayaran ke nombor akaun tertera dengan
                                Reference seperti tertera di atas</p>
                            <p>
                                <bold>Anda dibenarkan untuk menjelaskan Deposit dahulu
                                </bold>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <form method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="paymentReceipt">Jumlah yang ingin dibayar (RM) : </label>
                    <input type="number" name="amountPaid" id="amountPaid" class="form-control" required>
                </div>
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