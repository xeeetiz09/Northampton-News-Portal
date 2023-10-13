<?php
include('articleDB.php');

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

		<!--Box icon css link (Reference: https://www.boxicons.com)-->
		<!-- 
			Boxicons, [n.d.]. High Quality Web Icons. [online] 
			Available at: https://www.https://boxicons.com/ [Accessed: 10 Sept 2022]

			All the icons used in the website was taken from boxicons site.
		 -->
		<link rel = "stylesheet" href = "https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
		<title>Northampton News - Add Article</title>
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
				<li><a href = "manageAdmins.php"><i class='bx bxs-user'></i><span>&ensp;Admins</span></a></li>
                <li><a href = "adminArticles.php" id = "sel"><i class='bx bxs-news' ></i><span>&ensp;News</span></a></li>
				<li><a href = "manageCategories.php"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
				<li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading"><?php
						if($posted == true){

							// if the article is posted successfully, it prompts a message...
							echo "Article Posted Successfully!";
						}
						else{
							echo "Add New Article";
						}
					?></h2>
			</section>
			<!-- form for writing the news article to database.. -->
            <form method = "POST" action="" enctype="multipart/form-data">
				<!-- Title input field -->
                <label>Title</label> <input type="text" name =  "title" placeholder = "News Title" required/>
				<?php 

				// if the title is invalid (i.e., if length is less than 10 words)
				if ($invalid_title == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Invalid Title (Minimum 10 words required!)</p>";
				}
				?>
				<!-- News content input field... -->
				<label>Content</label> <textarea name="content" rows="15" placeholder = "News Content" required></textarea>
				<?php 
				// if the content/article is invalid (i.e., if length is less than 30 words)
				if ($invalid_content == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Invalid Content (Minimum 30 words required!)</p>";
				}
				?>
				<!-- Category selection field (select box) -->
				<label>Select Category</label><select name = "category" required>
						<?php

						// fetching all data from category table...
						echo "<option disabled selected>Choose</option>";
						$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category`");
						$statemnt->execute();
						while ($result = $statemnt->fetch(PDO::FETCH_NUM)){
							echo "<option value =".$result[1].">". $result[1]."</option>";
						}
						?>
					

				</select>
				<?php 

				// if category is not set, prompts an error message...
				if ($ctgNotSet == true){
					echo "<p style = 'clear: both; margin-left: 220px; color: red;'>*Please choose a category</p>";
				}
				?>
				<!-- image upload field -->
                <label>Image (Optional)</label> <input type = "file" name = "uploadfile" value="" multiple accept = "image/*"> 

				<!-- submit button -->
				<input type="submit" name="submit" value="Post" />

				<!-- button for redirecting to adminArticles page -->
				<label class = "backbtn"><a href = "adminArticles.php"><i class='bx bx-arrow-back'></i>&nbsp;Back</a></label>
				</form>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
