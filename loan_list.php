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
	<?php
	$user=$_GET['user'];
	$user_id=$_GET['user_id'];
	?>
	<div>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
						<div class="table-responsive">
							<table class="table table-striped loan-table">
							<thead>
							<tr>
								<th>User-id</th>
								<th>Username</th>
								<th>Account Number</th>
								<th>Amount</th>
								<th>loan-type</th>
								<th>interest</th>
								<th>totalpay</th>
								<th>monthly-deduction</th>
								<th>Requested Time</th>
								<th>Requested Date</th>
								<th>Accept</th>
								<th>Denie</th>


							</tr>
							</thead>
							<tbody>

								<?php
									$con=mysqli_connect("localhost","root","","online_banking");
									if(isset($_POST['search'])){
									$text=$_POST['search-bar'];
									if($text!=""){
									$sql2="SELECT * FROM loan INNER JOIN user ON loan.user_id=user.id 
											AND username='$text' OR accno='$text'";
									$res2=mysqli_query($con,$sql2);
									}
									else{
										$res=fetch("loan","status='Requested'")['result'];
										// $sql2="SELECT * FROM loan WHERE status='Requested'";
										// $res2=mysqli_query($con,$sql2);	
									}
									}
									else{
										$res=fetch("loan","status='Requested'")['result'];
										// $sql2="SELECT * FROM loan WHERE status='Requested'";
										// $res2=mysqli_query($con,$sql2);	
									}
								?>

								<?php

									// $con=mysqli_connect("localhost","root","","online_banking");
									// $sql2="SELECT * FROM loan WHERE status='Requested'";
									// $res2=mysqli_query($con,$sql2);
									$sql2=fetch("loan","status='Requested'");
									$res2=$sql2['result'];
									$row2=$sql2['row'];
									$count2=$sql2['count'];
									if($count2!=0){
										do{
											$id=$row2['user_id'];	
											$amount=$row2['amount'];	
											$row=fetch("user","id='$id'")['row'];
											// $sql="SELECT * FROM user WHERE id='$id'";	
											// $res=mysqli_query($con,$sql);
											// $row=mysqli_fetch_assoc($res);	
											echo "<tr>",
											"<td>".$row2['user_id']."</td>",
											"<td>".$row['username']."</td>",
											"<td>".$row['accno']."</td>",
											"<td>".$row2['amount']." Rs/-"."</td>",
											"<td>".$row2['loan_type']."</td>",
											"<td>".$row2['interest']." Rs/-"."</td>",
											"<td>".$row2['total_pay']." Rs/-"."</td>",
											"<td>".$row2['monthly_deduction']."Rs/-"."</td>",
											"<td>".$row2['loan_time']."</td>",
											"<td>".$row2['loan_date']."</td>",
											"<td>","<a href='accept_loan.php?loan_id=$id&user_id=$user_id&user=$user&amount=$amount' class='btn btn-success'> Accept </a>","</td>",
											"<td>","<a href='denie_loan.php?loan_id=$id&user_id=$user_id&user=$user' class='btn btn-danger'> Denie </a>","</td>",
											
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