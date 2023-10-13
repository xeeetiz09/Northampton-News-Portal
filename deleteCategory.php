<?php
include('connection.php');

// getting category name...
$name = $_GET['name'];

// delete query for deleting the specific category...
$categoryDel = "DELETE FROM `assignment1`.`category` WHERE category = '$name' ";

// delete query for deleting the news of specific category...
$newsDel = "DELETE FROM `assignment1`.`article` WHERE category = '$name' ";
$connection->query($newsDel);
if ($connection->query($categoryDel)){

    // if category is deleted, alerts the message...
    echo '<script>window.location.href = "manageCategories.php?msg=deleted";
    alert("Category Deleted Successfully!");
    </script>';
}

?>
