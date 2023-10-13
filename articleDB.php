<?php
include('connection.php');
session_start();
$ctgNotSet = false;
$posted = false;
$invalid_title = false;
$invalid_content = false;

// //setting username and photo/user's image to display on profile
$nameOfUser = $_SESSION["username"];
$userPhoto = $_SESSION["photo"];

// if submit button is pressed...
if(isset($_POST['submit'])) {
    error_reporting(0);
    $category = $_POST['category'];
    $title = trim($_POST['title']);

    // setting title to uppercase...
    $title = strtoupper($title);
    $content = trim($_POST['content']);

    // if the word length of title is more than or equal to 10...
    if (strlen($title)>= 10){

        // if the word length of article content is more than or equal to 30...
        if (strlen($content) >= 30){

            //  if category is set...
            if (isset($category)){

                // for uploading image in database....
                $image = $_FILES['uploadfile']['name'];

                //image template name...
                $tempname = $_FILES['uploadfile']['tmp_name'];

                 // for saving image in specified directory
                $folder = "./public/images/articles/" . $image;

                // moving uploaded image to specific folder...
                move_uploaded_file($tempname, $folder);

                // insert query for inserting data into specific columns....
                $insert = "INSERT INTO `assignment1`.`article`(`title`, `content`, `category`, `image`, `publishedBy`) VALUES ('$title', '$content', '$category', '$image', '$nameOfUser')";
                $inserted = $connection->query($insert);
                if ($inserted){
                    $posted = true;
                }
            }
            else{
                // if category is not set...
                $ctgNotSet = true;
            }
        }
        else{

            // if the news content is invalid (i.e. not more than 30 words)...
            $invalid_content = true;
        }
    }
    else{

        // if the news title is invalid (i.e. not more than 10 words)...        
        $invalid_title = true;
    }
}

if(isset($_POST['update'])) {

    // getting specific news id...
    $id = $_GET['id'];
    error_reporting(0);
    $category = $_POST['category'];
    $title = trim($_POST['title']);

    // setting title to uppercase...
    $title = strtoupper($title);
    $content = trim($_POST['content']);

    // if the word length of title is more than or equal to 10...
    if (strlen($title)>= 10){

        // if the word length of article content is more than or equal to 30...
        if (strlen($content) >= 30){

            //  if category is set...
            if (isset($category)){

                // for uploading image in database....
                $image = $_FILES['uploadfile']['name'];

                //image template name...
                $tempname = $_FILES['uploadfile']['tmp_name'];

                // for saving image in specified directory
                $folder = "./public/images/articles/" . $image;

                // moving uploaded image to specific folder...
                move_uploaded_file($tempname, $folder);

                // update query for updating data into specific columns....
                $update = "UPDATE `assignment1`.`article` SET `title`='$title', `content`='$content', `category`='$category', `image`='$image', `publishedBy`='$nameOfUser' WHERE id = '$id'";
                $updated = $connection->query($update);
                if ($updated){
                    $posted = true;
                }
            }
            else{

                // if category is not set...
                $ctgNotSet = true;
            }
        }
        else{

             // if the news content is invalid (i.e. not more than 30 words)...
            $invalid_content = true;
        }
    }
    else{

        // if the news title is invalid (i.e. not more than 10 words)...        
        $invalid_title = true;
    }
}

?>