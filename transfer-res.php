<?php session_start(); ?>
<?php require_once('function.php'); ?>
<?php require("deductions.php"); ?>
<?php require("session.php"); ?>
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
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
	<?php
        $con=mysqli_connect("localhost","root","","online_banking");
        $fetch_row=fetch("user","id='$user_id'")['row'];
        $name="";
        $upi="";
        $amount="";
        $nameerr="";
        $upierr="";
        $amounterr="";
        $count=0;
        $balance=$fetch_row['balance'];
        $pin=$fetch_row['pin'];
        $accno="";
        $ifsc="";
        $bank="";
        date_default_timezone_set('Asia/Kolkata');
        $schedule_date="";
        $schedule_time="";
        $schedule_date_err="";
        $schedule_time_err="";
		if(isset($_POST['transfer'])){
            $cur_time=date("H:i");
            $cur_date=date("Y-m-d");
			$schedule_date=$_POST['schedule_date'];
			$schedule_time=$_POST['schedule_time'];
			$name=$_POST['recipients'];
			$amount=$_POST['amount'];
			$upi=$_POST['upi-pin'];
            $receiver=$name;
            $receiver_row=fetch("user","username='$name'")['row'];
            $receiver_count=fetch("user","username='$name'")['count'];
            if($receiver_count!=0){
                $receiver=$receiver_row['id'];
            }   
            $recipient_row=fetch("recipients","own_by='$user_id'",'AND',"name='$name'")['row'];  //selecting recipients of equivalant form data
            // $recipient_count=count_row($recipient_row);
            if($recipient_row!=0){
            $accno=$recipient_row['accno'];
            $ifsc=$recipient_row['ifsc'];
            $bank=$recipient_row['bank'];
            }
    		if($name==""){
    			$nameerr="Please enter the Recipient's name";
    			$count=$count+1;
    		}

    		else
    	       if($recipient_row==""){
                $nameerr="You don't have this recipient in your list"; 
                $count=$count+1;
               }	      
    	   else{
                $nameerr="";
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
            if($schedule_date==""){
                $schedule_date_err="please pick schedule date";
                $count=$count=1;
            }

           else
            if(strtotime($schedule_date)<strtotime($cur_date)){ //changing dates into time stamp and preventing to select past days
                $schedule_date_err="Invalid date. Please select the valid date";
                $count=$count=1;
            }

            else{
                $schedule_date_err="";
            }
            if($schedule_time==""){
                $schedule_time_err="please pick time";
                $count=$count+1;
            }
            else
                if(strtotime($schedule_date)==strtotime($cur_date)&&strtotime($schedule_time)<strtotime($cur_time)){
                    $schedule_time_err="Invalid Time";
                    $count=$count+1;
                }
            else{
                $schedule_time_err="";
            }

    		if($count==0){
                $cur_time=date("H:i");
                $cur_date=date("Y-m-d");
                if($cur_time==$schedule_time&&$cur_date==$schedule_date){
                    $status="Success";
                    // $user_sql="SELECT * FROM user WHERE accno='$accno'";
                    // $user_res=mysqli_query($con,$user_sql);
                    // $user_row=mysqli_fetch_assoc($user_res);
                    update("user","balance=balance-$amount","id='$user_id'");
                    // $bal_update="UPDATE user SET balance=balance-$amount WHERE id='$user_id'";
                    // $res3=mysqli_query($con,$bal_update);
                    if($receiver_count!=0){
                        update("user","balance=balance+$amount","id='$receiver'");
                    }
                    
                     // $bal_update2="UPDATE user SET balance=balance+$amount WHERE accno='$accno'";
                     // $res4=mysqli_query($con,$bal_update2); 

                    // $notification_sql="INSERT INTO notification (title,content,post_date,post_time,sender,receiver) VALUES ('transaction','$amount','$schedule_date','$schedule_time','$user_id','$receiver_id')";
                    // $notification_res=mysqli_query($con,$notification_sql);

                    $notification_array=array("title"=>"transaction","content"=>$amount,"post_date"=>$schedule_date,"post_time"=>$schedule_time,"sender"=>$user_id,"receiver"=>$receiver);
                    $insert_sql=insert("notification",$notification_array); 
                    // echo $insert_sql;
                    // die();
                    $last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
                    $last_res=mysqli_query($con,$last_notification);
                    $last_notification_row=mysqli_fetch_assoc($last_res);
                    $last_notification_id=$last_notification_row['id'];
                    // $user_sql="SELECT * FROM user WHERE id='$user_id' OR id='$receiver_id'";
                    //  $user_res=mysqli_query($con,$user_sql);
                    $user_sql=fetch("user","id='$user_id'",'OR',"id='$receiver'");
                    $user_res=$user_sql['result'];
                    $user_row=$user_sql['row'];
                    $receiver_id=$user_row['id'];
                     do{
                        $receiver_id=$user_row['id'];
                        $log_array=array("notification_id"=>$last_notification_id,"user_id"=>$receiver_id);
                        insert("notification_log",$log_array);
                        // $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$receiver_id')";
                        // $log_res=mysqli_query($con,$log_sql);   
                     }while ($user_row=mysqli_fetch_assoc($user_res));

                }
                else{
                    $status="pending";
                }
                $available=fetch("user","username='$name'");
                $avaiable_row=$available['row'];
                $available_count=$available['count'];
             
                $transaction_array=array("sender_id"=>$user_id,"receiver"=>$receiver,"accno"=>$accno,"bank"=>$bank,"ifsc"=>$ifsc,"amount"=>$amount,"cur_date"=>$schedule_date,"cur_time"=>$schedule_time,"status"=>$status);
                insert("transaction",$transaction_array);
                // $sql2="INSERT INTO transaction (sender_id,receiver,accno,bank,ifsc,amount,cur_date,cur_time,status) VALUES ('$user_id','$name','$accno','$bank','$ifsc','$amount','$schedule_date','$schedule_time','$status')";
                // if(!$sql2){
                //     echo "query error";
                // }

                // $res2=mysqli_query($con,$sql2);
                // header("Refresh:0");
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

                        <a href="<?php echo 'recipient.php?user='.$user.'&user_id='.$user_id; ?>" class="btn btn-success pull-right recipient-btn">My Recipients</a>

						<form class="form-custom" method="POST" <?php if($pin==0){ echo "style='display:none;'"; } ?>> 	
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
							<!-- <p class="err"><?php echo $nameerr; ?></p> -->
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
                            <label>Schedule Your transfer</label>
                            <div class="schedule">
                            <input type="date" name="schedule_date" class="date" value="<?php echo $schedule_date; ?>" >
                            <p class="err"><?php echo $schedule_date_err; ?></p>
                            <input type="time" name="schedule_time" class="time" value="<?php echo $schedule_time; ?>">
                            <p class="err"><?php echo $schedule_time_err; ?> </p>
                            </div>
							<input class="btn" type="submit" name="transfer" value="Transfer">
						</form>	
				</div>	
	</div>
</body>
</html>
								