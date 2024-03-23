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
$manager_id = $row['manager_id'];
$phone_number = $row['phone_number'];
$email = $row['email'];

// Handle form submission for updating branch data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_location = $_POST['location'];
    $new_manager_id = $_POST['manager_id'];
    $new_phone_number = $_POST['phone_number'];
    $new_email = $_POST['email'];

    // Update branch data in the database
    $sql_update = "UPDATE branch SET location = '$new_location', manager_id = '$new_manager_id', phone_number = '$new_phone_number', email = '$new_email' WHERE branch_id = $id";
    if ($conn->query($sql_update) === TRUE) {
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
            <label for="manager_id">Manager ID:</label>
            <input type="text" class="form-control" id="manager_id" name="manager_id" value="<?php echo $manager_id; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" pattern="[789][0-9]{9}"  required>
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
