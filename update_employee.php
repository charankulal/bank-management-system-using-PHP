<?php
// Database connection
session_start();
include 'db_connect.php';

$emp_id = $_SESSION['emp_id'];
// Fetch account details to pre-fill the form
if (isset($_POST['username'])) {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);

    // Prepare and execute SQL query to update account details in the database
    $sql = "UPDATE employee SET name='$name', username='$username',email='$email', phone_number='$phone_number', job_type='$job_type', branch_id='$branch_id'  WHERE emp_id='$emp_id'";
    if ($conn->query($sql) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Account updated successfully.</div>";
        header('Location: employee_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating account: " . $conn->error . "</div>";
    }
}

$emp_id = $_SESSION['emp_id'];
$sql_fetch = "SELECT * FROM employee WHERE emp_id='$emp_id'";
$result_fetch = $conn->query($sql_fetch);
if ($result_fetch->num_rows == 1) {
    $row = $result_fetch->fetch_assoc();
    $name = $row["name"];
    $username = $row["username"];
    $email = $row["email"];
    $phone_number = $row["phone_number"];
    $job_type = $row["job_type"];
    $branch_id = $row['branch_id'];
} else {
    // echo "<div class='alert alert-danger' role='alert'>Account not found.</div>";
    exit; // Exit script if account not found
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Update Employee</h2>
        <form method="post" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" required>
        </div>
        <div class="form-group">
            <label for="job_type">Job Type:</label>
            <input type="text" class="form-control" id="job_type" name="job_type" value="<?php echo $job_type; ?>" required>
        </div>
        <div class="form-group">
            <label for="branch_id">Branch ID:</label>
            <input type="text" class="form-control" id="branch_id" name="branch_id" value="<?php echo $branch_id; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>