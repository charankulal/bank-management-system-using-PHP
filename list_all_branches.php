<?php
session_start();
include 'db_connect.php';
// Database connection
// Delete branch
if(isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM branch WHERE branch_id = '$delete_id'";
    if ($conn->query($sql_delete) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Branch deleted successfully.</div>";
        header('Location: employee_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting branch: " . $conn->error . "</div>";
    }
}

// Fetch all branches from the database
$sql = "SELECT * FROM branch";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List All Branches</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>List All Branches</h2>
    <div >
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Branch ID</th>
                    <th>Location</th>
                    <th>Manager ID</th>
                    <th>Contact Information</th>
                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["branch_id"] . "</td>";
                        $_SESSION['branch_id']= $row["branch_id"];
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td>Manager ID: " . $row["manager_id"] . "</td>";
                        echo "<td>Phone: " . $row["phone_number"] . "<br>Email: " . $row["email"] . "</td>";
                        echo "<td class='btn-group'>";
                        // echo "<form method='post' action='update_branch.php'>";
                        // echo "<input type='hidden' name='update_id' value='" . $row["branch_id"] . "'>";
                        // echo "<button type='submit' class='btn btn-primary mx-2'>Update</button>";
                        // echo "</form>";
                        echo "<form method='post' action='list_all_branches.php'> ";
                        echo "<input type='hidden' name='delete_id' value='" . $row["branch_id"] . "'>";
                        echo "<button type='submit' class='btn btn-danger mx-2'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No branches found.</td></tr>";
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
