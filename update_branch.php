<?php
// Database connection
session_start();
include 'db_connect.php';

// Fetch account details to pre-fill the form
if (isset($_POST['account_number'])) {
    // Retrieve form data
    $account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $balance = mysqli_real_escape_string($conn, $_POST['balance']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);

    // Prepare and execute SQL query to update account details in the database
    $sql = "UPDATE account SET customer_id='$customer_id', balance='$balance', branch_id='$branch_id' WHERE account_number='$account_number'";
    if ($conn->query($sql) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Account updated successfully.</div>";
        header('Location: employee_dashboard.php');
        exit;
    } else {
        // echo "<div class='alert alert-danger' role='alert'>Error updating account: " . $conn->error . "</div>";
    }
}

$account_number = $_SESSION['account_number'];
$sql_fetch = "SELECT * FROM account WHERE account_number='$account_number'";
$result_fetch = $conn->query($sql_fetch);
if ($result_fetch->num_rows == 1) {
    $row = $result_fetch->fetch_assoc();
    $customer_id = $row['customer_id'];
    $balance = $row['balance'];
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
    <title>Update Account</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Update Account</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="account_number">Account Number:</label>
                <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo $account_number; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="customer_id">Customer ID:</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" required>
            </div>
            <div class="form-group">
                <label for="balance">Balance:</label>
                <input type="text" class="form-control" id="balance" name="balance" value="<?php echo $balance; ?>" required>
            </div>
            <div class="form-group">
                <label for="branch_id">Branch ID:</label>
                <input type="text" class="form-control" id="branch_id" name="branch_id" value="<?php echo $branch_id; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>