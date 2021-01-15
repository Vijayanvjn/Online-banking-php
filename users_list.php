<?php session_start(); ?>
<?php require("deductions.php"); ?>
<?php require_once('function.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Student</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/savings_home.css" />
    <link rel="stylesheet" type="text/css" href="css/transfer.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" type="text/css" href="css/admin.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/export.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<div class="user-list">
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
				<?php
					$conn=mysqli_connect("localhost","root","","online_banking");
					if(isset($_POST['search'])){
					$text=$_POST['search-bar'];
					if($text!=""){

					$sql="SELECT * FROM user  WHERE username='$text' OR accno='$text'";
					$res=mysqli_query($conn,$sql);
					}
					else{
						$sql="SELECT * FROM user ORDER BY id ASC";
						$res=mysqli_query($conn,$sql);	
					}
					}
					else{
						$sql="SELECT * FROM user ORDER BY id ASC";
						$res=mysqli_query($conn,$sql);	
					}
				?>
					<?php
					while($row=mysqli_fetch_assoc($res)){
						$edit_id=$row['id'];
						$fetch_profile="SELECT image FROM user WHERE id='$edit_id'";
				    	$exec_fetch=mysqli_query($con,$fetch_profile);
				    	$res_fetch=mysqli_fetch_assoc($exec_fetch);
						echo "<div class='user-box'>", //for section
							 	"<div class='user'>", // for box
							 		"<div class='user-profile'>";   //profile section start
							 			if($res_fetch['image']==""){
									    	echo 
									    		"<div class='user-profile-box user-icon-section'>",
									    		"<img src='images/user-null.png'>",
									    		"</div>";
										}
										else{
											echo 	"<div class='user-profile-box'>",
													"<img src='uploads/".$res_fetch['image']."'>",
													"</div>";
										}
							 echo "</div>", //profile ends
							 		"<div class='container-fluid user-container'>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>User-Id: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['id']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Username: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['username']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Password: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['password']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Email: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['email']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Mobile </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['phone']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Address: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['address']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Branch: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['branch']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Account Number: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['accno']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Bank balance: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['balance']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>UPI Pin: </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['pin']."</p>",							 				
							 				"</div>",
							 			"</div>",
							 			"<div class='row'>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>Recovery Email </p>",							 				
							 				"</div>",
							 				"<div class='col-md-6 col-xs-6 col-sm-6'>",
												"<p>".$row['recovery_mail']."</p>",							 				
							 				"</div>",
							 			"</div>",
								 	"</div>",
								 "<a class='btn btn-edit' href='edit_user.php?user=$user&user_id=$user_id&edit_id=$edit_id'>Edit </a>",
							 	"</div>",
							 "</div>";

					}
					?>
	
	</div>
</body>
</html>