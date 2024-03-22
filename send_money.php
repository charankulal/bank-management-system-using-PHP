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


// Handle send money form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_SESSION['acc'];
    $amount = $_POST['amount'];

    $sql_check = "SELECT account_number
FROM account Where  account_number='$account_number'";
    $result = $conn->query($sql_check);
    $acc = $result->fetch_column();
    if ($acc) {
        if ($amount <= $row1['balance']) {

            // Insert data into transaction table
            $sql = "INSERT INTO transaction (account_number, transaction_type, amount) VALUES ('$account_number', 'Transfer', '$amount')";
            if ($conn->query($sql) === TRUE) {
                header("Location: customer_dashboard.php");
                exit;
                // echo "<div class='alert alert-success' role='alert'>Money sent successfully.</div>";

            } else {
                echo "<div class='alert alert-danger' role='alert'>Error sending money: " . $conn->error . "</div>";
            }
        } else {

            header("Location: insufficient_balance.html");

            exit;
        }
    } else {
        header("Location: account_doesnot_exist.html");
        exit;
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
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

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
        <h2>Send Money</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="account_number">Recipient's Account Number:</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" min="0" step="1" class="form-control" id="amount" name="amount" required>
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