<?php

// calling category database to store and execute category data...
include('categoryDB.php');
session_start();

//setting username and photo/user's image to display on profile
$nameOfUser = $_SESSION["username"];
$userPhoto = $_SESSION["photo"];

// getting specific category id...
$id = $_GET['id'];

// if session failed to fetch username, user can't access to any pages...
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
		<script src = "javascript.js"></script>
		<!--Box icon css link (Reference: https://www.boxicons.com)-->
		<!-- 
			Boxicons, [n.d.]. High Quality Web Icons. [online] 
			Available at: https://www.https://boxicons.com/ [Accessed: 10 Sept 2022]

			All the icons used in the website was taken from boxicons site.
		 -->
		<link rel = "stylesheet" href = "https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
		<title>Northampton News - Edit Category</title>
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
                    }else{
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
				<li><a href = "manageAdmins.php"><i class='bx bxs-user'></i><span>&ensp;Admins</span></a></li>
                <li><a href = "adminArticles.php"><i class='bx bxs-news' ></i><span>&ensp;News</span></a></li>
				<li><a href = "manageCategories.php" id = "sel"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
				<li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading"><?php
				// if the category is updated successfully, then it prompts the message...
						if($posted == true){
							echo "Category Updated Successfully!";
						}
						else{
							echo "Edit Category";
						}
					?></h2>
			</section>
			<!-- all the input fields are prefilled with the category data which is clicked for editing... -->
			<!-- form for writing the category data to database.. -->
            <form method = "POST" action="">
                <?php 

				// selecting the specific category data...
                    $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category` WHERE id = '$id'");

					// executing the selected data...
                    $statemnt->execute();

					// fetching the executed data...
                    $results = $statemnt->fetch(PDO::FETCH_NUM);
                    ?>

					<!-- Category name input field -->
                <label>Category Name</label> <input type="text" name="category" value = "<?php echo $results[1] ?>" style = "width: 30%;" required/>
                <?php
				// if category already exists, it prompts a message...
                if ($existedCtgs == true){
                    echo"<p style = 'clear: both; margin-left: 220px; color: red;'>*Category already exists</p>";
                }
				// if category name is invalid, it prompts a message...
				else if ($invalid_category == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Invalid Category Name! (Minimum 3 words required!)</p>";
				}
                ?>
				<!-- submit button -->
				<input type="submit" name="update" value="Update" />
				<!-- link for redirecting into manageCategories page -->
				<label class = "backbtn"><a href = "manageCategories.php"><i class='bx bx-arrow-back'></i>&nbsp;Back</a></label>
				</form>
				
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
