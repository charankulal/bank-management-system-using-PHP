<?php
session_start();
// Include database connection
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['emp_username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit;
}
if(isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM employee WHERE emp_id = '$delete_id'";
    if ($conn->query($sql_delete) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Branch deleted successfully.</div>";
        header('Location: employee_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting employee: " . $conn->error . "</div>";
    }
}



// Retrieve employee data from the database
$sql = "SELECT * FROM employee where job_type!='admin'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List All Employees</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <div class="container">
        <h2>List All Employees</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Job Type</th>
                    <th>Branch ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each row of employee data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['emp_id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone_number']}</td>";
                    echo "<td>{$row['job_type']}</td>";
                    echo "<td>{$row['branch_id']}</td>";
                    echo "<td class='btn-group'>";
                    echo "<form method='post' action='update_employee.php'>";
                    echo "<input type='hidden' name='update_id' value='" . $row["emp_id"] . "'>";
                    $_SESSION['emp_id'] = $row['emp_id'];
                    echo "<button type='submit' class='btn btn-primary mx-1'>Update</button>";
                    echo "</form>";
                    echo "<form method='post' action='list_all_employees.php'>";
                    echo "<input type='hidden' name='delete_id' value='" . $row["emp_id"] . "'>";
                    echo "<button type='submit' class='btn btn-danger mx-1' >Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>


</body>

</html>

<?php
// Close database connection
$conn->close();
?>