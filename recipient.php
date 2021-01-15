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
    <link rel="stylesheet" type="text/css" href="css/recipient.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>	
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<div class="container-fluid recipient_body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<a href="<?php echo 'add_recipient.php?user='.$user.'&user_id='.$user_id; ?>" class="btn btn-primary add_recipient_btn">Add Recipient</a>		
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="table-responsive">
									<table class="table striped-table recipient-tbl">
									<tr>
										<th>Name</th>
										<th>Account Number</th>
										<th>IFSC</th>
										<th>Bank</th>
										<th>Action</th>
									</tr>

									<?php
										$con=mysqli_connect("localhost","root","","online_banking");
										$sql=fetch("recipients","own_by='$user_id'");
										$res=$sql['result'];
										$row=$sql['row'];
										$count=$sql['count'];
										if($count!=0){
											do{
											$del_id=$row['id'];
											echo "<tr>",
											"<td>".$row['name']."</td>",
											"<td>".$row['accno']."</td>",
											"<td>".$row['ifsc']."</td>",
											"<td>".$row['bank']."</td>",
											"<td>" ,"<a href='delete_recipient.php?del_id=$del_id&user=$user&user_id=$user_id' class='btn btn-success'>Delete Recipient</a>","</td>",
											"</tr>";
											}while($row=mysqli_fetch_assoc($res));	
										}
											
									?>
									</table>				
								</div>	
							</div>
						</div>
					</div>
					<div></div>
					
				</div>	
	</div>
</body>
</html>