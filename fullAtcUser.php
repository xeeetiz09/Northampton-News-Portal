<?php
//calling connection page for connecting database to server.
include('connection.php');

//getting specific article id...
$id = $_GET['id'];
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
				<li><a href = "register.php"><i class='bx bxs-user-check'></i><span>&ensp;Register</span></a></li>
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
					<!-- showing news content -->
				<article class = "news_atcl">
				<?php echo $results[2]; ?>
				</article>
			</div>
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
