<?php
session_start();
include 'db_connect.php';

// Check if branch ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to list all branches page if ID is not provided
    header("Location: ./landing_pages/employee_error_page.html");
    exit;
}

// Retrieve branch details from the database based on ID
$id = $_GET['id'];
$sql = "SELECT * FROM branch WHERE branch_id = $id";
$result = $conn->query($sql);

// Check if branch exists
if ($result->num_rows == 0) {
    // Redirect to list all branches page if branch is not found
    header("Location: ./landing_pages/employee_error_page.html");
    exit;
}

// Fetch branch data
$row = $result->fetch_assoc();
$location = $row['location'];
$emp_id = $row['manager_id'];
$phone_number = $row['phone_number'];
$email = $row['email'];

// Handle form submission for updating branch data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_location = $_POST['location'];
    $new_manager_id = $_POST['emp_id'];
    $new_phone_number = $_POST['phone_number'];
    $new_email = $_POST['email'];

    // Update branch data in the database
    $sql_update = "UPDATE branch SET location = '$new_location', manager_id = '$new_manager_id', phone_number = '$new_phone_number', email = '$new_email' WHERE branch_id = $id";

    $sql_update_emp="UPDATE employee SET branch_id=$id WHERE emp_id='$new_manager_id'";
    if ($conn->query($sql_update) === TRUE && $conn->query($sql_update_emp) === TRUE) {
        // Redirect to list all branches page after successful update
        header("Location: ./landing_pages/updated_successfully.html");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Branch</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Update Branch</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id"); ?>">
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required>
            </div>
            <div class="form-group">
                <label for="emp_id">Manager ID:</label>
                <select name="emp_id" id="emp_id" class="form-control select" required>

                    <?php
                    $branches = $conn->query("SELECT * FROM employee where job_type='Manager' or job_type='admin'");
                    while ($row = $branches->fetch_assoc()) :
                        $selected = isset($emp_id) && $emp_id == $row['emp_id'] ? "selected" : ""; // Check if this option should be selected
                    ?>
                        <option value="<?php echo $row['emp_id'] ?>" <?php echo $selected ?>><?php echo $row['emp_id'] . ' | ' . (ucwords($row['name']) . ' | ' . (ucwords($row['username']))) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" pattern="[789][0-9]{9}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Branch</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>