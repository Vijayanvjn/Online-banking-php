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
    $user_id=$_GET['user_id'];
    $con=mysqli_connect("localhost","root","","online_banking");
    // $sql="SELECT * FROM user WHERE id='$user_id'";
    // $res=mysqli_query($con,$sql);
    // $row=mysqli_fetch_assoc($res);
    $row=fetch("user","id='$user_id'")['row'];
    $pin=$row['pin'];

    ?>  
	
    <?php
		$accno="";
		$accname="";
		$amount="";
		$count=0;
		$accnoerr="";
		$accnameerr="";
		$amounterr="";
		$ifscerr="";	
		$bank="";
		$upi="";
		$upierr="";
		$balance=$row['balance'];
		$pin=$row['pin'];
		$ifsc="";
		$ifsc_generated="";
		if(isset($_POST['transfer'])){
            date_default_timezone_set('Asia/Kolkata');
			$date=date("Y-m-d");
			$time=date("h:i:a");
			$accno=$_POST['accno'];
			$accname=$_POST['accname'];
			$amount=$_POST['amount'];
			$bank=$_POST['bank'];
			$ifsc=$_POST['ifsc'];
			$upi=$_POST['upi-pin'];
			// $ifsc_generated=strtoupper(substr($bank,0,3).substr($accno,-4,4));
			if($accno==""){
				$accnoerr="Please enter the account Number";
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
    		if($accname==""){
    			$accnameerr="Please enter the account holder name";
    			$count=$count+1;
    		}

    		else
    			if(!preg_match("/^[A-Za-z]*$/", $accname)){
    				$accnameerr="Name should not contain character";
    				$count=$count+1;
    			}

    		else{
    			$accnameerr="";
    		}
    		if($amount==""){
    			$amounterr="Please enter the amount";
    			$count=$count+1;
    		}
    		else

    		if(!preg_match("/^[0-9]*$/",$amount)){
    			$amounterr="Amount should not be  character";
    			$count=$count+1;
    		}
    		else
    			if($amount>$balance){
    				$amounterr="You don't have enough balance";
    				$count=$count+1;
    			}
    		else
    			if($amount>10000){
    				$amounterr="Can't send amount greater than 10000 at a same time";
    				$count=$count+1;
    			}
    		else{
    			$amounterr="";
    		}
    		if($ifsc==""){
    			$ifscerr="Please enter ifsc code";
    			$count=$count+1;
    		}
    		else
    			if(substr($accno,-4,4)!=substr($ifsc, -4,4)){
    				$ifscerr="Ifsc invalid";
    				$count=$count+1;
    			}
    		else{
    			$ifscerr="";
    		}
    		if($upi==""){
    				$upierr="Please enter Your UPI Pin";
    				$count=$count+1;
    		}
    		else{
    			if($upi!=$pin){
    				$upierr="Incorrect UPI-Pin";
    				$count=$count+1;
    			}
    			else{
    				$upierr="";
    			}
    		}
    		if($count==0){
                // $bal_update="UPDATE user SET balance=balance-$amount WHERE id='$user_id'";
                update("user","balance=balance-$amount","id='$user_id'");
                $transaction_array=array("sender_id"=>$user_id,"receiver"=>$accno,"accno"=>$accno,"bank"=>$bank,"ifsc"=>$ifsc,"amount"=>$amount,"cur_date"=>$date,"cur_time"=>$time,"status"=>"success");
                insert("transaction",$transaction_array);
                // $sql2="INSERT INTO transaction (sender_id,receiver,accno,bank,ifsc,amount,cur_date,cur_time) VALUES ('$user_id','$accname','$accno','$bank','$ifsc','$amount','$date','$time')";
                // if(!$sql2){
                // 	echo "query error";
                // }
                // $res2=mysqli_query($con,$sql2);
                // $res3=mysqli_query($con,$bal_update);
                update("user","balance=balance+$amount","accno='$accno'");
                // $bal_update2="UPDATE user SET balance=balance+$amount WHERE accno='$accno'";
                // $res4=mysqli_query($con,$bal_update2);
                $user_row=fetch("user","accno='$accno'")['row']; //fetching for selected account details
                // $user_sql="SELECT * FROM user WHERE accno='$accno'";
                //     $user_res=mysqli_query($con,$user_sql);
                //     $user_row=mysqli_fetch_assoc($user_res);
                $receiver_id=$user_row['id'];
               $notification_array=array("title"=>"transaction","content"=>$amount,"post_date"=>$date,"post_time"=>$time,"sender"=>$user_id,"receiver"=>$receiver_id);
                $insert_sql=insert("notification",$notification_array); 

                // $notification_sql="INSERT INTO notification (title,content,post_date,post_time,sender,receiver) VALUES ('transaction','$amount','$date','$time','$user_id','$receiver_id')";
                //     $notification_res=mysqli_query($con,$notification_sql);
                $last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
                 $last_res=mysqli_query($con,$last_notification);
                 $last_notification_row=mysqli_fetch_assoc($last_res);
                 $last_notification_id=$last_notification_row['id'];

                 $user2_sql=fetch("user","id='$user_id'",'OR',"id='$receiver_id'");
                 $user2_res=$user2_sql['result'];
                 $user2_row=$user2_sql['row'];
                 $user2_count=$user2_sql['count'];
                 // $user_sql="SELECT * FROM user WHERE id='$user_id' OR id='$receiver_id'";
                 // $user_res=mysqli_query($con,$user_sql);
                 if($user2_count!=0){
                    do{
                    $receiver_id=$user2_row['id'];
                    // $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$receiver_id')";
                    // $log_res=mysqli_query($con,$log_sql);   
                     $log_array=array("notification_id"=>$last_notification_id,"user_id"=>$receiver_id);
                     insert("notification_log",$log_array);
                    }while ($user2_row=mysqli_fetch_assoc($user2_res));    
                 }
                
                if(isset($_GET['status'])){
                	$req_id=$_GET['req_id'];
                    delete("message","id='$req_id'");
                	// $req_pay_sql="DELETE FROM message WHERE id='$req_id'";
                	// $req_pay_res=mysqli_query($con,$req_pay_sql);
                }	
    			header("savings_home.php?user=$user&user_id=$user_id");
    		}
    		}
	?>
	<div class="transfer">
				<?php include "sidemenu.php" ?>
				<div class="body-cntn">
					<?php include "header.php" ?>
					<div class="upi upi-warning container-fluid" <?php if($pin!=0){ echo "style='display:none;'"; } ?>>
							<div class="row">
								<div class="col-md-4 success-icon">
									<i class="fa fa-check-circle"></i>
								</div>
								<div class="col-md-8 success-cntn">
									<p>You should set UPI-Pin to transfer money</p>
									<p>To Set UPI <a href="<?php echo "upi.php?user=".$user."&user_id=".$user_id?>">Click here</a></p>
								</div>
							</div>
						</div>
						<form class="form-custom" method="POST" <?php if($pin==0){ echo "style='display:none;'"; } ?>>
							<label>Account Number</label>
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

							<label>Your UPI-Pin</label>
							<input type="password" name="upi-pin">
							<p class="err"><?php echo $upierr; ?></p>

							<input class="btn" type="submit" name="transfer" value="Transfer">
						</form>	
				</div>	
	</div>
</body>
</html>
								