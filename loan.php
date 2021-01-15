<?php session_start(); ?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
<?php require_once('function.php'); ?>
<?php

	ob_start();

?>
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
    <link rel="stylesheet" type="text/css" href="css/loan.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>

	<?php
		$count=0;
		$loan_amt="";
		$loanamterr="";
		$loan_type="";
		$upi="";
		$upierr="";
		$con=mysqli_connect("localhost","root","","online_banking");
		$row=fetch("user","id='$user_id'")['row'];
		// $sql="SELECT * FROM user WHERE id='$user_id'";
		// $res=mysqli_query($con,$sql);
		// $row=mysqli_fetch_assoc($res);
		$balance=$row['balance'];
		date_default_timezone_set("Asia/Kolkata");
		$interest=0;
		$total_pay=0;
		$monthly_deduction=0;
		$seen_date=date("Y-m-d");
		$seen_time=date("h:i:a");
		if(isset($_POST['loan'])){ //requesting loan
			$date=date("d/m/Y");
			$time=date("h:m");
			$loan_amt=$_POST['loan_amt'];
			$loan_type=$_POST['loan_type'];
			$upi=$_POST['upi'];
			if($loan_amt==""){
				$loanamterr="Please enter the loan amount";
				$count=$count+1;
			}
			else
				if($loan_amt>30000 || $loan_amt<5000){
					$loanamterr="You should ask loan within the range of 5000 to 30000 Rs/-";
					$count=$count+1;
				}
			else
			{
				$loanamterr="";
			}
			if($upi==""){
				$upierr="Please enter the upi";
				$count=$count+1;
			}
			else
				if($upi!=$row['pin']){
					$upierr="Your UPI Pin is incorrect";
					$count=$count+1;
				}
			else{
				$upierr="";
			}
			if($loan_amt<10000){
				$interest=$loan_amt*5/100;
				$total_pay=$loan_amt+$interest;
				$monthly_deduction=$total_pay/5;
			}
			else
				if($loan_amt>=10000&&$loan_amt<=30000){
					$interest=$loan_amt*8/100;
					$total_pay=$loan_amt+$interest;
					$monthly_deduction=$total_pay/8;
			}

			if($count==0){
				$loan_array=array("user_id"=>$user_id,"amount"=>$loan_amt,"loan_type"=>$loan_type,"status"=>"Pending","loan_time"=>$time,"loan_date"=>$date,"interest"=>$interest,"total_pay"=>$total_pay,"monthly_deduction"=>$monthly_deduction);
				insert("loan",$loan_array);
				// $sql_loan="INSERT INTO loan (user_id,amount,loan_type,status,loan_time,loan_date,interest,total_pay,monthly_deduction) 
				// VALUES ('$user_id','$loan_amt','$loan_type','Pending','$time','$date','$interest','$total_pay','$monthly_deduction')";
				// $res_loan=mysqli_query($con,$sql_loan);
			}
		}
	?>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn"> <!-- requesting loan -->
					<?php include "header.php" ?>
					<?php 
						$check_sql=fetch("loan","user_id='$user_id'");
						$check_row=$check_sql['row'];
						$check_count=$check_sql['count'];
						// $check_sql="SELECT * FROM loan WHERE user_id='$user_id'";
						// $check_res=mysqli_query($con,$check_sql);
						// $check_count=mysqli_num_rows($check_res);
						// $check_row=mysqli_fetch_assoc($check_res);
					?>
					<form class="form-custom" method="POST" <?php

						if($check_count>=1){

							echo "style='display:none;'";
						}
						?>
						>
							<label>Loan Amount</label>
							<input type="text" name="loan_amt" placeholder="Rs/-" value="<?php echo $loan_amt; ?>">
							<p class="err"><?php echo $loanamterr; ?></p>
							<label>Loan Type</label>
							<select name="loan_type">
								<option value="education">Education Loan</option>
								<option value="personal">Personal Loan</option>
								<option value="vehicle">Vehicle Loan</option>
							</select>
							<label>Your UPI Pin</label>
							<input type="password" name="upi" value="<?php echo $upi;?>">
							<p class="err"><?php echo $upierr; ?></p>
							<input class="btn" type="submit" name="loan" value="Request">
							<div class="note">
								<p> Note: </p>
								<ul>
									<li>Below 10,000 Rs/- you should pay for 5 months with 5% of interest</li>
									<li>On the range of 10000/- to 30000/- you should pay for 8 months with 7% of interest </li>
								</ul>	
							</div>
						</form>
						<!-- Loan status -->
						<div class="loaned" 
						<?php 
						if($check_count!=0){
							if($check_row['status']=="Requested"||$check_row['status']=="Approved"){ 
								echo "style='display:block;'"; 
							} 
							else 
								{
									echo "style='display:none;'"; 
								}
						}
						else{
							echo "style='display:none;'"; 
						} 
						?>
						>
							<h3>Your Loan amount For <span class="loan-amount"> Rs.<?php echo $check_row['amount'];?></span> is 
								<?php echo $check_row['status']; ?></h3>
							<div class="table-responsive">
								<table class="table striped-table stmt-table"> 
								<thead>
									<tr>
										<th>Process</th>
										<th>Amount</th>
										<th>Date</th>
										<th>Time</th>
									</tr>	
								</thead>
								<tbody>
									<?php
									$loan_sql=fetch("loan_transaction","user_id='$user_id'");
									$loan_res=$loan_sql['result'];
									$loan_row=$loan_sql['row'];
									$loan_count=$loan_sql['count'];
									if($loan_count!=0){
										do{
										
										echo "<tr>",
										"<td>".$loan_row['status']."</td>",
										"<td>".$loan_row['amount']."</td>",
										"<td>".$loan_row['process_date']."</td>",
										"<td>".$loan_row['process_time']."</td>",
										"<tr>";
										}while($loan_row=mysqli_fetch_assoc($loan_res));	
									}
									// $loan_sql="SELECT * FROM loan_transaction WHERE user_id='$user_id'";
									// $loan_res=mysqli_query($con,$loan_sql);
									
									?>
								</tbody>
								</table>	
							</div>
							
						</div>

						<div class="confirmation"> <!-- confirming loan amount -->
							
							<form class="form-custom confirm-form" method="POST" 
									<?php 
									if($check_count!=0){
									if($check_row['status']=="Pending")
										{
											echo "style='display:block'";
										}
									else{
										echo "style='display:none'";
									}
									}
									else{
										echo "style='display:none'";	
									}
									
										?>
							>
								<label>Your Loan amount is</label>
								<input type="text" name="loan-amount" disabled value="<?php echo $check_row['amount']; ?>">
								<label>Your interest amount</label>
								<input type="text" name="interest-amount" disabled value="<?php echo $check_row['interest']; ?>">
								<label>Totally you should pay</label>
								<input type="text" name="total-pay" value="<?php echo $check_row['total_pay']; ?>" disabled>
								<label>Monthly deduction</label>
								<input type="text" name="monthly-deduction" value="<?php echo $check_row['monthly_deduction']; ?>" disabled>
								<input type="submit" name="confirm-loan" class="confirmation-btn btn" value="Confirm">
								<input type="submit" name="denie-loan" class="confirmation-btn btn" value="Denie">

							</form>

						</div>
						<?php 

							if(isset($_POST['confirm-loan'])){
								update("loan","status='Requested'","user_id='$user_id'");
								// $confirm_loan_sql="UPDATE loan SET status='Requested' WHERE user_id='$user_id'";
								// $confirm_loan_res=mysqli_query($con,$confirm_loan_sql);
								header("Refresh:0;");
							}
							if(isset($_POST['denie-loan'])){
								delete("loan","user_id='$user_id'");
								// $denie_loan_sql="DELETE FROM loan WHERE user_id='$user_id'";
								// $denie_loan_res=mysqli_query($con,$denie_loan_sql);
								header("Refresh:0;");
								ob_end_flush();
							}

						?>


				</div>	
</body>
</html>