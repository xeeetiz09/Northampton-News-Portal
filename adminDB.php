<?php
include('connection.php');
session_start();
$posted = false;
$password_donot_match = false;
$invalid_usrname = false;
$invalid_name = false;
$exists = false;
$eml_exists = false;
$email_exists = false;
$username_exists = false;
$weak_password = false;

$users_username = false;
$users_email = false;
//selecting all the available rows from admin table...
$statement = $connection->prepare("SELECT * FROM `assignment1`.`admin`");

//executing rows...
$statement->execute();
$adminResult = $statement->rowCount();

//selecting all the available rows from admin table...
$statement2 = $connection->prepare("SELECT * FROM `assignment1`.`user`");
//executing rows...
$statement2->execute();


// for new admins...
if(isset($_POST['submit'])) {
    $full_name = trim($_POST['full_name']);
    $username = strtolower(trim($_POST['username']));
    $email = strtolower(trim($_POST['email']));

    //validating password strength...
    $password = trim($_POST['password']); //removing unwanted spaces from password
    $uppercase = preg_match('@[A-Z]@', $password); // returns whether a match (uppercase letter) was found in a string
    $lowercase = preg_match('@[a-z]@', $password); // returns whether a match (lowercase letter) was found in a string
    $number    = preg_match('@[0-9]@', $password); // returns whether a match (numeric value) was found in a string
    $specialchars = preg_match('@[^\w]@', $password); // returns whether a match (special character) was found in a string
    //.....
    $confirm_password = trim($_POST['confirm_password']);
    // checking if full name is more than 6 words...
    if (strlen($full_name) >= 6){

        // checking if username is smaller than 3 words...
        if (strlen($username) >= 3){

            // fetching data from user table...
            while(($userResult = $statement2->fetch(PDO::FETCH_NUM))){

                // comparing username from database with entered username...
                if($userResult[2] == $username){
                    $users_username = true;
                }
                
                // comparing email from database with entered email...
                else if($userResult[3] == $email){
                    $users_email = true;
                }
            }

            // fetching data from admin table...
            while ($adminResult = $statement->fetch(PDO::FETCH_NUM)){

                // comparing admin's and user's username from database with entered username...
                if ($adminResult[2] == $username || $users_username == true){
                    $exists = true;
                }

                // comparing admin's and user's email from database with entered email...
                else if ($adminResult[3] == $email || $users_email == true){
                    $eml_exists = true;
                }
            }

            // if username exists in the database...
            if ($exists == true){
                $username_exists = true;
            }
            else{

                // if email exists in the database...
                if ($eml_exists == true){
                    $email_exists = true;
                }
                else{

                    // (password validation) if the criteria is not met/password is not strong....
                    if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) < 6) {
                        $weak_password = true;
                    }
                    else{

                        // if password is strong with all the criterias met...
                        if ($password === $confirm_password){
                            
                            // for uploading image in database....
                            $image = $_FILES['adminImage']['name'];

                            //image template name...
                            $tempname = $_FILES['adminImage']['tmp_name'];

                            // for saving image in specified directory
                            $folder = "./public/images/admins/" . $image;

                            // moving uploaded image to specific folder...
                            move_uploaded_file($tempname, $folder);

                            // insert query for inserting data into specific columns....
                            $insert = "INSERT INTO `assignment1`.`admin`(`full_name`, `username`, `email`, `password`, `admin_image`) VALUES ('$full_name', '$username', '$email', sha1('$password'), '$image')";
                            $inserted = $connection->query($insert);
                            if ($inserted){
                                $posted = true;
                            }
                        }
                        else{
                            $password_donot_match = true;
                        }
                    }
                }
            }
        }
        else{
            $invalid_usrname = true;
        }
    }
    else{
        $invalid_name = true;
    }
}



// for existing admins (data update)
if(isset($_POST['update'])){
    $id = $_GET['id'];
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $username = strtolower($username);
    $email = trim($_POST['email']);
    $email = strtolower($email);

    //validating password strength...
    $password = trim($_POST['newpassword']); //removing unwanted spaces from password
    $uppercase = preg_match('@[A-Z]@', $password); // returns whether a match (uppercase letter) was found in a string
    $lowercase = preg_match('@[a-z]@', $password); // returns whether a match (lowercase letter) was found in a string
    $number    = preg_match('@[0-9]@', $password); // returns whether a match (numeric value) was found in a string
    $specialchars = preg_match('@[^\w]@', $password); // returns whether a match (special character) was found in a string
    //.....
    $confirm_password = trim($_POST['confirm_new_password']);
    // checking if full name is smaller than 6 words...
    if (strlen($full_name) >= 6){
         // checking if username is smaller than 3 words...
        if (strlen($username) >= 3){
            $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`admin` WHERE id = '$id'");
            $statemnt->execute();
            $results = $statemnt->fetch(PDO::FETCH_NUM);
             // fetching data from user table...
            while(($userResult = $statement2->fetch(PDO::FETCH_NUM))){
                 // comparing username from database with entered username...
                if($userResult[2] == $username){
                    $users_username = true;
                }
                // comparing email from database with entered email...
                else if($userResult[3] == $email){
                    $users_email = true;
                }
            }

             // fetching data from admin table...
            while ($adminResult = $statement->fetch(PDO::FETCH_NUM)){
                // comparing admin's and user's username from database with entered username...
                if ($adminResult[2] == $username || $users_username == true){
                    $exists = true;
                }
                // comparing admin's and user's email from database with entered email...
                else if ($adminResult[3] == $email || $users_email == true){
                    $eml_exists = true;
                }
            }

            // checking if the username matches with other admins and users but not with the admin whose data is being edited....
            //  so that the admin can still have their username...
            if ($exists == true && $results[2] != $username){
                $username_exists = true;
            }
            else{

                // checking if email exists or not...
                if ($eml_exists == true){
                    $email_exists = true;
                }
                else{
                    // (password validation) if the criteria is not met/password is not strong....
                    if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) < 6) {
                        $weak_password = true;
                    }
                    else{
                        // if password is strong with all the criterias met...
                        if ($password === $confirm_password){

                            // for uploading image in database....
                            $image = $_FILES['adminImage']['name'];

                            //image template name...
                            $tempname = $_FILES['adminImage']['tmp_name'];

                            // for saving image in specified directory
                            $folder = "./public/images/admins/" . $image;

                            // moving uploaded image to specific folder...
                            move_uploaded_file($tempname, $folder);

                            //update query for updating data of specific admin....
                            $update = "UPDATE `assignment1`.`admin` SET `full_name`='$full_name', `username`='$username', `email`='$email', `password`=sha1('$password'), `admin_image`='$image' WHERE id = '$id'";
                            $updated = $connection->query($update);
                            if ($updated){
                                $posted = true;
                            }
                        }
                        else{
                            $password_donot_match = true;
                        }
                    }
                }
            }
        }
        else{
            $invalid_usrname = true;
        }
    }
    else{
        $invalid_name = true;
    }
}



// for logged in admin (data update)
if(isset($_POST['updateme'])){
    $id = $_SESSION["myid"];
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $username = strtolower($username);
    $email = trim($_POST['email']);
    $email = strtolower($email);

    //validating password strength...
    $password = trim($_POST['newpassword']); //removing unwanted spaces from password
    $uppercase = preg_match('@[A-Z]@', $password); // returns whether a match (uppercase letter) was found in a string
    $lowercase = preg_match('@[a-z]@', $password); // returns whether a match (lowercase letter) was found in a string
    $number    = preg_match('@[0-9]@', $password); // returns whether a match (numeric value) was found in a string
    $specialchars = preg_match('@[^\w]@', $password); // returns whether a match (special character) was found in a string
    //.....
    $confirm_password = trim($_POST['confirm_new_password']);
      // checking if full name is smaller than 6 words...
      if (strlen($full_name) >= 6){
        // checking if username is smaller than 3 words...
        if (strlen($username) >= 3){
            // selecting logged in admin's data from admin table...
            $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`admin` WHERE id = '$id'");

            //executing the selected data...
            $statemnt->execute();

            //fetching the executed data...
            $results = $statemnt->fetch(PDO::FETCH_NUM);
            // fetching data from user table...
            while(($userResult = $statement2->fetch(PDO::FETCH_NUM))){
                // comparing username from database with entered username...
                if($userResult[2] == $username){
                    $users_username = true;
                }
                // comparing email from database with entered email...
                else if($userResult[3] == $email){
                    $users_email = true;
                }
            }
              // fetching data from admin table...
            while ($adminResult = $statement->fetch(PDO::FETCH_NUM)){
                 // comparing admin's and user's username from database with entered username...
                if ($adminResult[2] == $username || $users_username == true){
                    $exists = true;
                }

                 // comparing admin's and user's email from database with entered username...
                else if ($adminResult[3] == $email || $users_email == true){
                    $eml_exists = true;
                }
            }
            // checking if the username matches with other admins and users but not with the admin whose data is being edited....
            //  so that the admin can still have their username...
            if ($exists == true && $results[2] != $username){
                $username_exists = true;
            }
            else{
                // checking if email exists or not...
                if ($eml_exists == true){
                    $email_exists = true;
                }
                else{
                      // (password validation) if the criteria is not met/password is not strong....
                    if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) < 6) {
                        $weak_password = true;
                    }
                    else{
                        // if password is strong with all the criterias met...
                        if ($password === $confirm_password){

                            // for uploading image in database....
                            $image = $_FILES['adminImage']['name'];

                            //image template name...
                            $tempname = $_FILES['adminImage']['tmp_name'];

                             // for saving image in specified directory
                            $folder = "./public/images/admins/" . $image;

                            // moving uploaded image to specific folder...
                            move_uploaded_file($tempname, $folder);

                             //update query for updating data of specific admin....
                            $update = "UPDATE `assignment1`.`admin` SET `full_name`='$full_name', `username`='$username', `email`='$email', `password`=sha1('$password'), `admin_image`='$image' WHERE id = '$id'";
                            $updated = $connection->query($update);
                            if ($updated){
                                $posted = true;

                                // after updating logged in admin's credentials, session must be destroyed for logging in again with new credentials...
                                session_destroy();

                                // it shows an alert message and redirects user to login page...
                                echo '<script>
                                setTimeout(function(){alert("Update Successful!")},500);
                                setTimeout(function(){alert("Session Expired!\nPlease log in again!")},1000);
                                setTimeout(function(){window.location.href = "login.php"},1200);
                                </script>';
                                exit();
                            }
                        }
                        else{
                            $password_donot_match = true;
                        }
                    }
                }
            }
        }
        else{
            $invalid_usrname = true;
        }
    }
    else{
        $invalid_name = true;
    }
}

?>