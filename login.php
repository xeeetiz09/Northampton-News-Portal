<?php
include('connection.php');
session_start();
$empty_cred = false;
$incorrect_cred = false;

// if submit button is pressed...
if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // if the email and password input fields are not empty...
    if (!empty($email) && !empty($password)){
        // selecting all data from admin table...
        $statement = $connection->prepare("SELECT * FROM `assignment1`.`admin`");
        //executing selected data...
        $statement->execute();

        // counting rows
        $adminResult = $statement->rowCount();
        if ($adminResult){

            // checking if data is available in admin table...
            if ($adminResult > 0){
                // fetching the executed admin data...
                while($admResl = $statement->fetch(PDO::FETCH_NUM)){
                    // checking if input email and password matches the credentials with database (admin only)...
                    if ($admResl[3] === $email && $admResl[4] === sha1($password)){

                        // setting session for admin's id...
                        $_SESSION["myid"] = $admResl[0];

                        // setting session for admin's username...
                        $_SESSION["unqusrname"] = $admResl[2];

                        // setting session for admin's fullname...
                        $_SESSION["username"] = $admResl[1];

                        // setting session for admin's photo...
                        $_SESSION["photo"] = $admResl[6];

                        // redirecting user to admin index page...
                        header("Location: adminIndex.php");
                        die;
                    }
                    else{

                        //  if the entered credentials donot match the database...
                        $incorrect_cred = true;
                    }
                }
            }
        }

        // selecting all data from user table...
        $statement2 = $connection->prepare("SELECT * FROM `assignment1`.`user`");
        //executing selected data...
        $statement2->execute();
        // counting rows
        $userResult = $statement2->rowCount();

        // checking if data is available in admin table...
        if ($userResult){

            // checking if data is available in user table...
            if ($userResult > 0){

                // fetching the executed user data...
                while($userResl = $statement2->fetch(PDO::FETCH_NUM)){
                    // checking if input email and password matches the credentials with database (user only)...
                    if ($userResl[3] === $email && $userResl[4] === sha1($password)){
                        
                        // setting session for user's id...
                        $_SESSION["userId"] = $userResl[0];

                        // setting session for user's username...
                        $_SESSION["user_usrname"] = $userResl[2];

                        // setting session for user's fullname...
                        $_SESSION["usr_fullname"] = $userResl[1];

                        // setting session for user's photo...
                        $_SESSION["usr_photo"] = $userResl[6];

                        // redirecting user to user index page...
                        header("Location: userIndex.php");
                        die;
                    }
                    else{

                        //  if the entered credentials donot match the database...
                        $incorrect_cred = true;
                    }
                }
            }
        }

    }
    else{

        // if the input fields are empty...
        $empty_cred = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Northampton News - Log In</title>
    <link rel = "stylesheet" type = "text/css" href = "styles.css">
    <script src = "javascript.js"></script>
</head>
<body>
<div class = "login_portal_container">
    <form method = "POST" class = "login_portal"action="" enctype="multipart/form-data">
        <legend>Northampton News - Login</legend>
        <?php
        // if entered credentials are incorrect, prompts the message...
            if ($incorrect_cred == true){
                echo "<p style = 'color: red;'>Incorrect Email or Password!</p>";
            }

        // if the input fields are empty, prompts the message...
            else if($empty_cred == true){
                echo "<p style = 'color: red;'>Email and password is required!</p>";
            }
        ?>
        <!-- email input field -->
        <label class = "lbl">Email</label> <input type = "email" name = "email" class = "inp">

        <!-- password input field -->
        <label class = "lbl">Password</label> <input type = "password" name = "password" class = "inp">

        <!-- submit button -->
        <input type = "submit" name = "submit" value = "LOG IN" id = "btn">

        <!-- link for redirecting to register page -->
        <p>Don't have an account?&nbsp;<a href = "register.php">Register</a></p>

        <!-- link for redirecting to home page -->
        <p id="homebton"><a href = "index.php">Go to home page</a></p>
    </form>
</div>
        <footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>
</body>
</html>