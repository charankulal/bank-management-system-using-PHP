<?php
session_start();
include 'db_connect.php';

if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    
    // Redirect to the update branch page with the branch ID in the URL
    header("Location: update_branch_page.php?id=$update_id");
    exit;
} else {
    // If update ID is not set, redirect to the list all branches page
    header("Location: list_all_branches.php");
    exit;
}
?>
