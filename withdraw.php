
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

$sql = "SELECT customer_id  FROM customer WHERE username='" . $_SESSION["username"] . "'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$customerID = $row[0];


$sql_acc = "SELECT *  FROM account WHERE customer_id='$customerID' and status='approved'";
$result_acc = $conn->query($sql_acc);
$row1 = $result_acc->fetch_assoc();

// Handle deposit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_SESSION['acc'];
    $transaction_type = "Withdraw";
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
    <title>Withdraw</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <script>
        function validateAmount() {
            var amountInput = document.getElementById('amount');
            var availableBalance = <?php echo $row1['balance']; ?>; // Get available balance from PHP variable
            var amount = parseFloat(amountInput.value);
            if (amount > availableBalance) {
                alert('Amount cannot exceed available balance.');
                amountInput.value = ''; // Clear the input field
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Withdraw</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateAmount();">
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Withdraw</button>
    </form>
</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
