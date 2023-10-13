<?php
//calling connection page for connecting database to server.
include('connection.php');
//for fetching information from previous page
session_start();

//setting username to show on profile
$nameOfUser = $_SESSION["username"];

//setting photo/user's image to display on profile
$userPhoto = $_SESSION["photo"];

// if session is not set, then user redirects to login page.
if (!$nameOfUser){
	header("Location:login.php");
}

$number = 0;
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
		<title>Northampton News - Manage Articles</title>
		<script src = "javascript.js"></script>
	</head>
	<body>
		<header>
			<div class = "userinfo">
				<!-- setting image on header-->
			<img src = "./public/images/admins/<?php 
			//checking if the database have user's photo and showing it on the image field
				if ($userPhoto){
					echo $userPhoto;
				}
				// if there is no photo of user, then default placeholder photo is set.
				else{
					echo "character.jpg";
				}
				?>" alt = "User's Profile Picture" class = "userimage">

				<!-- displaying name of logged in user -->
				<p> <?php echo $nameOfUser; ?> </p>
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
		<!-- top menu -->
		<nav>
			<ul>
				<li><a href = "adminIndex.php"><i class='bx bxs-home'></i><span>&ensp;Home</span></a></li>
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
                <h2 id = "heading">ALL ARTICLES</h2>
			</section>
			<!-- link for redirecting admin to add new article page -->
			<p class = "addLink"> <a href = "addArticle.php">Add New Article</a></p>
           <div class = "news_cont">
		   <?php
					// query for selecting all data from article table.
						$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`article`");

						// executing the query
						$statemnt->execute();

						// checking if the table have data or not...
						if($statemnt->rowCount()>0){
							//fetching the data
						while ($result = $statemnt->fetch(PDO::FETCH_NUM)){ 
							$number+=1;
							?>
						<!-- news containers -->
				<div class = "evr_news">

					<!-- news category -->
					<p style = "float: left;">Category:&nbsp;<?php echo $result[3]; ?></p>

					<!-- publisher name -->
					<p style = "float: right;">Published By:&nbsp;<?php echo $result[6]; ?></p>

					<!-- published date -->
				<div class = "atcDate">
					<label>Published On:&nbsp;</label><em><?php echo $result[4]; ?></em>
				</div>

				<!-- news title -->
					<div class = "news_ttl"><?php echo $result[1]; ?></div>

					<!-- news image -->
					<div class = "news_image"><img src = "public/images/articles/
					<?php
					// if news image exists, then it is shown in the image field...
					if ($result[5]){
					 echo $result[5]; 
					}
					// else placeholder image is shown in the field...
					else{
						//Image taken from: (Ref: https://www.forming.com/about-us/news)
						echo "placeholder.png";
					}
					?>"
					alt = "News Article Image">
					</div>
					<!-- news content -->
				<div class = "news_atcl">
				<?php echo $result[2]; ?>
				</div>

				<!-- link for editing and deleting the article... -->
				<div class = "edit_delete"><a href = "editArticle.php?id=<?php echo $result[0]?>" class = "edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href = "deleteArticle.php?id=<?php echo $result[0]?>" class = "delete">Delete</a></div>
			</div>

			<?php } }
			else{
				// if table donot return any data....
				echo "<div style = 'text-align: center;'>Currently, there are no articles!</div>";
			}?>
			<p> <?php if ($number > 1 ){
				echo "Total Articles: ".$number;
			} 
			else if ($number == 1 ){
				echo "Total Article: ".$number;
			}
			?></p>
		</div>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>