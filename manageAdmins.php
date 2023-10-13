<?php
//calling connection page for connecting database to server.
include('connection.php');
//for fetching information from previous page
session_start();

//setting username to show on profile
$nameOfUser = $_SESSION["username"];

$userName = $_SESSION["unqusrname"];

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

		<!--Box icon css link (Reference: https://www.boxicons.com)-->
		<!-- 
			Boxicons, [n.d.]. High Quality Web Icons. [online] 
			Available at: https://www.https://boxicons.com/ [Accessed: 10 Sept 2022]

			All the icons used in the website was taken from boxicons site.
		 -->
		<link rel = "stylesheet" href = "https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
		<title>Northampton News - Manage Admins</title>
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
				<li><a href = "manageAdmins.php" id = "sel"><i class='bx bxs-user'></i><span>&ensp;Admins</span></a></li>
                <li><a href = "adminArticles.php"><i class='bx bxs-news' ></i><span>&ensp;News</span></a></li>
				<li><a href = "manageCategories.php"><i class='bx bx-category' ></i><span>&ensp;Category</span></a></li>
                <li><a href = "manageComments.php" ><i class='bx bxs-comment' ></i><span>&ensp;Comments</span></a></li>
				</ul>
			</nav>
			<section class = "news_list_container">
                <h2 id = "heading">ALL ADMINS</h2>
			</section>
           <div class = "details">
           <table>
                <tr>
                    <th>S.No</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date Registered</th>
                    <th>Action</th>
                </tr>
                <?php
				// selecting all data from admin table...
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`admin`");

				//executing selected data...
                $statemnt->execute();

				//initializing the number variable...
				$number = 0;

				// fetching all executed data..
                while ($adminResult = $statemnt->fetch(PDO::FETCH_NUM)){
					$number+=1;
                    echo "<tr>";
					// number (increases by 1 everytime until while loop stops executing)...
                    echo "<td>". $number."</td>";
					// admin's full name
                    echo "<td>". $adminResult[1]."</td>";
					// admin's username
                    echo "<td>". $adminResult[2]."</td>";
					// admin's email
                    echo "<td>". $adminResult[3]."</td>";
					// admin's registered date
                    echo "<td>". $adminResult[5]."</td>";
					?>
					<?php
					// the current logged in admin cannot delete but can edit their account...
					if ($userName == $adminResult[2]){
						echo "<td>(YOU)</td>";
					}
					else{
						// the current logged in admin can delete or edit other admin's account...
						echo "<td><a href='editAdmin.php?id=$adminResult[0]'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='deleteAdmin.php?id=$adminResult[0]'>Delete</a></td>";
					}
                    echo "</tr>";
                }
                ?>
                </table>
           </div>
		   <!-- link for redirecting to addAdmin page -->
		   <p class = "addLink"> <a href = "addAdmin.php">Add New Admin</a></p>
		</main>

		<footer>
			&copy; Northampton News 2017. All rights reserved.
		</footer>

	</body>
</html>