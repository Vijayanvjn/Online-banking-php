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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/export.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
	$history_id=$_GET['history_id'];
	?>
	<div>
				<?php include "admin-sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "admin_header.php" ?>
						<div class="table-responsive">
							<table class="table table-striped stmt-table" id="stmt-table">
							<thead>
							<tr>
								<th>Name</th>
								<th>Account Number</th>
								<th>Bank</th>
								<th>IFSC Code</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Time</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php
									$con=mysqli_connect("localhost","root","","online_banking");
									$sql=fetch("transaction");
									$res=$sql['result'];
									$row=$sql['row'];
									$count=$sql['count'];
									// $sql="SELECT * FROM transaction";
									// $res=mysqli_query($con,$sql);
									// $sql2="SELECT * FROM user WHERE id='$history_id'";
									// $res2=mysqli_query($con,$sql2);
									// $row2=mysqli_fetch_assoc($res2);
									$row2=fetch("user","id='$history_id'")['row'];
									if($count!=0){
										do{
											if($row['sender_id']==$history_id){		//this means i have sent to another			
											echo "<tr>",
											"<td><span class='sender'>".$row2['username']."</span> <i class='fa fa-arrow-right'></i><span class='receiver'>".$row['receiver']."</span></td>",
											"<td>".$row['accno']."</td>",
											"<td>".$row['bank']."</td>",
											"<td>".$row['ifsc']."</td>",
											"<td>".$row['amount']." Rs/-"."</td>",
											"<td>".$row['cur_date']."</td>",
											"<td>".$row['cur_time']."</td>",
											"<td>Success</td>",
											"</tr>";
											}


											if($row2['accno']==$row['accno']){		// this means i received from another
											echo "<tr>";
											?>
											<?php
												$sender_id=$row['sender_id'];
												$row_match=fetch("user","id='$sender_id'")['row'];
												// $sql_match="SELECT * FROM user WHERE id=".$row['sender_id'];
												// $res_match=mysqli_query($con,$sql_match);
												// $row_match=mysqli_fetch_assoc($res_match);
											?>
											<?php
											echo
											"<td> <span class='sender'>".$row_match['username'], 
											" </span> <i class='fa fa-arrow-right'></i><span class='receiver'>".$row2 ['username']."</span></td>",
											"<td>".$row_match['accno']."</tsd>",
											"<td>".$row['bank']."</td>",
											"<td>".$row_match['ifsc']."</td>",
											"<td>".$row['amount']." Rs/-"."</td>",
											"<td>".$row['cur_date']."</td>",
											"<td>".$row['cur_time']."</td>",
											"<td>Success</td>",
											"</tr>";	
											}
										}while($row=mysqli_fetch_assoc($res));	
									}
									
								?>
							</tbody>
						</table>	
						</div>
						
						<span class="download">
							<a href="#" id="download-btn" onclick="javascript:fnExcelReport();"><i class="fa fa-download"></i></a>
						</span>
				</div>	
	</div>
</body>
</html>