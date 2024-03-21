<?php
session_start();
session_destroy();
header("Location: employee_dashboard.php");
exit;

?>