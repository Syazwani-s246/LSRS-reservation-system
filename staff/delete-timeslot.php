<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:reservation.php');
}

if (isset($_REQUEST['atid'])) {
    $bid = intval($_GET['atid']);

    $activityTimeId = $_GET['atid']; // get the id from the URL
    $activityId = $_GET['activityId'];

    // delete the timeslot from the database
    $sql = "DELETE FROM `activitytimes` WHERE `activitytimes`.`activityTimeId` = '$activityTimeId'";
    $result = mysqli_query($conn, $sql);

    if ($result) { // if the query was successful
        // set a success message in the session
        $_SESSION['message'] = "Timeslot deleted successfully";
    } else { // if the query was not successful
        // set an error message in the session
        $_SESSION['message'] = "Error deleting timeslot: " . mysqli_error($conn);
    }

    // redirect back to the same page
    header('Location: manage-timeslot.php');

} else { // if the id parameter is not present in the URL
    // set an error message in the session
    $_SESSION['message'] = "No timeslot id provided for deletion";

    // redirect back to the same page
    header('Location: manage-timeslot.php');
}
?>
