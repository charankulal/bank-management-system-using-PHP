<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Management System - Statistics</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            height: 200px;
            justify-content: center;
            background-color: #fff; /* Add background color */
            padding: 20px; /* Add padding */
            border-radius: 10px; /* Add border radius */
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .card-body {
            text-align: center; /* Center the content */
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .stats {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4"> Statistics</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #f8d7da;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Branches</h5>
                    <p class="stats">10,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #d4edda;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Accounts</h5>
                    <p class="stats">10,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #cce5ff;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-money-bill-wave"></i> Total Deposits</h5>
                    <p class="stats"> ₹1,000,000</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #fff3cd;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-money-check-alt"></i> Avg Transaction Value</h5>
                    <p class="stats"> ₹1,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #f8f9fa;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Customers</h5>
                    <p class="stats">20,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="background-color: #d1ecf1;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Employees</h5>
                    <p class="stats">20,000</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>
</html>
