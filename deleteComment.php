<?php
include('connection.php');
// getting comment id...
$id = $_GET['id'];

// delete query for deleting specific comment
$commentDel = "DELETE FROM `assignment1`.`comment` WHERE id = '$id' ";

// if comment is deleted successfully, prompts the message...
if ($connection->query($commentDel)){
    echo '<script>window.location.href = "manageComments.php?msg=deleted";
    alert("Comment Deleted Successfully!");
    </script>';
}

?>
