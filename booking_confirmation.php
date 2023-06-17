<?php
// Connect to the MySQL database
$mysqli = new mysqli("localhost", "root", "admin", "lambosarireservation");

// Get the booking details from the database
$query = "SELECT name, bookDate, timeSlot, noOfParticipant, comment FROM bookings ORDER BY bookingId DESC LIMIT 1";
$result = $mysqli->query($query);
$booking = $result->fetch_assoc();

// Close the MySQL connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Thank you for your booking!</h1>
    <p>Your booking has been confirmed and the following details have been saved:</p>
    <ul>
        <li>Name: <?php echo $booking["name"]; ?></li>
        <li>Date: <?php echo $booking["bookDate"]; ?></li>
        <li>Time: <?php echo $booking["timeSlot"]; ?></li>
        <li>No of Participant: <?php echo $booking["noOfParticipant"]; ?></li>
        <li>Comment: <?php echo $booking["comment"]; ?></li>
       
    </ul>
</body>
</html>






<script>
    function confirmBooking() {
        var fullName = document.getElementById("bookName").value;
        var noOfParticipant = document.getElementById("noOfParticipant").value;
        var bookDate = document.getElementById("datepicker").value;
        var timeSlot = document.querySelector(".time-slot.selected").getAttribute("data-time");
        var grandTotal = "...";
        
        var confirmationMessage = "Please confirm your booking details:\n\n" + 
                                  "Name: " + fullName + "\n" +
                                  "Number of Participants: " + noOfParticipant + "\n" +
                                  "Date: " + bookDate + "\n" +
                                  "Time Slot: " + timeSlot + "\n" +
                                  "Grand Total: " + grandTotal + "\n\n" +
                                  "Are you sure you want to submit the form?";
        return confirm(confirmationMessage);
    }
</script>

<form name="book" method="post" onsubmit="return confirmBooking()">
  <!-- form elements go here -->
  <input type="submit" value="Submit">
</form>