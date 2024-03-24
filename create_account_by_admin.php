<?php
// Database connection
include 'db_connect.php';

// Function to generate random 7-digit alphanumeric account number
function generateAccountNumber()
{
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < 7; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $cust_username = mysqli_real_escape_string($conn, $_POST['cust_username']);
    $balance = mysqli_real_escape_string($conn, $_POST['balance']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch']);

    // Generate random 7-digit alphanumeric account number
    $account_number = generateAccountNumber();

    $fetch_cust_id = $conn->query("SELECT customer_id FROM customer where username='$cust_username'");
    $customer_id =  $fetch_cust_id->fetch_column();

    if ($fetch_cust_id->num_rows <= 0) {
        header("Location: ./landing_pages/employee_error_page.html");
        exit;
    }

    $fetch_user = $conn->query("SELECT * FROM account where customer_id='$customer_id'");
    if($fetch_user->num_rows > 0) {
        header("Location: ./landing_pages/account_exists.html");
        exit;
    }



    // Prepare and execute SQL query to insert account details into database
    $sql = "INSERT INTO account (account_number, customer_id, balance, branch_id, status) VALUES ('$account_number', '$customer_id', '$balance', '$branch_id','approved')";
    if ($conn->query($sql) === TRUE) {
        header("Location: employee_dashboard.php");
        // echo "<div class='alert alert-success' role='alert'>Account created successfully with Account Number: $account_number</div>";
    } else {
        header("Location: ./landing_pages/employee_error_page.html");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Bank Account</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Create Bank Account</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="cust_username">Customer Username:</label>
                <input type="text" class="form-control" id="cust_username" name="cust_username" required>
            </div>
            <div class="form-group">
                <label for="balance">Initial Deposit:</label>
                <input type="text" class="form-control" id="balance" name="balance" required>
            </div>
            <div class="form-group">
                <label for="branch">Branch :</label>
                <select name="branch" id="branch" class="form-control select" required>
                    <option value=""></option>
                    <?php
                    $branches = $conn->query("SELECT * FROM branch");

                    while ($row = $branches->fetch_assoc()) :
                    ?>
                        <option value="<?php echo $row['branch_id'] ?>" <?php echo isset($branch_id) && $branch_id == $row['branch_id'] ? "selected" : '' ?>><?php echo $row['branch_id'] . ' | ' . (ucwords($row['location']) . ' | ' . (ucwords($row['email']))) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>