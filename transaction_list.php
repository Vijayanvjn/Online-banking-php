<?php require("deductions.php"); ?>
<?php require_once('function.php'); ?>
<?php session_start(); ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/export.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<div>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
						<div class="table-responsive">
							<table class="table table-striped admin-trans-user-table">
							<thead>
							<tr>
								<th>User-id</th>
								<th>Username</th>
								<th>Account Number</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php
									$con=mysqli_connect("localhost","root","","online_banking");
									if(isset($_POST['search'])){
									$text=$_POST['search-bar'];
									if($text!=""){
									$res2=fetch("user","username='$text'",'OR',"accno='$text'")['result'];
									// $sql2="SELECT * FROM user  WHERE username='$text' OR accno='$text'";
									// $res2=mysqli_query($con,$sql2);
									}
									else{
										$sql2="SELECT * FROM user ORDER BY id ASC";
										$res2=mysqli_query($con,$sql2);	
									}
									}
									else{
										$sql2="SELECT * FROM user ORDER BY id ASC";
										$res2=mysqli_query($con,$sql2);	
									}
								?>
								<?php
									$row2=mysqli_fetch_assoc($res2);
									$count2=mysqli_num_rows($res2);
									if($count2!=0){
										do{		
											$id=$row2['id'];	
											echo "<tr>",
											"<td>".$row2['id']."</td>",
											"<td>".$row2['username']."</td>",
											"<td>".$row2['accno']."</td>",
											"<td>","<a href='user_transaction.php?history_id=$id&user_id=$user_id&user=$user' class='btn btn-success'> View Transaction </a>","</td>",
											
											"</tr>";
										}while($row2=mysqli_fetch_assoc($res2));	
									}
									
								?>
							</tbody>
						</table>	
						</div>
						
				</div>	
	</div>
</body>
</html>