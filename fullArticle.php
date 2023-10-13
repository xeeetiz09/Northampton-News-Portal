<?php
include('commentDB.php');

//setting username to show on profile
$nameOfUser = $_SESSION["usr_fullname"];

//setting photo/user's image to display on profile
$userPhoto = $_SESSION["usr_photo"];

//getting specific article id...
$id = $_GET['id'];

// if session is not set, then user redirects to login page...
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
	</head>
	<body>
		<header>
		<div class = "userinfo">
			<!-- setting image on header-->
			<img src = "./public/images/users/<?php 
			//checking if the database have user's photo and showing it on the image field
				if ($userPhoto){
					echo $userPhoto;
				}
				else{
					// if there is no photo of user, then default placeholder photo is set.
					echo "character.jpg";
				}
				?>" alt = "User's Profile Picture" class = "userimage">
				<p>
					<!-- displaying name of logged in user -->
				<?php
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
		<!-- top menu -->
		<nav>
			<ul>
				<li><a href = "userIndex.php"><i class='bx bxs-home'></i><span>&ensp;Home</span></a></li>
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
							echo "<li><a class='articleLink' href='category.php?ctgName=".$result[1]."'>". $result[1]."</a></li>";
						}
						?>
					</ul>
				</li>
				<li><a href = "userProfile.php"><i class='bx bxs-user-rectangle'></i><span>&ensp;Profile</span></a></li>
				<li><a href = "logout.php"><i class='bx bx-log-out-circle'></i><span>&ensp;Log Out</span></a></li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" alt = "Images"/>
		<main>
			<nav>
				<ul>
                <li><a href = "userComment.php"><i class='bx bxs-comment-dots'></i><span>&ensp;Comments</span></a></li>
				<li><a href = "userAboutUs.php"><i class='bx bx-info-circle' ></i><span>&ensp;About Us</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading">ARTICLE</h2>
			</section>
			<div class = "article_cont">
		   <?php
		   		// selecting specific article data...
				$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`article` WHERE id = '$id'");
				// executing the selected data...
				$statemnt->execute();

				// fetching the executed data...
				$results = $statemnt->fetch(PDO::FETCH_NUM);
			?>
						
				<div class = "evr_news">
					<!-- showing category -->
					<p style = "float: left;">Category:&nbsp;<?php echo $results[3]; ?></p>
					<!-- showing publisher name -->
					<p style = "float: right;">Published By:&nbsp;<?php echo $results[6]; ?></p>
				<div class = "atcDate">
					<!-- showing published date -->
					<label>Published On:&nbsp;</label><em><?php echo $results[4]; ?></em>
				</div>
				<!-- showing news title -->
					<div class = "news_ttl"><?php echo $results[1]; ?></div>
					<!-- showing news title (if available) else showing default placeholder image -->
					<div class = "news_image"><img src = "public/images/articles/
					<?php
					if ($results[5]){
					 echo $results[5]; 
					}
					else{
						//Image taken from: (Ref: https://www.forming.com/about-us/news)
						echo "placeholder.png";
					}
					?>"
					alt = "News Article Image">
					</div>
				<article class = "news_atcl">
					<!-- showing news content -->
				<?php echo $results[2]; ?>
				</article>
			</div>
			<!-- form for writing the comment done by user to database.. -->
			<form method = "POST" class = "comment_form">
				<!-- comment input field -->
				<label>Comment</label> <textarea name="commentText" placeholder = "Post a comment here..." rows="5" required></textarea>

				<!-- for news id -->
				<input type = "number" value = "<?php echo $id ?>" name = "news_id" style = "display: none;">
				<!-- submit button -->
				<input type = "submit" name = "post" value = "Post">
			</form>
		</div>
		<!-- comment showing (done by user) field -->
                <h3 style = "margin: 30px; font-size: 30px; font-weight: lighter;">Comments</h3>
		<div class = "all_comments">
		<?php
			// selecting all data from comment table
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`comment`");

				// executing the selected data...
                $statemnt->execute();

				// checking if data is available in comment table...
				if ($statemnt->rowCount() > 0){

					// fetching the executed data...
                while ($comResult = $statemnt->fetch(PDO::FETCH_NUM)){ 

					// checking if the news id from comment field is equal with the id from fullArticle page to show the comments in respective news only...
					if ($comResult[3] == $id){
					?>
			<div class = "comments">
				<!-- showing username and date -->
				<div class = "username"><a href = "userComment.php?name=<?php echo $comResult[1]; ?>"><?php echo $comResult[1]; ?></a>&nbsp;•<em><?php echo $comResult[4]; ?></em></div>
				<!-- showing comment -->
				<div class = "commentTxt"><?php echo $comResult[2]; ?></div>
			</div>
			
			<?php }
		
		}
	}else{

		// if the comment table is empty...
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

