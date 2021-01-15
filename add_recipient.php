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
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/media.css" />
    <link rel="stylesheet" type="text/css" href="css/transfer.css" />
    <link rel="stylesheet" type="text/css" href="css/recipient.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
	$con=mysqli_connect("localhost","root","","online_banking");
	$name="";
	$accno="";
	$ifsc="";
	$bank="";
	$nameerr="";
	$accnoerr="";
	$ifscerr="";
	$bankerr="";
	$count=0;
	$sql=
	// $sql="SELECT * FROM user WHERE id='$user_id'";
 //    $res=mysqli_query($con,$sql);
 //    $row=mysqli_fetch_assoc($res);
	$row=fetch("user","id='$user_id'")['row'];
	if(isset($_POST['add'])){
		$name=$_POST['name'];
		$accno=$_POST['accno'];
		$ifsc=$_POST['ifsc'];
		$bank=$_POST['bank'];
		$recipient_count=fetch("recipients","own_by='$user_id'",'AND',"name='$name'")['count'];
		// $rec_sql="SELECT * FROM recipients WHERE own_by='$user_id' AND name='$name'";
		// $rec_res=mysqli_query($con,$rec_sql);
		// $generated_ifsc=strtoupper(substr($bank,0,3).substr($accno,-4,4));
		if($name==""){
			$nameerr="Please enter the name";
			$count=$count+1;
		}
		else
			if($recipient_count!=0){
				$nameerr="You have this recipient name already";
				$count=$count+1;
			}
		else{
			$nameerr="";
		}
		if($accno==""){
			$accnoerr="Please enter the account number";
			$count=$count+1;
		}
		else
			if(!preg_match("/^[0-9]{16}$/", $accno)){
                    $accnoerr="Invalid Account Number";
                    $count=$count+1;
                }
         else
            	if($accno==$row['accno']){
            		$accnoerr="This is your account Number!";
            		$count=$count+1;
            	}
		else{
			$accnoerr="";
		}
		if($ifsc==""){
			$ifscerr="Please enter the ifsc code";
			$count=$count+1;
		}
		else
			if(substr($accno,-4,4)!=substr($ifsc, -4,4)){
				$ifscerr="Invalid IFSC";
				$count=$count+1;
			}
		else{
			$ifscerr="";
		}
		if($count==0){
			$recipient_array=array("accno"=>$accno,"ifsc"=>$ifsc,"bank"=>$bank,"name"=>$name,"own_by"=>$user_id);
			insert("recipients",$recipient_array);
			// $add_sql="INSERT INTO recipients (accno,ifsc,bank,name,own_by) VALUES ('$accno','$ifsc','$bank','$name','$user_id')";
			// $add_res=mysqli_query($con,$add_sql);

		}
	}
	?>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<form class="form-custom" method="POST">
							<label>Name</label>
							<input type="text" name="name" value="<?php echo $name; ?>">
							<p class="err"><?php echo $nameerr; ?></p>
							<label>Account Number</label>
							<input type="text" name="accno" value="<?php echo $accno; ?>">
							<p class="err"><?php echo $accnoerr; ?></p>
							<label>Bank</label>
							<select name="bank">
								<option value="local" <?php if($bank=="local"){ echo "selected"; } ?>>Local bank</option>
								<option value="canara" <?php if($bank=="canara"){ echo "selected"; } ?>>Canara Bank</option>
								<option value="icici" <?php if($bank=="icici"){ echo "selected"; } ?>> ICICI Bank</option> 
							</select>
							<label>IFSC Code</label>
							<input type="text" name="ifsc" value="<?php echo $ifsc; ?>">
							<p class="err"><?php echo $ifscerr; ?></p>
							<input class="btn" type="submit" name="add" value="Add">
					</form>
					
				</div>	
	</div>
</body>
</html>