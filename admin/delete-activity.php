

<?php
session_start();

include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:reservation.php');
} else {
	if (isset($_GET['activityId'])) {
		$activityId = intval($_GET['activityId']);
		$sql = "DELETE FROM activity WHERE activityId=:activityId";
		$query = $dbh->prepare($sql);
		$query->bindParam(':activityId', $activityId, PDO::PARAM_INT);
		$query->execute();
		echo "<script>
			alert('Aktiviti berjaya dipadam');
			window.location.href='manage-activity.php';
		  </script>";
	}
}
?>



