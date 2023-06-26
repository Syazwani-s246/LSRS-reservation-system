<!-- php code -->

<?php
// Database connection
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Insert staff details into the database
    $sql = "INSERT INTO staff (full_name, phone_number, address, role, username, password)
            VALUES ('$full_name', '$phone_number', '$address', '$role', '$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage-staff.php?success=1");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Staff Details</title>
</head>

<body>
    <h2>Add Staff Details</h2>
    <?php
    // Display success message if staff is registered
    if (isset($_GET['success'])) {
        echo '<p style="color: green;">Staff registered successfully!</p>';
    }
    ?>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <label>Address:</label>
        <input type="text" name="address" required><br>

        <label>Role:</label>
        <input type="text" name="role" required><br>

        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <button type="submit" name="submit" class="btn-primary btn">Tambah</button>
                <button type="reset" class="btn-inverse btn">Mula semula</button>
            </div>
        </div>
    </form>
</body>

</html>