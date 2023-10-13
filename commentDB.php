<?php
include('connection.php');
session_start();

// getting username of logged in user...
$nameOfUser = $_SESSION["usr_fullname"];
$invalid_commentText = false;

// if submit (post) button is pressed...
if(isset($_POST['post'])) {
    $commentText = trim($_POST['commentText']);
    $newsId = $_POST['news_id'];

    // if commentText field is not empty...
    if(!empty($commentText)){

        // insert query for inserting comment data in respective column...
        $insert = "INSERT INTO `assignment1`.`comment`(`full_name`, `commentText`, `newsId`) VALUES ('$nameOfUser', '$commentText', '$newsId')";
        $inserted = $connection->query($insert);
        if ($inserted){

            // if the comment is posted successfully, prompts the message...
            echo '<script>alert("Comment Posted Successfully!")</script>';
        }
    }
}

?>