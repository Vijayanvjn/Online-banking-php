<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<header>
	<div class="top-header">
			<div class="top-content">
				<a href="<?php echo 'savings_home.php?user_id='.$user_id.'&user='.$user; ?>">
				<i class="fa fa-home"></i>
				</a>
			</div>
			
			<div class="top-content">
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
					<a href="<?php 
					echo 'myaccount.php?user='.$_GET['user'].'&user_id='.$_GET['user_id']; 
					?>">My Account</a>
					<a href="<?php echo 'edit.php?user='.$_GET['user'].'&user_id='.$_GET['user_id']; ?>">Edit Profile</a>
					<a href="logout.php">Logout</a>
					</div>
				</div>
				
			</div>
	</div>
	<div class="container-fluid header">
		<div class="row">
			<div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-1  col-sm-offset-1 header-content">
				<h3 class="text-center header-title">ONLINE BANKING SYSTEM </h3>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-6 header-content">
				<div class="search-div">
				<form method="POST">
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
			<?php 
						$user_id=$_GET['user_id'];
						$user=$_GET['user'];
						$con=mysqli_connect("localhost","root","","online_banking");
						$sql="SELECT * FROM notification ORDER BY id desc";
						$res=mysqli_query($con,$sql);
			?>
			<div class="notify-icon col-md-2 col-sm-2 col-xs-6 header-content">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a  href="#" class="bell-icon nav-link" data-toggle="dropdown" ariahaspopup="true" aria-expanded="false">
						<i class="fa fa-bell"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right drop-down-newitem animated fadeIn">
							<?php
								while($row=mysqli_fetch_assoc($res)){
									$notification_id=$row['id']; 
									$notification_sender=$row['sender'];
									$notification_receiver=$row['receiver'];
									$notification_title=$row['title'];
									$notification_content=$row['content'];
									// $read_status=$row['read_status'];
									$read_row=fetch("notification_log","notification_id='$notification_id'",'AND',"user_id='$user_id'")['row'];
									$read_count=fetch("notification_log","notification_id='$notification_id'",'AND',"user_id='$user_id'")['count'];
									// $read_sql="SELECT * FROM notification_log WHERE notification_id='$notification_id' AND user_id='$user_id'";
									// $read_res=mysqli_query($con,$read_sql);
									// $read_row=mysqli_fetch_assoc($read_res);
									if($read_count!=0){
										$read_status=$read_row['status'];;	
									}
									
									if($notification_receiver==$user_id&&$notification_title=="Request"){
										echo '<a href=received_request.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"';
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p> Request </p>';
										echo '<small><i>'.$notification_content.'</a></i></small>';
									}
									if($notification_sender==$user_id&&$notification_receiver!='bank'&&$notification_title!='Request'){ //used for if you send amount to other
										echo '<a href=mini.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"';
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p> Debited </p>';
										echo '<small><i> Your account is debited with Rs. '.$row['content'].'</a></i></small>';
									}
									if($notification_receiver)
									if($notification_receiver==$user_id&&$notification_sender!='bank'&&$notification_title!='Request'){ //used if you receive amount from others
										echo '<a href=mini.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"';
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p> Credited </p>';
										echo '<small><i> Your account is Credited with Rs. '.$row['content'].'</a></i></small>'; 
									}
									if($notification_sender=='bank'&&$notification_receiver=='all'){ //bank post notifications
										echo '<a href=user_post.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"'; 
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p> New Message from bank </p>';
										echo '<small><i>'.$row['title'].'</a></i></small>';	
									}
									if($notification_sender=='bank'&&$notification_receiver==$user_id){ //loan allocated
										echo '<a href=loan.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"'; 
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p>' .$row['title']. '</p>';
										echo '<small><i>'.$row['content'].'</a></i></small>';
									}
									if($notification_sender==$user_id&&$notification_receiver=='bank'){ // loan due deduction
										echo '<a href=loan.php?user='.$user.'&user_id='.$user_id.'&post_id='.$notification_id. ' class="dropdown-item message"'; 
										if($read_status==0){ 
											echo 'style=font-weight:600'; 
										}
										echo '><p>' .$row['title']. '</p>';
										echo '<small><i>'.$row['content'].'</a></i></small>';
									}

									
								}
							?>
						</div>
					</li>
					<li class="nav-item">
						<a href="<?php echo 'recipient.php?user_id='.$user_id.'&user='.$user; ?>">
						<i class="fa fa-users"></i>
						</a>		
					</li>
				</ul>
				
			</div>
		</div>
	</div>
</header>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>