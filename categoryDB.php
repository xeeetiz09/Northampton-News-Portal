<?php

//calling connection page for connecting database to server.
include('connection.php');

$posted = false;
$exists = false;
$existedCtgs = false;
$invalid_category = false;

$statement = $connection->prepare("SELECT * FROM `assignment1`.`category`");
//executing rows...
$statement->execute();

// for new category name...
// if submit button is pressed...
if(isset($_POST['submit'])) {
    $category = trim($_POST['category']);

    // checking if category name is more than or equal to 3 words...
    if (strlen($category) >= 3){
        while ($result = $statement->fetch(PDO::FETCH_NUM)){

            //  checking if category already exists in database...
            if ($result[1] == $category){
                $exists = true;
            }
        }
        
        if ($exists == true){
            $existedCtgs = true;
        }
        else{

            //  if the category input field is not empty...
            if(!empty($category)){

                // insert query for inserting category name in category field...
                $insert = "INSERT INTO `assignment1`.`category`(`category`) VALUES ('$category')";
                $inserted = $connection->query($insert);
                if ($inserted){
                    $posted = true;
                }
            }
        }
    }
    else{

        // if the category name is invalid (i.e. not more than 3 words)...
        $invalid_category = true;
    }
}


// for updating existing category...
if(isset($_POST['update'])) {

    // getting specific category id
    $id = $_GET['id'];
    $category = trim($_POST['category']);

    // selecting specific category...
    $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category` WHERE id = '$id'");

    // executing the selected data...
    $statemnt->execute();

    // fetching the selected data...
    $results = $statemnt->fetch(PDO::FETCH_NUM);

    // checking if category name is more than or equal to 3 words...
    if (strlen($category) >= 3){

        // checking if category name is more than or equal to 3 words...
        while ($result = $statement->fetch(PDO::FETCH_NUM)){
            if ($result[1] == $category){
                $exists = true;
            }
        }
        
        // checking if the selected category (for update) does not match with existing category...
        if ($exists == true && $results[1] != $category){
            $existedCtgs = true;
        }
        else{

            //  if the category input field is not empty...
            if(!empty($category)){

                // update query for updating the category...
                $update = "UPDATE `assignment1`.`category` SET `category`='$category' WHERE id = '$id'";
                $updated = $connection->query($update);
                if ($updated){
                    $posted = true;
                }
            }
        }
    }
    else{

        // if the category name is invalid (i.e. not more than 3 words)...
        $invalid_category = true;
    }
}



?>