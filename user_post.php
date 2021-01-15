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
    <link rel="stylesheet" type="text/css" href="css/post.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/export.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<?php
					$con=mysqli_connect("localhost","root","","online_banking");
					date_default_timezone_set("Asia/Kolkata");
					$seen_time=date("h:i:a");
					$seen_date=date("Y-m-d");
					$post_id=$_GET['post_id'];
					$row=fetch("notification","id='$post_id'")['row'];
					// $sql="SELECT * FROM notification WHERE id='$post_id'";
					// $res=mysqli_query($con,$sql);
					// $row=mysqli_fetch_assoc($res);
					$post_date=$row['post_date'];
					$date=date("d-m-Y",strtotime($post_date));
					?>
					<div class="post-view">
						<div class="post-description">
							<p>From: Bank,</p>	
							<p><?php echo $date; ?></p>
							<p>12:30 PM</p>	
						</div>
						<div class="post-content">
							<h1><?php echo $row['title']; ?></h1>
							<p><?php echo $row['content']; ?></p>	
						</div>
					</div>
				</div>	
	</div>
</body>
</html>