
<?php
// Start session
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit;
}



// Handle deposit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_SESSION['acc'];
    $transaction_type = "Deposit";
    $amount = $_POST['amount'];

    // Insert data into transaction table
    $sql = "INSERT INTO transaction (account_number, transaction_type, amount) VALUES ('$account_number', '$transaction_type', '$amount')";
    if ($conn->query($sql) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Deposit added successfully.</div>";
        header('Location: customer_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error adding deposit: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Deposit</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Deposit</button>
    </form>
</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
