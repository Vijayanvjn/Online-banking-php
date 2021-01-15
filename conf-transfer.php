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
    <link rel="stylesheet" type="text/css" href="css/transfer.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<div class="transfer">
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
						<form class="conf-transfer" method="POST">
							<label>Enter UPI-Pin</label>
							<input type="text" name="accno" value="<?php 
							if(isset($_GET['req_acc'])){
								echo $_GET['req_acc'];
							}
							else
							echo $accno; 

							?>">
							<p class="err"><?php echo $accnoerr; ?></p>
							<label>Bank</label>
							<select name="bank">
								<option value="local" <?php if($bank=="local"){ echo "selected"; } ?>>Local bank</option>
								<option value="canara" <?php if($bank=="canara"){ echo "selected"; } ?>>Canara Bank</option>
								<option value="icici" <?php if($bank=="icici"){ echo "selected"; } ?>> ICICI Bank</option> 
							</select>
							<label>IFSC Code</label>
							<input type="text" name="ifsc" value="<?php 
							if(isset($_GET['req_ifsc'])){
								echo $_GET['req_ifsc'];
							}
							else
							echo $ifsc; 

							?>">
							<p class="err"><?php echo $ifscerr; ?></p> 
							<label>Account Holder Name</label>
							<input type="text" name="accname" value="<?php 
							if(isset($_GET['req_name'])){
								echo $_GET['req_name'];
							}
							else
							echo $accname; 
							?>">
							<p class="err"><?php echo $accnameerr; ?></p>
							<label>Amount</label>
							<input type="text" name="amount" placeholder="Rs." value="<?php 
							if(isset($_GET['req_amount'])){
								echo $_GET['req_amount'];
							}
							else
							echo $amount; ?>">
							<p class="err"><?php echo $amounterr; ?></p>
							<input class="btn" type="submit" name="transfer" value="Transfer">
						</form>	
				</div>	
	</div>
</body>
</html>
								

<?php
$bal_update=update("user","balance=balance+$amount","id='$user_id'");
// $bal_update="UPDATE user SET balance=balance-$amount WHERE id='$user_id'";
$transaction_array=array("sender_id"=>$user_id,"receiver"=>$accname,"accno"=>$accno,"bank"=>$bank,"ifsc"=>$ifsc,"amount"=>$amount);
insert("transaction",$transaction_array);
// $sql2="INSERT INTO transaction (sender_id,receiver,accno,bank,ifsc,amount) VALUES ('$user_id','$accname','$accno','$bank','$ifsc','$amount')";
//  $res2=mysqli_query($con,$sql2);
// $res3=mysqli_query($con,$bal_update);
update("user","balance=balance+$amount","accno='$accno'");
// $bal_update2="UPDATE user SET balance=balance+$amount WHERE accno='$accno'";
// $res4=mysqli_query($con,$bal_update2);

?>