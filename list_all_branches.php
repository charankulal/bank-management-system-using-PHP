<?php
session_start();
include 'db_connect.php';

// Delete branch
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM branch WHERE branch_id = '$delete_id'";
    if ($conn->query($sql_delete) === TRUE) {
        header('Location: employee_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting branch: " . $conn->error . "</div>";
    }
}

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
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Branch ID</th>
                    <th>Location</th>
                    <th>Manager </th>
                    <th>Contact Information</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM branch";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sql_manager_fetch = "SELECT name FROM employee where emp_id='{$row['manager_id']}'";
                        $result1 = $conn->query($sql_manager_fetch);
                        $row1 = $result1->fetch_column();
                        echo "<tr>";
                        echo "<td>" . $row["branch_id"] . "</td>";
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td>Manager ID: " . $row["manager_id"] . "<br>Name: " . $row1 . "</td>";
                        echo "<td>Phone: " . $row["phone_number"] . "<br>Email: " . $row["email"] . "</td>";
                        echo "<td class='btn-group'>";
                        echo "<form method='post' action='update_branch.php'>";
                        echo "<input type='hidden' name='update_id' value='" . $row["branch_id"] . "'>";
                        echo "<button type='submit' class='btn btn-primary mx-2'>Update</button>";
                        echo "</form>";
                        echo "<form method='post' action='list_all_branches.php'> ";
                        echo "<input type='hidden' name='delete_id' value='" . $row["branch_id"] . "'>";
                        echo "<button type='submit' class='btn btn-danger mx-2'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
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
