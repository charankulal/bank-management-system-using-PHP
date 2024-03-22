<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    // If logged in, redirect to dashboard
    header("Location: index.php");
    exit();
}

$sql = "SELECT customer_id  FROM customer WHERE username='" . $_SESSION["username"] . "'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$customerID = $row[0];


$sql_acc = "SELECT *  FROM account WHERE customer_id='$customerID' and status='approved'";
$result_acc = $conn->query($sql_acc);
$row1 = mysqli_fetch_array($result_acc);


$sql = "SELECT account.account_number
FROM account
JOIN customer ON account.customer_id = customer.customer_id;";
$result = $conn->query($sql);
$_SESSION['acc'] = $row1['account_number'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            position: fixed;
            top: 100;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            padding-top: 50px;
            color: #fff;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            color: #fff;
        }

        .sidebar a:hover {
            background-color: #6c757d;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-primary" data-bs-theme="dark">
        <div class="mx-3">
            <img src="assets/img/logo.png" alt="" height="60px" width="60px" />
            <span class="navbar-brand mb-0 h1 mx-3">Your Bank</span>

        </div>
        <div class="mx-3">
            <span class="navbar-brand mb-0 h1 mx-3"><?php echo $_SESSION["name"]; ?></span>
            <!-- <span class="navbar-brand mb-0 h1 mx-3">Limit:</span> -->
            <a class="navbar-brand mb-0 h1 mx-3 text-warning" href="logout.php">Logout</a>

        </div>


    </nav>
    <?php if ($result_acc->num_rows > 0) : ?>
        <div class="sidebar">
            <h3 class="text-center">Dashboard</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('deposit.php')"><i class="fas fa-home"></i> Deposit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('withdraw.php')"><i class="fas fa-user-plus"></i> withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('send_money.php')"><i class="fas fa-list"></i> Send Money</a>
                </li>

            </ul>
        </div>
    <?php else : ?>
        <div class="sidebar">
            <h3 class="text-center">Dashboard</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('customer_create_account.php')"><i class="fas fa-home"></i> Create Account</a>
                </li>

            </ul>
        </div>
    <?php endif; ?>


    <div class="content">
        <!-- Main content goes here -->
        <h2>Welcome <?php echo $_SESSION['name'] ?> </h2>
        <!-- You can add more content here -->
    </div>
    <script>
        function loadPage(pageUrl) {
            $('.content').load(pageUrl);
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>

</html>