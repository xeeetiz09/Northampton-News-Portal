<?php
include('userDB.php');
// initializing number variable...
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
		<title>Northampton News - Home Page</title>
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
		<nav>
			<ul>
				<li><a href = "index.php" id = "sel"><i class='bx bxs-home'></i><span>&ensp;Home</span></a></li>
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
                <h2 id = "heading">LATEST ARTICLES</h2>
			</section>
			
           <div class = "title_contnr">
		   <?php
			// query for selecting all data from category table.
			$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`article` ORDER BY publishDate desc LIMIT 10");

			// executing the query...
			$statemnt->execute();
			// checking if data is available in article table...
			if($statemnt->rowCount()>0){
				//fetching the data...
				while($result = $statemnt->fetch(PDO::FETCH_NUM)){
					$number+=1;
			?>
				
				<div class = "evr_titles">
					<!-- showing date -->
					<em style = "float: right;"><?php echo $result[4]; ?></em>
					<!-- showing category name -->
					<p>Category:&nbsp;<?php echo $result[3]; ?></p>
					<!-- news title (which is also a link for redirecting admin to specific full article) -->
					<h1><a href = "fullAtcUser.php?id=<?php echo $result[0]?>"><?php echo $result[1]; ?></a></h1>
				</div>

			<?php 
			}}
		
	else{
		// if the article table is empty...
				echo "<div style = 'text-align: center;'>Currently, there are no articles!</div>";
			}?>
			

		</div>

		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
