<?php
// Database connection
session_start();
include 'db_connect.php';


// Initialize variables
$location = $manager_id = $phone_number = $email = "";

if (isset($_POST['update_id'])) {
    $location = $_POST['location'];
    $manager_id = $_POST['manager_id'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $update_id = $_POST['update_id'];

    $sql_update = "UPDATE branch SET location='$location', manager_id='$manager_id', phone_number='$phone_number', email='$email' WHERE branch_id='$update_id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Branch updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating branch: " . $conn->error . "</div>";
    }
}

// Retrieve branch details based on branch ID

    $update_id = $_SESSION['branch_id'];
    $sql_select = "SELECT * FROM branch WHERE branch_id = '$update_id'";
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $location = $row["location"];
        $manager_id = $row["manager_id"];
        $phone_number = $row["phone_number"];
        $email = $row["email"];
    } else {
        echo "Branch not found.";
    }


// Update branch details in the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Branch</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Update Branch</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required>
        </div>
        <div class="form-group">
            <label for="manager_id">Manager ID:</label>
            <input type="text" class="form-control" id="manager_id" name="manager_id" value="<?php echo $manager_id; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Branch</button>
    </form>
</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
