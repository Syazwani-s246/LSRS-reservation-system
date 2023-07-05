<?php
include('includes/config.php');

if (isset($_GET['paymentId'])) {
    $paymentId = $_GET['paymentId'];

    // Fetch the payment receipt file path from the database based on paymentId
    $sql = "SELECT paymentReceipt FROM payments WHERE paymentId = :paymentId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':paymentId', $paymentId, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $paymentReceipt = $row['paymentReceipt'];

        // Display the payment receipt image
        $paymentFilePath = "../payment/" . $paymentReceipt;

        echo '<img src="' . $paymentFilePath . '" alt="Payment Receipt" />';
    } else {
        echo 'Invalid payment ID.';
    }
} else {
    echo 'Payment ID not provided.';
}
?>
