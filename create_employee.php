<?php
// Start session
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['emp_username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $job_type = $_POST['job_type'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $branch_id = $_POST['branch'];

    // Hash the password
    $hashed_password = md5($password);

    // Insert data into employee table
    $sql = "INSERT INTO employee (name, username, password, job_type, email, phone_number, branch_id) VALUES ('$name', '$username', '$hashed_password', '$job_type', '$email', '$phone_number', '$branch_id')";


    if ($conn->query($sql) === TRUE) {

        $sql_fetch = "SELECT emp_id FROM employee WHERE email = '$email'";
        $result = $conn->query($sql_fetch);
        $row = $result->fetch_column();


        if ($job_type == 'Manager') {
            $conn->query("UPDATE branch set manager_id=$row where branch_id='$branch_id'");
        }
        // echo "<div class='alert alert-success' role='alert'>Employee created successfully.</div>";
        header("Location: ./landing_pages/employee_creation_landing.html");
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error creating employee: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Create Employee</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="job_type">Job Type:</label>
                <select class="form-control" id="job_type" name="job_type" required>
                    <option value="">Select Job Type</option>
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                    <option value="Cashier">Cashier</option>
                    <option value="Asst. Manager">Asst. Manager</option>

                </select>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[789][0-9]{9}" required>
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
            <button type="submit" class="btn btn-primary">Create Employee</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>