<?php
include('connection.php');

// getting specific admin's id...
$id = $_GET['id'];

// delete query for deleting specific admin's data...
$adminDel = "DELETE FROM `assignment1`.`admin` WHERE id = '$id' ";

if ($connection->query($adminDel)){

    // if the admin's data is deleted successfully, alerts the message...
    echo '<script>window.location.href = "manageAdmins.php?msg=deleted";
    alert("Admin Deleted Successfully!");
    
    </script>';
}

?>
