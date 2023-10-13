<?php
include('userDB.php');
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
		<title>Northampton News - Register</title>
	</head>
	<body>
		<header>
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
		<!-- top menu -->
		<nav>
			<ul>
				<li><a href = "index.php"><i class='bx bxs-home'></i><span>&ensp;Home</span></a></li>
				<li><a href="#"><i class='bx bxs-category'></i>&ensp;Select Category</a>
				<ul>
					<?php
					// query for selecting all data from category table.
						$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category`");

						// executing the query
						$statemnt->execute();

						//fetching the data
						while ($result = $statemnt->fetch(PDO::FETCH_NUM)){
							//showing data
							echo "<li><a class='articleLink' href='categUsr.php?ctgName=".$result[1]."'>". $result[1]."</a></li>";
						}
						?>
					</ul>
				</li>
				<li><a href = "register.php" id = "sel"><i class='bx bxs-user-check'></i><span>&ensp;Register</span></a></li>
				<li><a href = "login.php"><i class='bx bx-log-in-circle'></i><span>&ensp;Log In</span></a></li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" alt = "Images"/>
		<main>
			<nav>
				<ul>
				<li><a href = "aboutus.php"><i class='bx bx-info-circle' ></i><span>&ensp;About Us</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading"><?php
				// if the user is registered successfully, then it prompts the message...
						if($posted == true){
							echo "Registered Successfully!";
						}
						else{
							echo "REGISTER";
						}
					?></h2>
			</section>
			<!-- form for writing the successfully registered user's data to database.. -->
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
				 <label>Profile Picture (Optional)</label> <input type="file" name="userImage" multiple accept="image/*"> 
				 <!-- for going back to manageAdmins page -->
				<input type="submit" name="submit" value="REGISTER" id ="submit"/>
				</form>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
