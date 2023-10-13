<?php
include('commentDB.php');

//setting username to show on profile
$nameOfUser = $_SESSION["usr_fullname"];
//setting photo/user's image to display on profile
$userPhoto = $_SESSION["usr_photo"];

error_reporting(0);
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
		<title>Northampton News - Comments</title>
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
                <li><a href = "#" id = "sel"><i class='bx bxs-comment-dots'></i><span>&ensp;Comments</span></a></li>
				<li><a href = "userAboutUs.php"><i class='bx bx-info-circle' ></i><span>&ensp;About Us</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading">COMMENTS</h2>
			</section>
		<div class = "all_comments">
		<?php
		// shows all comments by a respective user...
				$name = $nameOfUser;
				if ($_GET['name']){
					$name = $_GET['name'];
				}
				// selecting specific comments of a respective user...
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`comment` WHERE full_name = '$name'");
				// executing the selected data...
                $statemnt->execute();
				// checking if data is available in table...
				if ($statemnt->rowCount() > 0){
				// fetching the executed data...
                while ($comResult = $statemnt->fetch(PDO::FETCH_NUM)){
					?>
					<!-- showing field -->
			<div class = "comments">
				<!-- showing username and date -->
				<div class = "username"><a href = "userComment.php?name = <?php echo $comResult[1] ?>"><?php echo $comResult[1]; ?></a>&nbsp;•<em><?php echo $comResult[4]; ?></em></div>
				<!-- showing comment -->
				<div class = "commentTxt"><?php echo $comResult[2]; ?></div>
			</div>
			
			<?php 
		
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

