<?php

include 'includes/auth.php';
include 'includes/connection.php';

// Get ID from URL
$id = $_GET['id'];

// Delete query
$query = "DELETE FROM tenants WHERE id=$id";
$result = mysqli_query($conn, $query);

if($result)
{
    header("Location: tenants.php");
    exit();
}
else
{
    echo "Failed to delete tenant";
}

?>