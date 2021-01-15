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
	
	<?php
		$con=mysqli_connect("localhost","root","","online_banking");
		$count=0;
		$recipient="";
		$amount="";
		$message="";
		$amounterr="";
		$messageerr="";
		$recipienterr="";
		if(isset($_POST['request'])){
			$recipient=$_POST['recipients'];
			$amount=$_POST['amount'];
			$message=$_POST['message'];
			$myrow=fetch("user","id='$user_id'")['row'];
			$myname=$myrow['username'];
			$avail_count=fetch("user","username='$recipient'")['count'];
			$avail_row=fetch("user","username='$recipient'")['row'];
			// $mysql="SELECT * FROM user WHERE id='$user_id'";
			// $myres=mysqli_query($con,$mysql);
			// $myrow=mysqli_fetch_assoc($myres);
			// $sql="SELECT * FROM user WHERE accno='$accno'";
			// $res=mysqli_query($con,$sql);
			// $row=mysqli_fetch_assoc($res);
			if($avail_count==0){
				$recipienterr="You can't give request for this user";
				$count=$count+1;
			}
			if($amount==""){
				$amounterr="Please enter the amount";
				$count=$count+1;
			}
			else
				if($amount>10000){
					$amounterr="Request amount should be under 10000";
					$count=$count+1;
				}
				else{
					$amounterr="";
				}
			if($count==0){
				date_default_timezone_set("Asia/Kolkata");
				$request_time=date('h:i:a');
				$request_date=date('Y-m-d');
				$recipient=$avail_row['id'];
				$message_array=array("recipient"=>$recipient,"amount"=>$amount,"message"=>$message,"requester_id"=>$user_id);
                insert("message",$message_array); 
                $notification_array=array("title"=>"Request","content"=>$myname." Requested for Rs. ".$amount,"post_date"=>$request_date,"post_time"=>$request_time,"sender"=>$user_id,"receiver"=>$recipient);
				insert("notification",$notification_array);
				$last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
             	$last_res=mysqli_query($con,$last_notification);
             	$last_notification_row=mysqli_fetch_assoc($last_res);
             	$last_notification_id=$last_notification_row['id'];
             	$log_array=array("notification_id"=>$last_notification_id,"user_id"=>$recipient);
				insert("notification_log",$log_array);
				header("Refresh:0");
			}
		}
	?>
	<div>
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
						<a href="<?php echo 'received_request.php?user_id='.$user_id.'&user='.$user; ?>" class="btn btn-primary received-btn">Received Requests</a>
						<form class="form-custom" method="POST">
							<label>Select Recipient</label>
							<select name="recipients" value="recipients">
								<?php
									$recipient_sql=fetch("recipients","own_by='$user_id'");
									$recipient_res=$recipient_sql['result'];
									$recipient_count=$recipient_sql['count'];
									$recipient_row=$recipient_sql['row'];
									if($recipient_count!=0){
										do{

											$recipient_name=$recipient_row['name'];
											echo "<option name='$recipient_name selected'>".$recipient_name."</option>";	
											}while($recipient_row=mysqli_fetch_assoc($recipient_res));
									}
								?>
							</select>
							<p class="err"><?php echo $recipienterr; ?></p>
							<!-- <input type="text" name="accno" value="<?php echo $accno; ?>"> -->
							<label>Amount</label>
							<input type="text" name="amount" placeholder="Rs." value="<?php echo $amount; ?>">
							<p class="err"><?php echo $amounterr; ?></p>
							<label>Message</label>
							<textarea  rows="5" cols="20" placeholder="Message" name="message"><?php echo $message; ?></textarea>
							<input class="btn" type="submit" name="request" value="Request">
						</form>	
				</div>	
	</div>
</body>
</html>