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

// Get customer details from database
$sql = "SELECT c.name, c.email, a.account_number, a.balance, a.branch_id FROM customer c
        INNER JOIN account a ON c.customer_id = a.customer_id
        WHERE c.username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // Output data of the customer
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $email = $row["email"];
    $account_number = $row["account_number"];
    $balance = $row["balance"];
    $branch = $row["branch_id"];

    $branches = $conn->query("SELECT * FROM branch where branch_id='$branch' ");
$rows = mysqli_fetch_array($branches);

} else {
    echo "Customer not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for table */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo $name; ?></h2>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Name</th>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <th scope="row">Account Number</th>
                <td><?php echo $account_number; ?></td>
            </tr>
            <tr>
                <th scope="row">Balance</th>
                <td>₹<?php echo $balance; ?></td>
            </tr>
            <tr>
                <th scope="row"  colspan="2">Branch Details</th>
                
            </tr>
            <tr>
                <th scope="row" >Branch Location</th>
                <td><?php  echo (ucwords($rows['location'])) ; ?></td>
            </tr>
            <tr>
                <th scope="row" >Branch Email</th>
                <td><?php  echo (ucwords($rows['email'])) ; ?></td>
            </tr>
            <tr>
                <th scope="row" >Branch Email</th>
                <td><?php  echo (ucwords($rows['phone_number'])) ; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="container text-center">
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

</body>
</html>


<?php
// Close database connection
$conn->close();
?>
