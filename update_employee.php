<?php
// Database connection
session_start();
include 'db_connect.php';

// Fetch employee details to pre-fill the form
if (isset($_POST['update_id'])) {
    // Retrieve employee ID from the form
    $update_id = $_POST['update_id'];

    // Query to fetch employee details based on ID
    $sql_fetch = "SELECT * FROM employee WHERE emp_id='$update_id'";
    $result_fetch = $conn->query($sql_fetch);

    $jobs = array("Manager", "Staff", "Cashier", "Asst. Manager");


    // Check if employee exists
    if ($result_fetch->num_rows == 1) {
        $row = $result_fetch->fetch_assoc();
        // Assign employee details to variables
        $name = $row['name'];
        $username = $row['username'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $job_type = $row['job_type'];
        $branch_id = $row['branch_id'];
    } else {
        // Employee not found
        echo "<div class='alert alert-danger' role='alert'>Employee not found.</div>";
        exit; // Exit script if employee not found
    }
}

// Update employee details in the database
if (isset($_POST['update_employee'])) {
    // Retrieve form data
    $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);

    // Prepare and execute SQL query to update employee details in the database
    $sql_update = "UPDATE employee SET name='$name', username='$username', email='$email', phone_number='$phone_number', job_type='$job_type', branch_id='$branch_id' WHERE emp_id='$update_id'";
    if ($conn->query($sql_update) === TRUE) {
        // Employee updated successfully, redirect to list_all_employees.php
        header('Location: ./landing_pages/updated_successfully.html');
        exit;
    } else {
        // Error occurred while updating employee
        echo "<div class='alert alert-danger' role='alert'>Error updating employee: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Update Employee</h2>
        <form method="post" action="">
            <input type="hidden" name="update_id" value="<?php echo $update_id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" pattern="[789][0-9]{9}" required>
            </div>
            <div class="form-group">
                <label for="job_type">Job Type:</label>
                <select class="form-control" id="job_type" name="job_type" required>
                <?php
                    
                    
                        
                    
                        foreach($jobs as $job):
                            $selected = isset($job_type) && $job == $row['job_type'] ? "selected" : ""; // Check if this option should be selected
                            
                       
                    
                    
                    ?>
                    <option value="<?php echo $job ?>" <?php echo $selected ?>><?php echo $job  ?></option>
                    
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branch_id">Branch ID:</label>
                <input type="text" class="form-control" id="branch_id" name="branch_id" value="<?php echo $branch_id; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_employee">Update Employee</button>
        </form>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>