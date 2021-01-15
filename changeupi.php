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
		$row=fetch("user","id='$user_id'");
		// $sql="SELECT * FROM user WHERE id='$user_id'";
		// $res=mysqli_query($con,$sql);
		// $row=mysqli_fetch_assoc($res);
		$curpin="";
		$pin="";
		$confpin="";
		$curpinerr="";
		$pinerr="";
		$confpinerr="";
		$count=0;
		if(isset($_POST['change'])){
			$curpin=$_POST['cur-pin'];
			$pin=$_POST['pin'];
			$confpin=$_POST['conf-pin'];
			if($curpin==""){
				$curpinerr="Please enter Your current pin";
				$count=$count+1;
			}
			else
				if($curpin!=$row['pin']){
				 	$curpinerr="Please enter the correct pin";
				 	$count=$count+1;
				 }
			else{
				$curpinerr="";
			}
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
			if($count==0){
				update("user","pin='$pin'","id='$user_id'");
				// $sql="UPDATE user SET pin='$pin' WHERE id='$user_id'";
				// $res=mysqli_query($con,$sql);
				header("Refresh:0");
			}
		}
	?>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
						<form class="form-custom" method="POST">
							<label>Enter Your Current Pin</label>
							<input type="text" name="cur-pin" value="<?php echo $curpin; ?>">
							<p class="err"><?php echo $curpinerr; ?></p>
							<label>Enter New Pin</label>
							<input type="password" name="pin" value="<?php echo $pin; ?>">
							<p class="err"><?php echo $pinerr; ?></p>
							<label>Re-enter New Pin</label>
							<input type="password" name="conf-pin" value="<?php echo $confpin; ?>">
							<p class="err"><?php echo $confpinerr; ?></p>
							<input class="btn" type="submit" name="change" value="Change">
						</form>	
				</div>	
	</div>
</body>
</html>