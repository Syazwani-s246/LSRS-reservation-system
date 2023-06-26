<?php
session_start();
include('includes/config.php');

if (isset($_SESSION['bookingDetails'])) {
    $bookingDetails = $_SESSION['bookingDetails'];

    if (isset($_POST['submit'])) {
        // Retrieve booking details from session
        $activityId = $bookingDetails['activityId'];
        $customerId = $bookingDetails['customerId'];
        $noOfParticipant = $bookingDetails['noOfParticipant'];
        $timeSlot = $bookingDetails['timeSlot'];
        $bookDate = $bookingDetails['bookDate'];
        $comment = $bookingDetails['comment'];
        $totalPayment = $bookingDetails['totalPayment'];

        // Retrieve activity price from activity table
        $activityPriceSql = "SELECT activityPrice FROM activity WHERE activityId = :activityId";
        $activityPriceQuery = $dbh->prepare($activityPriceSql);
        $activityPriceQuery->bindParam(':activityId', $activityId, PDO::PARAM_INT);
        $activityPriceQuery->execute();
        $activityPriceRow = $activityPriceQuery->fetch(PDO::FETCH_ASSOC);
        if ($activityPriceRow) {
            $activityPrice = $activityPriceRow['activityPrice'];
        } else {
            // Handle the case when activity price is not found
            $activityPrice = 0;
        }

        // Calculate total payment
        $totalPayment = $noOfParticipant * $activityPrice;

        // Check if the 'totalPayment' key exists in the $bookingDetails array before accessing it
        if (isset($bookingDetails['totalPayment'])) {
            // If it exists, update the value
            $bookingDetails['totalPayment'] = $totalPayment;
        } else {
            // If it doesn't exist, add it to the array
            $bookingDetails['totalPayment'] = $totalPayment;
        }


        // Insert booking details into the database
        $sql = "INSERT INTO bookings (activityId, customerId, noOfParticipant, timeSlot, bookDate, comment,totalPayment)
                VALUES (:activityId, :customerId, :noOfParticipant, :timeSlot, :bookDate, :comment, :totalPayment)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
        $query->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $query->bindParam(':noOfParticipant', $noOfParticipant, PDO::PARAM_INT);
        $query->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
        $query->bindParam(':bookDate', $bookDate, PDO::PARAM_STR);
        $query->bindParam(':comment', $comment, PDO::PARAM_STR);
        $query->bindParam(':totalPayment', $totalPayment, PDO::PARAM_STR);
        $query->execute();

        // Check if the 'totalPayment' key exists before accessing it
        if (isset($bookingDetails['totalPayment'])) {
            $totalPayment = $bookingDetails['totalPayment'];
        } else {
            // Handle the case when 'totalPayment' key is not found
            $totalPayment = 0;
        }

        // unset($_SESSION['bookingDetails']); // Remove booking details from session

        // Create the success message with the payment link
        // $msg = 'Tempahan berjaya dihantar, Sila tekan butang <a href="payment.php" class="btn btn-primary">Bayar</a> untuk masukkan slip pembayaran.';
        $msg = 'Tempahan berjaya dihantar, Sila tekan butang <a href="payment.php?activityId=' . $activityId . '&customerId=' . $customerId . '" class="btn btn-primary">Bayar</a> untuk masukkan slip pembayaran.';

    }
} else {
    header("Location: index.php"); // Redirect to the home page if booking details are not available
    exit();
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Pengesahan tempahan</title>
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
            <h3 class="tittle">Pengesahan tempahan</h3>
            <?php if (isset($msg)) { ?>
                <div class="succWrap"><strong>BERJAYA</strong>:
                    <!-- Display the message with the payment link -->
                    <div>
                        <?php echo $msg; ?>
                    </div>
                </div>
            <?php } ?>
            <div class="well">
                <h4>Maklumat tempahan</h4>
                <?php


                // Check if activityId and customerId are set
                $activityId = $_SESSION['activityId'];
                $customerId = $_SESSION['customerId'];
                if (isset($_SESSION['activityId']) && isset($_SESSION['customerId'])) {
                    // Retrieve activity name
                    $activitySql = "SELECT activityName FROM activity WHERE activityId = :activityId";
                    $activityQuery = $dbh->prepare($activitySql);
                    $activityQuery->bindParam(':activityId', $activityId, PDO::PARAM_INT);
                    $activityQuery->execute();
                    $activityRow = $activityQuery->fetch(PDO::FETCH_ASSOC);
                    if ($activityRow) {
                        $activityName = $activityRow['activityName'];
                    } else {
                        // Handle the case when activity is not found
                        $activityName = "Unknown Activity";
                    }

                    // Retrieve customer full name
                    $customerSql = "SELECT fullName FROM customers WHERE id = :customerId";
                    $customerQuery = $dbh->prepare($customerSql);
                    $customerQuery->bindParam(':customerId', $customerId, PDO::PARAM_INT);
                    $customerQuery->execute();
                    $customerRow = $customerQuery->fetch(PDO::FETCH_ASSOC);
                    if ($customerRow) {
                        $fullName = $customerRow['fullName'];
                    } else {
                        // Handle the case when customer is not found
                        $fullName = "Unknown Customer";
                    }
                } else {
                    // Set default values when activityId and customerId are not set
                    $activityName = "Unknown Activity";
                    $fullName = "Unknown Customer";
                }
                ?>


                <!-- Hidden fields to store activityId and customerId -->
                <input type="hidden" name="activityId" value="<?php echo $activityId; ?>">
                <input type="hidden" name="customerId" value="<?php echo $customerId; ?>">


                <p><strong>Aktiviti :</strong>
                    <?php echo htmlentities($activityName); ?>
                </p>
                <p><strong>Nama pelanggan:</strong>
                    <?php echo htmlentities($fullName); ?>
                </p>
                <p><strong>Bilangan peserta:</strong>
                    <?php echo htmlentities($bookingDetails['noOfParticipant']); ?>
                </p>
                <p><strong>Slot masa:</strong>
                    <?php echo htmlentities($bookingDetails['timeSlot']); ?>
                </p>
                <p><strong>Tarikh tempahan:</strong>
                    <?php echo htmlentities($bookingDetails['bookDate']); ?>
                </p>
                <p><strong>Komen:</strong>
                    <?php echo htmlentities($bookingDetails['comment']); ?>
                </p>

                <!-- Undefined array key "totalPayment" in C:\xampp\htdocs\SistemTempahanLamboSari3.0\booking_confirmation.php on line 175 -->
                <p><strong>Jumlah bayaran (RM):</strong>
                    <?php echo htmlentities($bookingDetails['totalPayment']); ?>
                </p>
                
                <form method="post">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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