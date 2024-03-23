<?php
// Database connection
session_start();
include 'db_connect.php';



// Insert branch data into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $manager_id = $_POST['emp_id'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $sql = "INSERT INTO branch (location, manager_id, phone_number, email) VALUES ('$location', '$manager_id', '$phone_number', '$email')";
    if ($conn->query($sql) === TRUE) {
        // echo "<div class='alert alert-success' role='alert'>Branch created successfully.</div>";
        header('Location: employee_dashboard.php');
        exit;
    } else {
        // echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Branch</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Create Branch</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="manager_id">Manager ID:</label>
            <select name="emp_id" id="emp_id" class="form-control select" required>
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT * FROM employee where job_type='Manager' or job_type='admin'");
            
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['emp_id'] ?>" <?php echo isset($emp_id) && $emp_id == $row['emp_id'] ? "selected":'' ?>><?php echo $row['emp_id']. ' | '.(ucwords($row['name']). ' | '.(ucwords($row['username']))) ?></option>
                <?php endwhile; ?>
              </select>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[789][0-9]{9}" required>

        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Branch</button>
    </form>
</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
