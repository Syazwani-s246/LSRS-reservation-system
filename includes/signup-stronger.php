error_reporting(0);
if (isset($_POST['submit'])) {
	$fname = $_POST['fname'];
	$mnumber = $_POST['mobilenumber'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password using bcrypt
	$sql = "INSERT INTO customers (FullName, MobileNumber, EmailId, Password) VALUES (:fname, :mnumber, :email, :password)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':fname', $fname, PDO::PARAM_STR);
	$query->bindParam(':mnumber', $mnumber, PDO::PARAM_STR);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	if ($lastInsertId) {
		$_SESSION['msg'] = "Anda telah berjaya mendaftar! Sila log masuk! ";
		header('location:thankyou.php');
	} else {
		$_SESSION['msg'] = "Maaf.Terdapat ralat. Sila cuba lagi!";
		header('location:thankyou.php');
	}
}
