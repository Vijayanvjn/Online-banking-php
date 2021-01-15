<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<header>
	<div class="container-fluid header">
		<div class="row">
			<div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-1  col-sm-offset-1 header-content">
				<h3 class="text-center header-title">ONLINE BANKING SYSTEM </h3>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-6 header-content">
				<div class="search-div">
				<form method="POST">\
		
				<input type="text" name="search-bar" placeholder="Search" id="search" value=
				"<?php 
				 if(isset($_POST['search'])){
				 	echo $_POST['search-bar'];
				 }
				?>" >
				<input type="submit" name="search" value="submit" id="search-submit">
				<label for="search-submit">
				<i class="fa fa-search search-icon"></i>
				</label>
				</form>
				</div>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-3 header-content">
				<a  href="<?php echo 'users_list.php?user_id='.$user_id.'&user='.$user; ?>" class="home-icon" >
				<i class="fa fa-home"></i>
				</a>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-3 header-content admin-user">
				<div class="dropdown">
					<i class="fa fa-user"></i>
					<i class="fa fa-angle-down"></i>	
					<div class="options">
					<?php 
					if($_GET){
					echo "<p>WELCOME ",$_GET['user'],"</p>"; 
					}
					else{
					echo "<p>WELCOME ","User","</p>";
					}
					?>
					<a href="<?php echo 'edit.php?user='.$_GET['user'].'&user_id='.$_GET['user_id']; ?>">Edit Profile</a>
					<a href="logout.php">Logout</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</header>

</body>
</html>