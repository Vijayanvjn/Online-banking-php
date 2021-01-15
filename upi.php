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
	<?php
		$con=mysqli_connect("localhost","root","","online_banking");
		$row=fetch("user","id='$user_id'")['row'];
		// $sql="SELECT * FROM user WHERE id='$user_id'";
		// $res=mysqli_query($con,$sql);
		// $row=mysqli_fetch_assoc($res);
		$pin="";
		$confpin="";
		$email="";
		$pinerr="";
		$confpinerr="";
		$emailerr="";
		$count=0;
		$fetch_pin=$row['pin'];
		if(isset($_POST['set'])){
			$pin=$_POST['pin'];
			$confpin=$_POST['conf-pin'];
			$email=$_POST['email'];
			if($pin==""){
				$pinerr="Please enter Your UPI Pin";
				$count=$count+1;
			}
			else
				if(!preg_match("/^[0-9]{4}$/",$pin)){
					$pinerr="Your pin should be 4 digit number";
					$count=$count+1;
				}
			else{
				$pinerr="";
			}
			if($confpin==""){
				$confpinerr="Please re-enter Your Pin";
				$count=$count+1;
			}
			else
				if($confpin!=$pin){
					$confpinerr="Your Confirm Pin not matched with Pin";
					$count=$count+1;
				}
			else{
				$confpinerr="";
			}
			if($email==""){
				$emailerr="Please enter Recovery Email";
				$count=$count+1;
			}
			else
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				 	$emailerr="Please enter valid email";
				 	$count=$count+1;
				 }
			else{
				$emailerr="";
			}
			if($count==0){
				update("user","pin='$pin',recovery_mail='$email'","id='$user_id'");
				// $sql="UPDATE user SET pin='$pin',recovery_mail='$email' WHERE id='$user_id'";
				// $res=mysqli_query($con,$sql);
				header("Refresh:0");
			}
		}
	?>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
						<form class="form-custom" method="POST" <?php if($fetch_pin!=0){ echo "style='display:none;'"; } ?>>
							<label>Set Your UPI Pin</label>
							<input type="password" name="pin" value="<?php echo $pin; ?>">
							<p class="err"><?php echo $pinerr; ?></p>
							<p class="note-pin">Note: You need this pin to perform all of your transactions.</p>
							<label>Re-enter Your UPI Pin</label>
							<input type="password" name="conf-pin" value="<?php echo $confpin; ?>">
							<p class="err"><?php echo $confpinerr; ?></p>
							<label>Enter the UPI-Recovery Email</label>
							<input type="text" name="email" value="<?php echo $email; ?>">
							<p class="err"><?php echo $emailerr; ?></p>
							<input class="btn" type="submit" name="set" value="Set">
						</form>
						<div class="upi upi-success container-fluid" <?php if($fetch_pin==0){ echo "style='display:none;'"; } ?>>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4 success-icon">
									<i class="fa fa-check-circle"></i>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-8 success-cntn">
									<p>You Have already set a UPI.</p>
									<p>You can make transaction easily now...</p>
									<p>To change UPI <a href="<?php echo "changeupi.php?user=".$user."&user_id=".$user_id?>">Click here</a></p>
								</div>
							</div>
						</div>	
				</div>	
	</div>
</body>
</html>