<?php
include('connection.php');

// getting news id...
$id = $_GET['id'];

// delete query for deleting specific news...
$articleDel = "DELETE FROM `assignment1`.`article` WHERE id = '$id' ";

// delete query for deleting comments of specific news...
$comDel = "DELETE FROM `assignment1`.`comment` WHERE newsId = '$id' ";
$connection->query($comDel);

if ($connection->query($articleDel)){

    // if news is deleted, alerts the message...
    echo '<script>alert("Article Deleted Successfully!");
    window.location.href = "adminArticles.php?msg=deleted";
    </script>';
}

?>
