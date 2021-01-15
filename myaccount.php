<?php session_start(); ?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once('function.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Student</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/savings_home.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
	$con=mysqli_connect('localhost','root','','online_banking');
    mysqli_select_db($con,'online_banking');
    $row=fetch("user","id='$user_id'")['row'];
    // $sql="SELECT * FROM user WHERE id='$user_id'";
    // $res=mysqli_query($con,$sql);
    // $row=mysqli_fetch_assoc($res);
    $username=$row['username'];
    $mobile=$row['phone'];
    $email=$row['email'];
    $address=$row['address'];
    $accno=$row['accno'];
    $acctype=$row['acctype'];
    $branch=$row['branch'];
    $balance=$row['balance'];
    $ifsc=$row['ifsc'];
	?>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<div class="container-fluid detail">
						<div class="row">
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="detail-1 container-fluid">
							<h3>User Details</h3>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Username:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $username; ?></p>	
									</div>	
								</div>

								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Mobile Number:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $mobile; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Email:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $email; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Address:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $address; ?></p>	
									</div>	
								</div>
								
							</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="detail-2 container-fluid">
								<h3>Bank Details</h3>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Account Number:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $accno; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Account Type:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $acctype; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Branch:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $branch; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>Balance</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $balance,"/- Rs."; ?></p>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p>IFSC Code:</p>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<p><?php  echo $ifsc; ?></p>	
									</div>	
								</div>
							</div>
							</div>
							
						</div>		
						</div>
					</div>
					
				</div>	
	</div>
</body>
</html>