<?php
// Database connection
session_start();
include 'db_connect.php';

if (!isset($_SESSION['emp_username'])) {
    // If not logged in, redirect to index page
    header("Location: index.php");
    exit();
}

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM account WHERE account_number = '$delete_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Account deleted successfully.</div>";
        header('Location: list_all_accounts.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting account: " . $conn->error . "</div>";
    }
}

// Fetch all accounts from the database
$sql = "SELECT customer.name, customer.email, customer.phone_number, account.account_number, account.date_opened, account.branch_id, account.balance, account.status
FROM account
JOIN customer ON account.customer_id = customer.customer_id;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List All Accounts</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-group {
            display: flex;
        }

        .btn {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>List All Accounts</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Account Number</th>
                        <th>Date Opened</th>
                        <th>Closing Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone_number"] . "</td>";
                            echo "<td>" . $row["account_number"] . "</td>";
                            echo "<td>" . $row["date_opened"] . "</td>";
                            echo "<td>₹" . $row["balance"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td class='btn-group'>";
                            echo "<form method='post' action='update_account_by_employee.php'>";
                            echo "<input type='hidden' name='update_id' value='" . $row["account_number"] . "'>";
                            echo "<button type='submit' class='btn btn-primary'>Update</button>";
                            echo "</form>";
                            echo "<form method='post' action=''>";
                            echo "<input type='hidden' name='delete_id' value='" . $row["account_number"] . "'>";
                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No accounts found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>
