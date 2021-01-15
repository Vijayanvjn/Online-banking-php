<?php session_start(); ?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once("function.php"); ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	
	<div class="notification">
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<div class="table-responsive">
					<table class="table table-striped stmt-table">
						<tr>
							<th> Requester </th>
							<th> Account Number</th>
							<th> Amount</th>
							<th> Message</th>
							<th> Pay</th>
							<th> Decline </th>	
						</tr>
						<?php
							$user_id=$_GET['user_id'];
							$con=mysqli_connect("localhost","root","","online_banking");
							// $mysql="SELECT * FROM user WHERE id='$user_id'";
							// $myres=mysqli_query($con,$mysql);
							// $myrow=mysqli_fetch_assoc($myres);
							
							$sql="SELECT * FROM user inner join message on message.requester_id=user.id 
							WHERE message.recipient='$user_id'";
							$res=mysqli_query($con,$sql);
							while($row=mysqli_fetch_assoc($res)){
								$req_id=$row['id'];
								$req_name=$row['username'];
								$req_acc=$row['accno'];
								$req_amount=$row['amount'];
								$req_message=$row['message'];
								$req_ifsc=$row['ifsc'];
								echo "<tr>",
								"<td>".$req_name."</td>",
								"<td>".$req_acc."</td>",
								"<td>".$req_amount."</td>",
								"<td>".$req_message."</td>",
								"<td>".'<a href="transfer-acc.php?user='.$user.'&user_id='.$user_id.'&req_name='.$req_name.'&req_acc='.
								$req_acc.'&req_amount='.$req_amount.'&req_message='.$req_message.'&req_ifsc='.$req_ifsc.'&status=loading'.'&req_id='.$req_id.'"class="btn btn-success">Pay</a>'."</td>",

								"<td>".'<a href="decline_pay.php?user='.$user.'&user_id='.$user_id.'&req_id='.$req_id.'"class="btn btn-danger">Decline</a>'."</td>",

								"</tr>";
							}
						?>
						
					</table>
				</div>
				</div>
	</div>
</body>
</html>
								