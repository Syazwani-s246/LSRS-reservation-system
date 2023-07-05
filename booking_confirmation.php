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

        //this is generated after data inserted into bookings table, easy way, after customer clicked "Hantar"
        $bookingId = $dbh->lastInsertId();
        // to check whether last bookingId is correct
        // if ($bookingId) {
        //     echo "Last Inserted Booking ID: " . $bookingId;
        // } else {
        //     echo "Failed to retrieve Last Inserted Booking ID";
        // }


        // Check if the 'totalPayment' key exists before accessing it
        if (isset($bookingDetails['totalPayment'])) {
            $totalPayment = $bookingDetails['totalPayment'];
        } else {
            // Handle the case when 'totalPayment' key is not found
            $totalPayment = 0;
        }

        // unset($_SESSION['bookingDetails']); // Remove booking details from session

        // Create the success message with the payment link
        $paymentLink = 'payment.php?bookingId=' . $bookingId . '&activityId=' . $activityId . '&customerId=' . $customerId;

        $msg = '
        <!-- Confirmation Popup -->
        <div id="confirmationPopup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmationPopupLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmationPopupLabel">Tempahan telah dihantar!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Sila pilih cara pembayaran:</p>
                        <div class="payment-options">
                            <a href="' . $paymentLink . '" class="btn btn-primary">Bayar Sekarang</a>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bayarNantiModal">Bayar Nanti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#confirmationPopup').modal('show'); // Show the confirmation modal when the page is loaded
        });
    </script>


</head>

<body>
    <!-- top-header -->
    <?php include('includes/header.php'); ?>
    <!--- /top-header ---->
    <!--- privacy ---->
    <div class="privacy">
        <div class="container">
            <h3 class="title">Pengesahan tempahan</h3>
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




                <input type="hidden" name="bookingId" value="<?php echo $bookingId; ?>">


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

                <p><strong>Jumlah bayaran (RM):</strong>
                    <?php echo htmlentities($bookingDetails['totalPayment']); ?>
                </p>

                <form method="post">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Hantar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Bayar Nanti Modal -->
    <div class="modal fade" id="bayarNantiModal" tabindex="-1" role="dialog" aria-labelledby="bayarNantiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Bayar Nanti</h4>
                </div>
                <div class="modal-body">
                    <p>Sila jelaskan pembayaran selewatnya 3 hari sebelum tarikh tempahan.</p>
                    <a href="book-history.php" class="btn btn-primary">Kembali ke Senarai Tempahan</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>



    <?php include('includes/footer.php'); ?>
</body>

</html>