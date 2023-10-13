<?php
include('categoryDB.php');
session_start();

//setting username to show on profile
$nameOfUser = $_SESSION["username"];

//setting photo/user's image to display on profile
$userPhoto = $_SESSION["photo"];

// if session is not set, then user redirects to login page.
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
		<title>Northampton News - Manage Categories</title>
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
                <li><a href = "adminArticles.php"><i class='bx bxs-news' ></i><span>&ensp;News</span></a></li>
				<li><a href = "manageCategories.php" id = "sel"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
                <li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading">ALL CATEGORIES</h2>
			</section>
            <div class = "details" id = "ctgTable">
           <table>
                <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
                <?php
				// selecting all data from category table...
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category`");

				//executing selected data...
                $statemnt->execute();

				//initializing the number variable...
				$number = 0;

				// fetching all executed data..
                while ($ctgResults = $statemnt->fetch(PDO::FETCH_NUM)){
					$number+=1;
                    echo "<tr>";
                    echo "<td>". $number."</td>";

					// category name
                    echo "<td>". $ctgResults[1]."</td>"; ?>
                    <?php

					// if more than one categories are available, admins can delete any of those...
                    if($statemnt->rowCount() > 1){
                        echo "<td><a href='editCategory.php?id=$ctgResults[0]'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='deleteCategory.php?name=$ctgResults[1]'>Delete</a></td>";
                    }

					// but if only one category is available, admin cannot delete the last category...
                    else{
                        echo "<td><a href='editCategory.php?id=$ctgResults[0]'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a>Delete</a></td>";
                    }
                    echo "</tr>";
                }
                ?>
                </table>
            </div>
			<!-- link for redirecting to addCategory page -->
                <p class = "addLink"> <a href = "addCategory.php">Add New Category</a></p>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>
