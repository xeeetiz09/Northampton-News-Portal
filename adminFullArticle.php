<?php
// calling admin database to store and execute admins data...
include('adminDB.php');
// getting username and photo with session_start()...
$nameOfUser = $_SESSION["username"];
$userPhoto = $_SESSION["photo"];

//fetching id from previous page...
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
		<!--Box icon css link (Reference: https://www.boxicons.com)-->
		<!-- 
			Boxicons, [n.d.]. High Quality Web Icons. [online] 
			Available at: https://www.https://boxicons.com/ [Accessed: 10 Sept 2022]

			All the icons used in the website was taken from boxicons site.
		 -->
		<link rel = "stylesheet" href = "https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
		<title>Northampton News - Full Article</title>
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
		<!-- top menu -->
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
				<li><a href = "manageCategories.php"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
                <li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading">ARTICLE</h2>
			</section>
			<div class = "article_cont">
		   <?php
		//    selecting specific article with id (primary key)...
				$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`article` WHERE id = '$id'");

				// executing the selected data...
				$statemnt->execute();

				//fetching the executed data to display on website...
				$results = $statemnt->fetch(PDO::FETCH_NUM);
			?>
						
				<div class = "evr_news">
					
				<!-- category section -->
					<p style = "float: left;">Category:&nbsp;<?php echo $results[3]; ?></p>
					<!-- shows name of admin who published/posted the article -->
					<p style = "float: right;">Published By:&nbsp;<?php echo $results[6]; ?></p>

				<div class = "atcDate">

				<!-- shows date of publication -->
					<label>Published On:&nbsp;</label><em><?php echo $results[4]; ?></em>
				</div>
				<!-- title section -->
					<div class = "news_ttl"><?php echo $results[1]; ?></div>

					<!-- news image -->
					<div class = "news_image"><img src = "public/images/articles/
					<?php
					if ($results[5]){

						// if news contains the image, it is shown...
					 echo $results[5]; 
					}
					else{
						// if news does not contain the image, default placeholder image is shown...
						//Image taken from: (Ref: https://www.forming.com/about-us/news)
						echo "placeholder.png";
					}
					?>"
					alt = "News Article Image">
					</div>
					<!-- main content of news -->
				<div class = "news_atcl">
				<?php echo $results[2]; ?>
				</div>
			</div>
		</div>

		<!-- comment section -->
                <h3 style = "margin: 30px; font-size: 30px; font-weight: lighter;">Comments</h3>
		<div class = "all_comments">
		<?php
		// selecting all data from comment table...
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`comment`");
				// executing the selected data...
                $statemnt->execute();

				//initializing the number variable...
				$number = 0;

				// checking if the table rows are more than zero...
				if ($statemnt->rowCount() > 0){

					//fetching the available data in loop...
                while ($comResult = $statemnt->fetch(PDO::FETCH_NUM)){ 
					// for getting specific article...
					if ($comResult[3] == $id){
					?>
			<div class = "comments">
				<!-- if username is clicked, it redirects to page where specific user's comment is shown-->
				<div class = "username"><a href = "adminUserComment.php?name=<?php echo $comResult[1]; ?>"><?php echo $comResult[1]; ?></a>&nbsp;•<em><?php echo $comResult[4]; ?></em></div>
				<!-- comments by user... -->
				<div class = "commentTxt"><?php echo $comResult[2]; ?></div>
			</div>
			
			<?php }
		
		}
	}else{

		// if comment table is empty, prompts the message...
		echo "<div class = 'comments'>No Comments!</div";
	}
			
			?>
		</div>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
