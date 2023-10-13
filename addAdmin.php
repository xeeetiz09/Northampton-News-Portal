<?php

// calling admin database to store and execute admins data...
include('adminDB.php');

// getting username and photo with session_start()...
$nameOfUser = $_SESSION["username"];
$userPhoto = $_SESSION["photo"];


// if session failed to fetch username, user can't access to any pages and redirects to login page...
if (!$nameOfUser){
	header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type = "text/css" href = "styles.css">
		<!--Box icon css link (Reference: https://www.boxicons.com)-->
		<!-- 
			Boxicons, [n.d.]. High Quality Web Icons. [online] 
			Available at: https://www.https://boxicons.com/ [Accessed: 10 Sept 2022]

			All the icons used in the website was taken from boxicons site.
		 -->
		<link rel = "stylesheet" href = "https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
		<title>Northampton News - Add Admin</title>
		<script src = "javascript.js"></script>
	</head>
	<body>
		<header>
		<div class = "userinfo">
			<img src = "./public/images/admins/<?php 

			// checking if the admin's image/picture is available or not in the database...
				if ($userPhoto){
					// if the picture is available, it is shown on heading of website
					echo $userPhoto;
				}

				// if the picture is not available, placeholder image is shown on heading of website
				else{
					echo "character.jpg";
				}
				?>" alt = "User's Profile Picture" class = "userimage">
				<p>
				<?php
				// showing name of logged in user/admin on the heading of page
					echo $nameOfUser;
				?>
				</p>
			</div>
			<section>
				<h1>Northampton News</h1>
				<h3>Global News Distributor</h3>
			</section>
			<!-- Shows current location of user (Reference: https://stackoverflow.com/questions/5398674/get-users-current-location)-->
			<!-- 
				stackoverflow, 2017. Get user's current location. [online]
				Available at: https://stackoverflow.com/questions/5398674/get-users-current-location/ [Accessed 12 Sept 2022]
			 -->
				<?php
                    $getGeoLocation = @unserialize (file_get_contents('http://ip-api.com/php/'));
                	if ($getGeoLocation && $getGeoLocation['status'] == 'success') {
                    	echo "<div style = 'margin-right: 20px;'><i class='bx bx-current-location'></i>&nbsp;".$getGeoLocation['city'].', '.$getGeoLocation['country']."</div>";
                    }
                    else{
                        echo "<div style = 'margin-right: 20px; color: red;'>Check your internet connection!</div>";
                    }
                ?>
		</header>
		<nav>
			<ul>
				<li><a href = "adminIndex.php"><i class='bx bxs-home'></i><span>&ensp;Home</span></a></li>
				<li><a href="#"><i class='bx bxs-category'></i>&ensp;Select Category</a>
					<ul>
					<?php

					// selecting all data from category table.
						$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category`");

						//executing the data...
						$statemnt->execute();
						while ($result = $statemnt->fetch(PDO::FETCH_NUM)){

							// fetching and showing the data...
							echo "<li><a class='articleLink' href='adminCategory.php?ctgName=".$result[1]."'>". $result[1]."</a></li>";
						}
						?>
					</ul>
				</li>
				<li><a href = "adminProfile.php"><i class='bx bxs-user-rectangle'></i><span>&ensp;Profile</span></a></li>
				<li><a href = "logout.php"><i class='bx bx-log-out-circle'></i><span>&ensp;Log Out</span></a></li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" alt = "Images"/>
		<main>
		<nav>
				<ul>
				<li><a href = "manageAdmins.php" id = "sel"><i class='bx bxs-user'></i><span>&ensp;Admins</span></a></li>
                <li><a href = "adminArticles.php"><i class='bx bxs-news' ></i><span>&ensp;News</span></a></li>
				<li><a href = "manageCategories.php"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
                <li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading"><?php

				// if the admin is registered successfully, then it prompts the message...
						if($posted == true){
							echo "Admin Registered Successfully!";
						}
						else{
							echo "Add New Admin";
						}
					?></h2>
			</section>

			<!-- form for writing the successfully registered admin's data to database.. -->
            <form method = "POST" action="" enctype="multipart/form-data">

				<!--full name input field... -->
                <label>Full Name</label> <input style = "width: 40%;" type="text" name = "full_name" required/>
                <?php

				//if the name is invalid (i.e., if length is less than 6 words), it prompts a message...
                if ($invalid_name == true){
                    echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Please enter your full name!</p>";
                }
                ?>

				<!-- username input field... -->
				<label>Username</label> <input type="text" style = "width: 40%;" name = "username" required/>
				<?php

				// if the username is invalid (i.e., if length is less than 3 words), it prompts a message...
				if ($invalid_usrname == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Invalid userame! (Minimum 3 words required!)</p>";
                }

				// if username already exists (i.e., taken by other users or admins)
				else if ($username_exists == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Username already exists!</p>";
				}
				?>

				<!-- email input field -->
                <label>Email (*Required for logging in)</label> <input style = "width: 40%;" type="email" name = "email" required/>
				<?php

				//if email already exists (i.e., taken by other users or admins)
				if ($email_exists == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Email already exists!</p>";
				}
				?>

				<!-- password input field -->
                <label>Password</label> <input style = "width: 40%;" type="password" name = "password" required/>
				<?php

				// if the password do not contain at least one uppercase, lowercase, special character and number, it displays an error.
				if ($weak_password == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Please choose strong password!<br>(Hint: Use combination of at least one uppercase, lowercase, numeric value, special character and password should be minimum of 6 characters)</p>";
				}
				?>

				<!-- confirm password field -->
                <label>Confirm Password</label> <input type="password" style = "width: 40%;" name = "confirm_password" required/>
				<?php

				// if both passwords do not match, it prompts a message.
                if ($password_donot_match == true){
                    echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Passwords do not match. Please try again!</p>";
                }
                ?>
				<!-- Image upload field -->
				 <label>Profile Picture (Optional)</label> <input type = "file" name = "adminImage" multiple accept = "image/*"> 
				<input type="submit" name="submit" value="Submit" id ="submit"/>


				<!-- for going back to manageAdmins page -->
				<label class = "backbtn"><a href = "manageAdmins.php"><i class='bx bx-arrow-back'></i>&nbsp;Back</a></label>
				</form>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
