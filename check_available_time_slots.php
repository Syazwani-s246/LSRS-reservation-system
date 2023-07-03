<?php
// fetch_available_slots.php

// Include the necessary database connection or configuration file
session_start();
include('includes/config.php');
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookDate'])) {
    $selectedDate = $_POST['bookDate'];

    // Query to fetch the available time slots for the selected date
    $sql = "SELECT timeSlot FROM bookings WHERE bookDate = :selectedDate";
    $query = $dbh->prepare($sql);
    $query->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_COLUMN);

    $unavailableTimeSlots = array(); // Store unavailable time slots here

    if ($query->rowCount() > 0) {
        // Loop through the query results and add the unavailable time slots to the array
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $unavailableTimeSlots[] = $row['timeSlot'];
        }
    }

    // Send the response as JSON
    echo json_encode(
        array(
            'error' => null,
            'unavailableTimeSlots' => $unavailableTimeSlots
        )
    );
} else {
    echo json_encode(
        array(
            'error' => 'Invalid request.'
        )
    );
}
?>
