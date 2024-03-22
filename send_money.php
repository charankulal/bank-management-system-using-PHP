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



// Handle send money form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_POST['account_number'];
    $amount = $_POST['amount'];

    $sql_check = "SELECT account_number
FROM account Where  account_number='$account_number'";
    $result = $conn->query($sql_check);
    $acc = $result->fetch_column();
    if ($acc) {
        // Insert data into transaction table
        $sql = "INSERT INTO transaction (account_number, transaction_type, amount) VALUES ('$account_number', 'Transfer', '$amount')";
        if ($conn->query($sql) === TRUE) {
            // echo "<div class='alert alert-success' role='alert'>Money sent successfully.</div>";

        } else {
            echo "<div class='alert alert-danger' role='alert'>Error sending money: " . $conn->error . "</div>";
        }
    } else {


        echo '<script type ="text/JavaScript">';
        echo 'alert("Recipient account does not exist")';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Money</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Send Money</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="account_number">Recipient's Account Number:</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" min="0" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="container text-center">
            <button type="submit" class="btn btn-primary">Send Money</button>
            <a href="./customer_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>