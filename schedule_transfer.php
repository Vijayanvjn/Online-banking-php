<?php require_once('function.php'); ?>
<?php
	date_default_timezone_set("Asia/Kolkata");
	$current_time=date("H:i");
	$current_date=date("Y-m-d");
	$con=mysqli_connect("localhost","root","","online_banking");
	$schedule_sql=fetch("transaction","status='pending'");
	$schedule_res=$schedule_sql['result'];
	$row=$schedule_sql['row'];
	$count=$schedule_sql['count'];
	$user_id=$_GET['user_id'];
	if($count!=0){

		do{
		$schedule_time=$row['cur_time'];
		$schedule_date=$row['cur_date'];
		$sender_id=$row['sender_id'];
		$receiver=$row['receiver'];
		$transaction_id=$row['id'];
		$amount=$row['amount'];
		$accno=$row['accno'];
		$balance_all=fetch("user","id='$sender_id'")['row'];
		$balance=$balance_all['balance'];
			if($balance>$amount){
			if($schedule_time==$current_time&&$schedule_date==$current_date){
				update("user","balance=balance+$amount","id='$sender_id'");
				update("user","balance=balance-$amount","id='$receiver'");
				// $balance_update="UPDATE user SET balance=balance-$amount WHERE id='$sender_id'";
    //             $balance_res=mysqli_query($con,$balance_update);
                // $bal_update2="UPDATE user SET balance=balance+$amount WHERE accno='$accno'";
                // $res4=mysqli_query($con,$bal_update2); 
                update("transaction","status='Success'","id='$transaction_id'");
                // $status_update="UPDATE transaction SET status='Success' WHERE id='$transaction_id'";
                // $status_res=mysqli_query($con,$status_update);
                $notification_array=array("title"=>"transaction","content"=>$amount,"post_date"=>$schedule_date,"post_time"=>$schedule_time,"sender"=>$sender_id,"receiver"=>$receiver);
				insert("notification",$notification_array);
				$last_notification="SELECT * FROM notification ORDER BY id DESC LIMIT 1";
                    $last_res=mysqli_query($con,$last_notification);
                    $last_notification_row=mysqli_fetch_assoc($last_res);
                    $last_notification_id=$last_notification_row['id'];
                    // $user_sql="SELECT * FROM user WHERE id='$user_id' OR id='$receiver_id'";
                    //  $user_res=mysqli_query($con,$user_sql);
                    $user_sql=fetch("user","id='$user_id'",'OR',"id='$receiver'");
                    $user_res=$user_sql['result'];
                    $user_row=$user_sql['row'];
                    $user_count=$user_sql['count'];
                    if($user_count!=0){
                    	$receiver_id=$user_row['id'];
                     do{
                        $receiver_id=$user_row['id'];
                        $log_array=array("notification_id"=>$last_notification_id,"user_id"=>$receiver_id);
                        insert("notification_log",$log_array);
                        // $log_sql="INSERT INTO notification_log (notification_id,user_id) VALUES ('$last_notification_id','$receiver_id')";
                        // $log_res=mysqli_query($con,$log_sql);   
                     }while($user_row=mysqli_fetch_assoc($user_res));
                   }
                    
				}	
		}

		else{
				update("transaction","status='Transaction failed due to low balance'","id='$transaction_id'");
			}	
		
	}while ($row=mysqli_fetch_assoc($schedule_res));
			
	}
	// $schedule_sql="SELECT * FROM transaction WHERE status='pending'";
	// $schedule_res=mysqli_query($con,$schedule_sql);
	
?>